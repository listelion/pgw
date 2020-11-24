@extends('layouts.app')
@section('content')
    <form action="/material/{{$material_log->material_id}}/update/{{$material_log->id}}" method="POST" class="form-horizontal">
        @method('PUT')
        <div class="panel-body">
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>재료명</label></td>
                        <td>{{$material->name}}</td>
                    </tr>
                    <tr>
                        <td><label>구분</label></td>
                        <td>
                            <select name="gubun" id="gubun" class="form-control">
                                @foreach ($gubun_codes as $gubun_code)
                                    <option value="{{$gubun_code->code}}" @if($gubun_code->code == $material_log->gubun) selected @endif>{{$gubun_code->content}}</option>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><label>중량</label></td>
                        <td><input type="text" name="weight" id="weight" value="{{$material_log->weight}}" class="form-control"> G</td>
                    </tr>
                    <tr>
                        <td><label>단가</label></td>
                        <td><input type="text" name="cost" id="cost" value="{{$material_log->cost}}" class="form-control"> 원</td>
                    </tr>
                    <tr>
                        <td><label>구매처</label></td>
                        <td>
                            <select name="purchase_place" id="purchase_place" class="form-control">
                                @foreach ($purchase_codes as $purchase_code)
                                    <option value="{{$purchase_code->code}}" @if($purchase_code->code == $material_log->purchase_code) selected @endif>{{$purchase_code->content}}</option>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><label>일자</label></td>
                        <td><input type="date" name="date" id="date" class="form-control" value="{{$material_log->date}}"></td>
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