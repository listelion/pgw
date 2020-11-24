@extends('layouts.app')
@section('content')
    <form action="/recipe/{{$recipe->id}}" method="POST" class="form-horizontal">
        <input type="hidden" name="recipe_id" value="{{$recipe->id}}">
        <div class="panel-body">
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>상품명</label></td>
                        <td>{{$recipe->product_name}}</td>
                    </tr>
                    <tr>
                        <td><label>재료</label></td>
                        <td>
                            <select name="material_id" id="material_id" class="form-control">
                                @foreach ($materials as $material)
                                    <option value="{{$material->id}}">{{$material->name}}</option>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><label>중량</label></td>
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