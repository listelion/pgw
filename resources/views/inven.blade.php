@extends('layouts.app')
@section('content')
    <form action="/inven" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($invens) > 0)
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>순번</th>
                        <th>상품</th>
                        <th>재고</th>
                        <th>사용여부</th>
                        <th>등록일</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($invens as $inven)
                        <tr>
                            <td class="table-text">
                                <a href="/inven/{{$inven->id}}">
                                    {{ $invens->id }}
                                </a>
                            </td>
                            <td class="table-text">
                                <a href="/inven/{{$inven->id}}">{{$inven->product}}</a>
                            </td>
                            <td class="table-text">
                                <a href="/inven/{{$inven->id}}">{{ $inven->jago }}</a>
                            </td>
                            <td class="table-text">
                                @if( $inven->use_yn == "y")사용함
                                @else사용안함
                                @endif
                            </td>
                            <td class="table-text">{{$inven->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>
        </table>
    </form>
    <br>
    <a class="btn btn-link" href="/inven/write">
        등록
    </a>

@endsection
