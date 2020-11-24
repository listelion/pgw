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
    <form action="/rank" method="get" class="form-horizontal">
        <div>
            <span>
                <select name="product">
                    @foreach($product_lists as $product_list)
                        <option value="{{$product_list->id}}" @if($product_list->id == $product)selected @endif>{{$product_list->name}}</option>
                    @endforeach
                </select>
            </span>
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
            <table class="type08">
                <thead>
                <tr>
                    <th scope="col">상품</th>
                    <th scope="col">받는이</th>
                    <th scope="col">받는번호</th>
                    <th scope="col">수량</th>
                    <th scope="col">비고</th>
                </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                @if (count($ranks) > 0)
                    @foreach ($ranks as $rank)
                        <tr>
                            <td>{{$rank->product_name}}</td>
                            <td>{{$rank->addr_send_name}}</td>
                            <td>{{$rank->addr_send_num1}}-{{$rank->addr_send_num2}}-{{$rank->addr_send_num3}}</td>
                            <td>{{$rank->addr_amount}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
    </table>
    <br>
@endsection
