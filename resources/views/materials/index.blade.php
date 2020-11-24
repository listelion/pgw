@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    <div style="display: inline-block; float:right">
        <ul class="tags">
            <li><a href="material" class="tag">재료관리</a></li>
            <li><a href="produce" class="tag">생산관리</a></li>
            <li><a href="recipe" class="tag">레시피관리</a></li>
        </ul>
    </div>
    <form action="/material" method="get" class="form-horizontal">
        <div>
            <span>
                <input type="text" name="search_text" id="search_text" style="width:150px;display:inline-block;" class="form-control" value="{{$request->search_text}}">
            </span>
            <span>
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i>검색
                </button>
            </span>
        </div>
    </form>
    @if (count($materials) > 0)
        <form action="/material" method="post" class="form-horizontal">
            <table class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
                @csrf
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>원산지</th>
                        <th>현재고</th>
                        <th>최고가</th>
                        <th>최저가</th>
                        <th>평균가</th>
                        <th>추가</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <td><a href="material/{{$material->id}}">{{$material->name}}</a></td>
                            <td>{{$material->origin}}</td>
                            <td>{{number_format($material->weight_sum)}}</td>
                            <td>{{number_format($material->max_cost)}}</td>
                            <td>{{number_format($material->min_cost)}}</td>
                            <td>{{number_format($material->avr_cost)}}</td>
                            <td><a href="/material/{{$material->id}}/create">추가</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </table>
        </form>
        {{--<div align="center">--}}
            {{--{{$materials->appends(['search_gubun' => $request->search_gubun, 'search_text' => $request->search_text])->links()}}--}}
        {{--</div>--}}
    @endif
    <br>
    <a class="btn btn-link" href="/material/create">
        등록
    </a>
@endsection
