@extends('layouts.app')
@section('content')
    <table class="table table-striped task-table">
        <tbody>
        <tr>
            <td><a href="/deposit?yn=y">입금완료</a></td>
            <td><a href="/deposit?yn=n">입금확인중</a></td>
        </tr>
        </tbody>
    </table>
    <form action="/deposit" method="get" class="form-horizontal">
    <span>
        <select name="user_id">
            <option value="0" @if($user_id == 0)selected @endif>발송자</option>
            <option value="1" @if($user_id == 1)selected @endif>양주성</option>
            <option value="3" @if($user_id == 3)selected @endif>허순례</option>
        </select>
    </span>
        <span>
        <select name="shop_code">
            @foreach($codelist_shop as $codelist_shop)
            <option value="{{$codelist_shop->code}}">{{$codelist_shop->content}}</option>
            @endforeach
        </select>
    </span>
    <span>
        <button type="submit" class="btn btn-default">
            <i class="fa fa-plus"></i>검색
        </button>
    </span>
    </form>
    <!-- Bootstrap Boilerplate... -->
    <form action="/event" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($addresses) > 0)
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>연락처</th>
                        <th>발송예정일</th>
                        <th>입금여부</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($addresses as $address)
                        <tr>
                            <td class="table-text">
                                <a href="/deposit/{{$address->id}}">
                                    {{ $address->addr_send_name }}
                                </a>
                            </td>
                            <td class="table-text">
                                <a href="/deposit/{{$address->id}}">
                                    {{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}</a>
                            </td>
                            <td class="table-text">
                                <a href="/deposit/{{$address->id}}">{{ $address->addr_send_date }}</a>
                            </td>
                            <td>
                                @if( $address->deposit_yn == 'y')입금완료
                                @else확인중
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>
        <div align="center">
        </div>
        </table>
    </form>
    <br>
@endsection
