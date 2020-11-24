@extends('layouts.app')
@section('content')
    <style>
        .date-gubun
        {
            margin: 0;
            display:inline;
            outline:none;
        }
    </style>
    <form action="/invoice" method="get" class="form-horizontal">
    <table class="table table-striped task-table">
        <tbody>
        <tr>
            <td><a href="/invoice">전체</a></td>
            <td><a href="?status=1">발송준비</a></td>
            <td><a href="?status=2">발송완료</a></td>
        </tr>
        </tbody>
    </table>
        <div>
            <span>
                <select name="status">
                <option value="0" @if($status == 0)selected @endif>발송상태</option>
                <option value="1" @if($status == 1)selected @endif>발송준비</option>
                <option value="2" @if($status == 2)selected @endif>발송완료</option>
                </select>
            </span>
            <span>
                <select name="user_id">
                    <option value="0" @if($user_id == 0)selected @endif>발송자</option>
                    <option value="1" @if($user_id == 1)selected @endif>양주성</option>
                    <option value="3" @if($user_id == 3)selected @endif>허순례</option>
                </select>
            </span>
            <span>
                <select name="gubun">
                    <option value="0" @if($gubun == 0)selected @endif>발송구분</option>
                    <option value="1" @if($gubun == 1)selected @endif>판매</option>
                    <option value="2" @if($gubun == 2)selected @endif>이벤트</option>
                </select>
            </span>
            <span>
                <input type="date" class="date-gubun" name="s_date" id="s_date" style="width:150px;" class="form-control" value="@if($s_date){{$s_date}}@else<?php echo date("Y-m-01");?>@endif"> ~
                <input type="date" class="date-gubun" name="e_date" id="e_date" style="width:150px;" class="form-control" value="@if($e_date){{$e_date}}@else<?php echo date("Y-m-d");?>@endif">
            </span>
            <span>
                <input type="text" class="date-gubun" name="name" id="name" style="width:50px;" class="form-control">
            </span>
            <span>
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i>검색
            </button>
            </span>
            <span>
                검색결과 : @foreach($sum_boxs as $sum_box){{$sum_box->product_name}} {{$sum_box->addr_amount}}box -> {{$sum_box->amount}}개 @endforeach
            </span>
        </div>
    </form>
    <!-- Bootstrap Boilerplate... -->
    <form action="/invoice/send" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
        @csrf
                @if (count($addresses) > 0)
                    <table class="table table-striped">
                        <!-- Table Headings -->
                        <thead>
                        <tr>
                            <th>이름</th>
                            <th>연락처</th>
                            <th>발송예정일</th>
                            <th>발송장</th>
                        </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                        @foreach ($addresses as $address)
                            <tr @if($address->addr_send_date > date("Y-m-d"))class="bg-danger"@endif>
                                <td>
                                    <a href="/invoice/{{$address->id}}">
                                    {{ $address->addr_send_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/invoice/{{$address->id}}">
                                        {{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}</a>
                                </td>
                                <td>
                                    <a href="/invoice/{{$address->id}}">{{ $address->addr_send_date }}</a>
                                </td>
                                <td>
                                    @if($address->label_yn == 'n') 
                                        등록중
                                    @elseif( $address->addr_status == 1)
                                    {{$address->courier_name}} <input type="text" name="send_num[{{$address->id}}]">
                                    @else{{$address->addr_send_jang}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </table>
        </table>
    <div class="flex justify-between">
        <button type="submit" class="bg-transparent w-20 text-sm hover:bg-blue-500 text-green-700 font-semibold hover:text-black py-2 mt-3 mr-3 px-4 border border-blue-500 hover:border-transparent rounded">
            발송
        </button>
        <a href="/address?addr_gubun=1" class="bg-transparent w-20 text-sm hover:bg-blue-500 text-blue-700 font-semibold hover:text-black py-2 mt-3 mr-3 px-4 border border-blue-500 hover:border-transparent rounded">
            등록
        </a>
    </div>
    </form>
@endsection
