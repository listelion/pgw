@extends('layouts.app')
@section('content')

    <!-- Bootstrap Boilerplate... -->
    <form action="/deposit/{{$id}}" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
                <table class="table table-striped task-table">
                    <!-- Table Body -->
                    <tbody>
                        <h5>받는사람</h5>
                        <tr>
                            <td class="td-st1">이름</td>
                            <td class="table-text">
                                {{ $address->addr_send_name }}
                            </td>
                        </tr>
                        <tr>
                            <td>연락처</td>
                            <td class="table-text">
                                {{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}
                            </td>
                        </tr>
                        <tr>
                            <td>주소</td>
                            <td class="table-text">
                                {{ $address->addr_send_addr }} {{ $address->addr_send_addr2 }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped task-table">
                    <tbody>
                    <h5>보내는사람</h5>
                    <tr>
                        <td class="td-st1">이름</td>
                        <td class="table-text">
                            {{ $address->addr_reci_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>연락처</td>
                        <td class="table-text">
                            {{ $address->addr_reci_num1}}-{{ $address->addr_reci_num2}}-{{ $address->addr_reci_num3}}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-striped task-table">
                    <tbody>
                    <h5>발송정보</h5>
                    <tr>
                        <td class="td-st1">발송예정일</td>
                        <td class="table-text">
                            {{ $address->addr_send_date }}
                        </td>
                    </tr>
                    <tr>
                        <td class="td-st1">상품</td>
                        <td class="table-text">
                            {{ $address->addr_product }} {{ $address->addr_amount }}box
                        </td>
                    </tr>
                    <tr>
                        <td class="td-st1">발송구분</td>
                        <td class="table-text">
                            @if ($address->addr_gubun == 1)
                                구매
                            @else
                                이벤트
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="td-st1">쇼핑몰</td>
                        <td class="table-text">
                            {{ $address->shop_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>선착불</td>
                        <td class="table-text">
                            @if ($address->addr_send_gubun == 1)
                                선불
                            @else
                                착불
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>발송상태</td>
                        <td class="table-text">
                            @if ($address->addr_status == 1)
                                발송준비중
                            @else
                                발송완료
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>발송장번호</td>
                        <td>{{$address->addr_send_jang}}</td>
                    </tr>
                    <tr>
                        <td>입금확인</td>
                        <td>
                            <select name="deposit_yn">
                                <option value="y" @if($address->deposit_yn == 'y')selected @endif>입금완료</option>
                                <option value="n" @if($address->deposit_yn == 'n')selected @endif>확인중</option>
                            </select>
                        </td>
                    </tr>
                    </tbody>
                </table>
        </table>
        <br>
        <table>
            <tr>
                <td width="50%"><a class="btn btn-link" href="/deposit">
                        뒤로가기
                    </a></td>
                <td width="50%">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> 저장
                    </button></td>
        </table>
    </form>

@endsection
