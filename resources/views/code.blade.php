@extends('layouts.app')
@section('content')
    <table class="table table-striped task-table">
        <tbody>
        <tr>
            <td><a href="/code?class=0">최상위</a></td>
            @foreach($sub_codes as $sub_code)
                <td><a href="/code?class={{$sub_code->id}}">{{$sub_code->content}}</a></td>
            @endforeach
        </tr>
        </tbody>
    </table>
    <!-- Bootstrap Boilerplate... -->
    <form action="/code" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($codes) > 0)
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>코드</th>
                        <th>내용</th>
                        <th>클래스</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($codes as $code)
                        <tr>
                            <td class="table-text">
                                <a href="/code/{{$code->id}}">{{$code->code}}</a>
                            </td>
                            <td class="table-text">
                                <a href="/code/{{$code->id}}">{{ $code->content }}</a>
                            </td>
                            <td>
                                {{$code->class}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>
        </table>
    </form>
    {{$codes->appends(['class' => $request->class])->links()}}
    <br>
    <a class="btn btn-link" href="/code/write?class={{$request->class}}">
        등록
    </a>
@endsection
