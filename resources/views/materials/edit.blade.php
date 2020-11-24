@extends('layouts.app')
@section('content')
    <form action="/material/{{$id}}" method="POST" class="form-horizontal">
        @method('PUT')
        <div class="panel-body">
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>재료명</label></td>
                        <td><input type="text" name="name" id="name" value="{{$material->name}}" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>원산지</label></td>
                        <td><input type="text" name="origin" id="origin" value="{{$material->origin}}" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>비고</label></td>
                        <td><input type="text" name="bigo" id="bigo" value="{{$material->bigo}}" class="form-control"></td>
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