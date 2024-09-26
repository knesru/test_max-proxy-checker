<?php

namespace App\Services;

use App\Interfaces\BatchLinkCkecker;
use App\Interfaces\GeoIpInterface;
use App\Models\ProxyResult;
use App\Models\ProxyServer;

class CheckProxiesService implements BatchLinkCkecker
{

    const LINES_SEPARATOR = "\n";
    const ADDRESS_SEPARATOR = ":";

    public function __construct(private GeoIpInterface $geoIp)
    {
    }

    public function run($linksString){
        if(is_null($linksString)){
            return [];
        }


        $proxies = $this->sliceString($linksString);
        $fullInfo = [];



        $batch = $this->checkBatchGenerator($proxies, self::config('url_checks'), self::config('protocols'));
        do {
            $multiHandle = curl_multi_init();
            for ($threadN = 0; $threadN < self::config('batch_size'); $threadN++) {
                $handle = $batch->current();
                if(!$handle){
                    break;
                }
                curl_multi_add_handle($multiHandle, $handle);
//                $fullInfo[$proxies [$threadN]] = ['status' => 'pending'];
                $batch->next();
            }


            $fullInfo301 = [];

            do {
                while (($execrun = curl_multi_exec($multiHandle, $running)) == CURLM_CALL_MULTI_PERFORM) ;
                if ($execrun != CURLM_OK) break;
                while ($done = curl_multi_info_read($multiHandle)) {
                    $info = curl_getinfo($done ['handle']);
//                    $key = array_search($done['handle'], $c);
                    $fullInfo[] = $info;
//                    $fullInfo[$proxies [$key]]['status'] = 'ok';
//                    if ($info ['http_code'] == 301) {
//                        $fullInfo301[] = trim($proxies [$key]) . "\r\n";
//                        $fullInfo[$proxies [$key]]['status'] = 301;

//                    }
                    curl_multi_remove_handle($multiHandle, $done ['handle']);
                }
            } while ($running);
            curl_multi_close($multiHandle);
        } while ($handle);

        foreach ($fullInfo as $key=>$proxyInfo){
//            if($fullInfo[$key]['status']=='pending') {
//                $fullInfo[$key]['status'] = 'fail';
//            }
        }

        return $fullInfo;
    }

    private function sliceString($linksString): array
    {
        //Explode by newline
        $lines = explode(self::LINES_SEPARATOR, $linksString);
        return $lines;
//        return array_map(function($line){
//            return explode(self::ADDRESS_SEPARATOR, $line);
//        }, $lines);
    }

    private function checkBatchGenerator($addresses, $urls, $proxyTypes){
        foreach ($proxyTypes as $proxyType){
            foreach ($addresses as $address){
                foreach ($urls as $url){
                    $proxy = new ProxyServer();
                    $proxy->setAddress($address);
                    $existingProxy = ProxyServer::where([
                        ['ip', '=', $proxy->ip],
                        ['port', '=', $proxy->port],
                    ])->first();

                    if(!$existingProxy){
                        $geoip = $this->geoIp->get($proxy->ip);
                        $proxy->city = $geoip['city'];
                        $proxy->country = $geoip['country'];
                        $existingProxy = $proxy;
                        $existingProxy->save();
                    }
                    $result = new ProxyResult();
                    $result->proxyId = $existingProxy->id;
                    $result->status = 'pending';
                    $result->protocol = match ($proxyType) {
                        CURLPROXY_HTTP => 'HTTP',
                        CURLPROXY_HTTP_1_0 => 'HTTP1.0',
                        CURLPROXY_HTTPS => 'HTTPS',
                        CURLPROXY_SOCKS4 => 'SOCKS4',
                        CURLPROXY_SOCKS4A => 'SOCKS4A',
                        CURLPROXY_SOCKS5 => 'SOCKS5',
                        default=> 'forget to add protocol: '.$proxyType
                    };
                    $result->url = $url;
                    $result->save();

                    $handler = curl_init();
                    curl_setopt ($handler, CURLOPT_URL, $url);
                    curl_setopt ($handler, CURLOPT_HEADER, 0);
                    curl_setopt ($handler, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt ($handler, CURLOPT_CONNECTTIMEOUT, config('proxy_service.timeouts.connection'));
                    curl_setopt ($handler, CURLOPT_TIMEOUT, config('proxy_service.timeouts.total'));
                    curl_setopt ($handler, CURLOPT_PROXY, trim ($address));
                    curl_setopt ($handler, CURLOPT_PROXYTYPE, $proxyType);
                    yield $handler;
                }
            }
        }
    }

    private static function config($key)
    {
        return config('proxy_service.' . $key);
    }
}
