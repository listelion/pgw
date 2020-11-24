@extends('layouts.app')
@section('content')

    <!-- Bootstrap Boilerplate... -->
    @if ($id == 0)
        <form action="/product_write" method="POST" class="form-horizontal">
        <div class="panel-body">
        @csrf
        <!-- Task Name -->
            <div class="form-group">
                <table>
                    <tr>
                        <td><label>상품명</label></td>
                        <td><input type="text" name="name" id="name" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>금액</label></td>
                        <td><input type="text" name="price" id="price" class="form-control"></td>
                        </tr>
                    <tr>
                        <td><label>택배비</label></td>
                        <td><input type="text" name="parcel" id="parcel" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>묶음배송 수량</label></td>
                        <td><input type="text" name="parcel_max" id="parcel_max" class="form-control"></td>
                    </tr>
                    <tr>
                        <td><label>순서</label></td>
                        <td><input type="text" name="position" id="position" class="form-control"></td>
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
    @endif
    @if ($id > 0)
        <form action="/product/{{$id}}" method="POST" class="form-horizontal">
            <div class="panel-body">
            @csrf
            <!-- Task Name -->
                <div class="form-group">
                    <table>
                        <tr>
                            <td><label>상품명</label></td>
                            <td><input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}"></td>
                        </tr>
                        <tr>
                            <td><label>금액</label></td>
                            <td><input type="text" name="price" id="price" class="form-control" value="{{ $product->price }}"></td>
                        </tr>
                        <tr>
                            <td><label>택배비</label></td>
                            <td><input type="text" name="parcel" id="parcel" class="form-control" value="{{ $product->parcel }}"></td>
                        </tr>
                        <tr>
                            <td><label>묶음배송 수량</label></td>
                            <td><input type="text" name="parcel_max" id="parcel_max" class="form-control" value="{{ $product->parcel_max }}"></td>
                        </tr>
                        <tr>
                            <td><label>순서</label></td>
                            <td><input type="text" name="position" id="position" class="form-control" value="{{ $product->position }}"></td>
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
    @endif
@endsection