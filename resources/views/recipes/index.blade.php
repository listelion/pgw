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
    <form action="/recipe" method="get" class="form-horizontal">
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
    @if (count($recipes) > 0)
        <form action="/recipe" method="post" class="form-horizontal">
            <table class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
                @csrf
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>상품명</th>
                        <th>재료</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($recipes as $recipe)
                        <tr>
                            <td><a href="recipe/{{$recipe->id}}/edit">{{$recipe->product_name}} {{$recipe->output}}개</a></td>
                            <td><div>@foreach($recipe->details as $detail)
                                    <a href="recipe/{{$recipe->id}}/edit/{{$detail->id}}">{{$detail->material_name}} {{$detail->weight}}g</a>
                                    <form action="/recipe/{{$recipe->id}}/delete/{{$detail->id}}" name="delete{{$detail->id}}" style="display: inline-block" method="POST" class="form-horizontal">
                                        @method('DELETE')
                                        @csrf
                                        <input type="button" onclick="deleteYn{{$detail->id}}()" value="-" class="form-controll">
                                        <script language = "javascript">
                                            function deleteYn{{$detail->id}}() {
                                                var result = confirm("정말로 삭제 하시겠습니까?");
                                                var form = document.delete{{$detail->id}};
                                                if(result){
                                                    form.submit();
                                                }
                                            }
                                        </script>
                                    </form>
                                         <br>
                              @endforeach
                                </div>
                                <a href="recipe/{{$recipe->id}}/create">[추가]</a>
                            </td>
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
    <a class="btn btn-link" href="/recipe/create">
        등록
    </a>
@endsection
