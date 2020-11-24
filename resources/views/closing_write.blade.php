@extends('layouts.app')
@section('content')

    <!-- Bootstrap Boilerplate... -->
    <form action="/closing" method="POST" class="form-horizontal">
        <div class="panel-body">
        @csrf

        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>쇼핑몰</label></td>
                        <td><select name="shop" class="form-control">
                                @foreach($codelist_shop as $codelist_shop)
                                <option value="{{$codelist_shop->code}}">{{$codelist_shop->content}}</option>
                                @endforeach
                            </select></td>
                    </tr>
                    <tr>
                        <td><label>항목</label></td>
                        <td><select name="gubun" class="form-control">
                                @foreach($codelist_gubun as $codelist_gubun)
                                    <option value="{{$codelist_gubun->code}}">{{$codelist_gubun->content}}</option>
                                @endforeach
                            </select></td>
                    </tr>
                    <tr>
                        <td><label>내용</label></td>
                        <td><input type="text" name="content" id="content" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>값</label></td>
                        <td><input type="text" name="value" id="value" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>일자</label></td>
                        <td><input type="date" name="date" id="date" class="form-control" value="<?php echo date("Y-m-d");?>"></td>
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