@extends('layouts.app')
@section('content')
    <form action="/produce/{{$produce->id}}" method="POST" class="form-horizontal">
        <input type="hidden" name="id" value="{{$produce->id}}">
        <div class="panel-body">
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>상품명</label></td>
                        <td>{{$produce->name}}</td>
                    </tr>
                    <tr>
                        <td><label>수량</label></td>
                        <td><input type="text" name="weight" id="weight" value="{{old('weight')}}" class="form-control"></td>
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