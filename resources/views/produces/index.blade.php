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
    <form action="/produce" method="get" class="form-horizontal">
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
    @if (count($produces) > 0)
        <form action="/produces" method="post" class="form-horizontal">
            <table class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
                @csrf
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>레피시명</th>
                        <th>상품재고</th>
                        <th>재료재고</th>
                        <th>가능개수</th>
                        <th>제조</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($produces as $produce)
                        <tr>
                            <td>{{$produce->name}} {{$produce->output}}개</td>
                            <td>0</td>
                            <td>
                                @foreach($produce->details as $detail)
                                    {{$detail->material_name}} {{$detail->weight_sum}}g ( {{$detail->weight}}g ) [ {{$detail->possible_value}} ]<br>
                                @endforeach
                            </td>
                            <td>{{$produce->possible_value}}</td>
                            <td><a href="produce/{{$produce->id}}/create">제조</a></td>
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
@endsection
