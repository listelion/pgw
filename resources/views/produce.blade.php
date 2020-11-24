@extends('layouts.app')
@section('content')
    <form action="/produce" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($produces) > 0)
                <table class="table table-striped task-table">
                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>등록일</th>
                        <th>상품</th>
                        <th>입고량</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($produces as $produce)
                        <tr>
                            <td class="table-text">
                                <a href="/produce/{{$produce->id}}">
                                    {{ $produce->id }}
                                </a>
                            </td>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>
        </table>
    </form>
    <br>
    <a class="btn btn-link" href="/produce/create">
        등록
    </a>

@endsection
