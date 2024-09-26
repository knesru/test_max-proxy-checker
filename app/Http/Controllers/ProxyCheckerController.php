<?php

namespace App\Http\Controllers;

use App\Interfaces\BatchLinkCkecker;
use App\Models\ProxyServer;
use Illuminate\Http\Request;

class ProxyCheckerController extends Controller
{

    public function __construct(private readonly BatchLinkCkecker $checkProxiesService)
    {}
    public function index(Request $request)
    {
        $result = $this->checkProxiesService->run($request->post('proxyList'));
        return view('main')->with(['title'=>'Check your proxy '/*.count($result)*/,'proxyList'=>$result]);
    }

    public function check(Request $request)
    {
//        $result = $this->checkProxiesService->run($request->post('proxyList'));
//        print 'xxx';
    }
}
