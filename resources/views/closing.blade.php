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
    <form action="/closing" method="get" class="form-horizontal">
      <div>
            <span>
                <select name="mode">
                <option value="1" @if($mode == 1)selected @endif>일자별</option>
                <option value="2" @if($mode == 2)selected @endif>쇼핑몰별</option>
                </select>
            </span>
        <span>
            <select name="user_id">
                <option value="0" @if($user_id == 0)selected @endif>판매자</option>
                @foreach($user_list as $user_list)
                <option value="{{$user_list->id}}" @if($user_list->id == $user_id) selected @endif >{{$user_list->name}}</option>
                @endforeach
            </select>
        </span>
        <span>
            <select name="gubun">
                <option value="0" @if($gubun == 0)selected @endif>구분</option>
                @foreach($codelist_gubun as $codelist_gubun)
                    <option value="{{$codelist_gubun->code}}" @if($codelist_gubun->code == $gubun) selected @endif >{{$codelist_gubun->content}}</option>
                @endforeach
            </select>
        </span>
        <span>
              <input type="date" class="date-gubun" name="s_date" id="s_date" style="width:150px;" class="form-control" value="@if($s_date){{$s_date}}@else<?php echo date("Y-m-d");?>@endif"> 부터 ~
              <input type="date" class="date-gubun" name="e_date" id="e_date" style="width:150px;" class="form-control" value="@if($e_date){{$e_date}}@else<?php echo date("Y-m-d");?>@endif">
        </span>
        <span>
            <button type="submit" class="btn btn-default">
                <i class="fa fa-plus"></i>검색
            </button>
            </span>
        </div>
    </form>
    <table class="panel-body">
    @csrf
    @if($mode == 1)
        <table class="type08">
            <thead>
            <tr>
                <th scope="col">일자</th>
                <th scope="col">항목</th>
                <th scope="col">매출</th>
                <th scope="col">지출</th>
                <th scope="col">합계</th>
            </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
            @if (count($closings) > 0)
                @foreach ($closings as $closing)
                    <tr>
                        <td class="@if(is_null($closing->gubun) == 1) value @endif">{{$closing->date}}</td>
                        <td class="@if(is_null($closing->gubun) == 1) value @endif">{{$closing->gubun}}</td>
                        @if($closing->value >= 0)
                            <td class="@if(is_null($closing->gubun) == 1) value @endif">{{$closing->value}}</td>
                        @endif
                        <td class="@if(is_null($closing->gubun) == 1) value @endif"></td>
                        @if($closing->value < 0)
                            <td class="@if(is_null($closing->gubun) == 1) value @endif">{{$closing->value}}</td>
                        @endif
                        <td class="@if(is_null($closing->gubun) == 1) value @endif">{{$closing->value}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    @endif
    @if($mode == 2)
    <table class="table table-striped task-table">
        <thead>
            <tr>
                <th>쇼핑몰</th>
                <th>합계</th>
                <th>판매비율</th>
            </tr>
        </thead>
            <!-- Table Body -->
        <tbody>
            @if (count($closings) > 0)
                @foreach ($closings as $closing)
                    <tr>
                        <td class="table-text">{{ $closing->shop }}</td>
                        <td class="table-text">{{$closing->value}}</td>
                        <td class="table-text">{{round((int)str_replace(',', '', $closing->value) / (int)str_replace(',', '', $closings->last()->value), 2)*100}}%</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @endif
</table>
<br>
<a class="btn btn-link" href="/closing/write">
    등록
    </a>
@endsection
