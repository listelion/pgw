@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    <form action="/inven_write" method="POST" class="form-horizontal">
        <div class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>상품</label></td>
                        <td><select name="product" class="form-control">
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                @endforeach
                            </select></td>
                    </tr>
                    <tr>
                        <td><label>구분</label></td>
                        <td><select name="gubun" class="form-control">
                                <option value="1">입고</option>
                                <option value="2">출고</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>일자</label></td>
                        <td><input type="date" name="date" id="date" class="form-control" value="<?php echo date("Y-m-d");?>"></td>
                    </tr>
                    <tr>
                        <td><label>수량</label></td>
                        <td><input type="text" name="value" id="value" class="form-control"></td>
                        <td>박스</td>
                    </tr>
                    <tr>
                        <td><label>사유</label></td>
                        <td><input type="text" name="content" id="content" class="form-control"></td>
                    </tr>
                </table>
            </div>
        </div>
        <table>
            <tr>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-plus"></i> 저장
                        </button>
                    </div>
                </div>
            </tr>
        </table>
    </form>
    <!-- Current Tasks -->
@endsection