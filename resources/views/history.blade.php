@extends('layout')
@section('content')
    {{$uuid}}
    <table>
        <tr><th>ip:port</th><th>protocol</th><th>country/city</th><th>status</th><th>download speed</th><th>timeout</th><th>real ip</th></tr>
        @foreach($proxyList as $proxyItem)
            @foreach($proxyItem->results as $result)
            <tr>
                <td>{{$proxyItem->ip}}:{{$proxyItem->port}}</td>
                <td>{{$result->protocol}}</td>
                <td>{{$proxyItem->country}}/{{$proxyItem->city}}</td>
                <td>{{$result->status}}</td>
                <td>{{$result->speed}}</td>
                <td>{{$result->timeout}}</td>
                <td>{{$result->realip}}</td>
            </tr>
            @endforeach
        @endforeach
    </table>
@endsection
