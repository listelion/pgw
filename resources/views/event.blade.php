@extends('layouts.app')
@section('content')

    <table class="table table-striped task-table">
        <tbody>
        <tr>
            <td><a href="/event">전체</a></td>
            <td><a href="/event?status=1">발송준비</a></td>
            <td><a href="/event?status=2">발송완료</a></td>
        </tr>
        </tbody>

    </table>
    <!-- Bootstrap Boilerplate... -->
    <form action="/event" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
            @if (count($addresses) > 0)

                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>연락처</th>
                        <th>발송예정일</th>
                        <th>발송장</th>
                    </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                    @foreach ($addresses as $address)
                        <tr>
                            <td class="table-text">
                                <a href="/event/{{$address->id}}">
                                    {{ $address->addr_send_name }}
                                </a>
                            </td>
                            <td class="table-text">
                                <a href="/event/{{$address->id}}">
                                    {{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}</a>
                            </td>
                            <td class="table-text">
                                <a href="/event/{{$address->id}}">{{ $address->addr_send_date }}</a>
                            </td>
                            <td>
                                @if( $address->addr_status == 1)발송준비
                                @else{{$address->addr_send_jang}}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </table>
        </table>
    </form>
    <br>
    <a class="btn btn-link" href="/address?addr_gubun=2">
        등록
    </a>
@endsection
