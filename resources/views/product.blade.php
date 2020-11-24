@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    <form action="/product" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($products) > 0)
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>상품명</th>
                        <th>금액</th>
                        <th>택배비</th>
                        <th>순서</th>
                        <th>수정</th>
                        <th>삭제</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="table-text">
                                <a href="/product/{{$product->id}}">{{ $product->name }}</a>
                            </td>
                            <td class="table-text">
                                <a href="/product/{{$product->id}}">{{ $product->price }}</a>
                            </td>
                            <td class="table-text">
                                <a href="/product/{{$product->id}}">{{ $product->parcel_max }}box 당 {{ $product->parcel }}</a>
                            </td>
                            <td class="table-text">
                                <a href="/product/{{$product->id}}">{{ $product->position }}</a>
                            </td>
                            <td class="table-text">
                                <a href="/product/{{$product->id}}">수정</a>
                            </td>
                            <td><a href="/product/{{$product->id}}">삭제</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>

    </form>
    <br>
    <a class="btn btn-link" href="/product_write">
        등록
    </a>
@endsection
