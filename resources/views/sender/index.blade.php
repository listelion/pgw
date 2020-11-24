@extends('layouts.app')
@section('content')
    <form action="/sender" method="get" class="form-horizontal">
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
        </div>
    </form>
    <!-- Bootstrap Boilerplate... -->
    <form action="/sender" method="post" class="form-horizontal">
        @csrf
        @if (count($senders) > 0)
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
                @foreach ($senders as $sender)
                    <tr @if($sender->addr_send_date > date("Y-m-d"))class="bg-danger"@endif>
                        <td>
                            <a href="/sender/{{$sender->id}}">
                            {{ $sender->addr_send_name }}
                            </a>
                        </td>
                        <td>
                            <a href="/sender/{{$sender->id}}">
                                {{ $sender->addr_send_num1}}-{{ $sender->addr_send_num2}}-{{ $sender->addr_send_num3}}</a>
                        </td>
                        <td>
                            <a href="/sender/{{$sender->id}}">{{ $sender->addr_send_date }}</a>
                        </td>
                        <td>
                            @if($sender->label_yn == 'n') 등록중
                            @elseif( $sender->addr_status == 1)발송준비
                                @else{{$sender->addr_send_jang}}
                                @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </form>
    <br>
    <a class="btn btn-link" href="/sender?addr_gubun=1">
        등록
    </a>

@endsection
