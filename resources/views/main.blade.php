@extends('layout')
@section('content')
    <form method="post">
        @csrf
        <div class="form-row"> <label for="proxyList">Proxy list. Format ip:port</label><textarea id="proxyList" name="proxyList"></textarea></div>
        <div class="form-footer"> <button type="submit" id="sendForm">Check</button></div>
    </form>
    <div class="result">
{{--        <ul>--}}

{{--        @foreach($proxyList as $proxyItem)--}}
{{--            <li>{{print_r($proxyItem, 1)}}</li>--}}
{{--        @endforeach--}}
{{--        </ul--}}{{----}}{{-->--}}
        <pre>
        @php
            print_r($proxyList);
        @endphp
        </pre>
        <hr />
    </div>
@endsection
