<?php

namespace App\Http\Controllers;

use App\Interfaces\BatchLinkCkecker;
use App\Models\ProxyServer;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ProxyCheckerController extends Controller
{

    public function __construct(private readonly BatchLinkCkecker $checkProxiesService)
    {}
    public function index(Request $request)
    {
        if(empty($request->session()->get('user_uuid'))){
            $request->session()->put('user_uuid',Str::uuid()->toString());
        }
        $result = $this->checkProxiesService->run($request->post('proxyList'));
        return view('main')->with(['title'=>'Check your proxy ','proxyList'=>$result]);
    }

    public function check(Request $request)
    {

    }

    public function history(Request $request){
        if(empty($request->session()->get('user_uuid'))){
            redirect('main');
        }

        $result = ProxyServer::with(['results'=>function (Builder $query) {
            $query->where('user_uuid', Session::get('user_uuid'));
        }])->get();
        return view('history')->with(['title'=>'Check history ','proxyList'=>$result,'uuid'=>$request->session()->get('user_uuid')]);
    }
}
