@extends('layouts.app')
@section('content')
    <table class="panel-body">
        <!-- New Task Form -->
        @csrf
        ※ 재료정보 <br/>
        <table class="type02">
            <tr>
                <th>이름</th>
                <td>{{ $material->name}}</td>
                <th>원산지</th>
                <td>{{ $material->origin}}</td>
            </tr>
            <tr>
                <th>비고</th>
                <td>{{ $material->bigo}}</td>
            </tr>
        </table>
    </table>
    <table>
        <tr>
            <td width="30%"><a class="btn btn-link" href="/material">
                    뒤로가기
                </a></td>
            <td width="30%"><a class="btn btn-link" href="/material/{{$id}}/edit">
                    수정
                </a></td>
            <form action="/material/{{$id}}" name="delete" method="POST" class="form-horizontal">
                @method('DELETE')
                @csrf
                <td><input type="button" onclick="deleteYn()" value="삭제" class="form-controll"></td>
                <script language = "javascript">
                    function deleteYn() {
                        var result = confirm("정말로 삭제 하시겠습니까?");
                        var form = document.delete;
                        if(result){
                            form.submit();
                        }
                    }
                </script>
            </form>
    </table>
    <br>
    ※ 거래정보 <br/>
    <table class="panel-body" style="text-align: center">
        <table class="table table-striped task-table" >
            <!-- Table Headings -->
            <thead>
            <tr>
                <th>일자</th>
                <th>구분</th>
                <th>중량</th>
                <th>단가</th>
                <th>구입처</th>
            </tr>
            </thead>
            <!-- Table Body -->
            <tbody>
            @if (count($material_logs) > 0)
                @foreach ($material_logs as $material_log)
                    <tr>
                        <td class="table-text">{{ $material_log->date}}</td>
                        <td class="table-text">{{ $material_log->gubun}}</td>
                        <td class="table-text">{{ $material_log->weight}}</td>
                        <td class="table-text">{{ $material_log->cost}}</td>
                        <td class="table-text">{{ $material_log->purchase_place}}</td>
                        <td class="table-text"><a href="/material/{{$id}}/edit/{{$material_log->id}}">수정</a></td>
                        <form action="/material/{{$id}}/delete/{{$material_log->id}}" name="delete{{$material_log->id}}" method="POST" class="form-horizontal">
                            @method('DELETE')
                            @csrf
                        <td><input type="button" onclick="deleteYn{{$material_log->id}}()" value="삭제" class="form-controll"></td>
                        <script language = "javascript">
                            function deleteYn{{$material_log->id}}() {
                                var result = confirm("정말로 삭제 하시겠습니까?");
                                var form = document.delete{{$material_log->id}};
                                if(result){
                                    form.submit();
                                }
                            }
                        </script>
                        </form>
                    </tr>
                @endforeach
            @endif
            @if (count($material_logs) == 0)
                <tr>
                    <td colspan="8">등록된 로그가 없습니다.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </table>
    <a class="btn btn-link" href="/material/{{$id}}/create">
        추가
    </a>
    {{--<div align="center">--}}
        {{--{{$material_logs->links()}}--}}
    {{--</div>--}}


@endsection