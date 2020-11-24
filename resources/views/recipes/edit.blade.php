@extends('layouts.app')
@section('content')
    <form action="/recipe/{{$recipe->id}}" method="POST" class="form-horizontal">
        <div class="panel-body">
        @method('PUT')
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>상품명</label></td>
                        <td>
                            <select name="product_id" id="product_id" class="form-control">
                                @foreach ($product_lists as $product_list)
                                    <option value="{{$product_list->id}}" @if($recipe->product_id == $product_list->id) selected @endif>{{$product_list->name}}</option>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td><label>중량</label></td>
                        <td><input type="text" name="output" id="output" value="{{$recipe->output}}" class="form-control"></td>
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