@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    <form action="/invoice/{{$id}}" method="post" class="form-horizontal">
        <table class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
            @csrf
                <table class="table table-striped task-table">
                    <tbody>
                    <h5>보내는사람</h5>
                    <tr>
                        <td class="td-st1">이름</td>
                        <td class="table-text">
                            {{ $address->addr_reci_name }}  <button onclick="copy('{{ $address->addr_reci_name }}')" class="btn btn-default">[복사]</button>
                        </td>
                    </tr>
                    <tr>
                        <td>연락처</td>
                        <td class="table-text">
                            {{ $address->addr_reci_num1}}-{{ $address->addr_reci_num2}}-{{ $address->addr_reci_num3}} <button onclick="copy('{{ $address->addr_reci_num1}}-{{ $address->addr_reci_num2}}-{{ $address->addr_reci_num3}}')" class="btn btn-default">[복사]</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-striped task-table">
                    <!-- Table Body -->
                    <tbody>
                        <h5>받는사람</h5>
                        <tr>
                            <td class="td-st1">이름</td>
                            <td class="table-text">
                                {{ $address->addr_send_name }}  <button onclick="copy('{{ $address->addr_send_name }}')" class="btn btn-default">[복사]</button>
                            </td>
                        </tr>
                        <tr>
                            <td>주소</td>
                            <td class="table-text">
                                {{ $address->addr_send_addr }}  <button onclick="copy('{{ $address->addr_send_addr }}')" class="btn btn-default">[복사]</button>
                            </td>
                        </tr>
                        <tr>
                            <td>상세주소</td>
                            <td class="table-text">
                                {{ $address->addr_send_addr2 }}  <button onclick="copy('{{ $address->addr_send_addr2 }}')" class="btn btn-default">[복사]</button>
                            </td>
                        </tr>
                        <tr>
                            <td>연락처</td>
                            <td class="table-text">
                                {{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}  <button onclick="copy('{{ $address->addr_send_num1}}-{{ $address->addr_send_num2}}-{{ $address->addr_send_num3}}')" class="btn btn-default">[복사]</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-striped task-table">
                    <tbody>
                    <h5>발송정보</h5>
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
                            {{ $address->shop }}
                        </td>
                    </tr>
                        <tr>
                            <td class="td-st1">발송예정일</td>
                            <td class="table-text">
                                {{ $address->addr_send_date }}
                            </td>
                        </tr>
                        <tr>
                            <td class="td-st1">상품</td>
                            <td class="table-text">
                                {{ $address->product_name }} {{ $address->addr_amount }}box <button onclick="copy('{{ $address->product_name }} {{ $address->addr_amount }}box')" class="btn btn-default">[복사]</button>
                            </td>
                        </tr>

                    <tr>
                        <td>메모</td>
                        <td class="table-text">
                            {{ $address->addr_memo }} <button onclick="copy('{{ $address->addr_memo }}')" class="btn btn-default">[복사]</button>
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
                        <td>택배사</td>
                        <td class="table-text">{{$address->addr_courier_name}}
                        </td>
                    </tr>
                    <tr>
                        <td>발송장번호</td>
                        <td><input type="text" style="width:120px" name="send_jang" id="send_jang" class="form-control" value={{$address->addr_send_jang}}>
                            @if($address->addr_send_jang > 0)문자발송하기 -> <a class="btn btn-link" href="/invoice/{{$id}}/send_msg?select=1">받는사람</a> <a class="btn btn-link" href="/invoice/{{$id}}/send_msg?select=2">보내는사람</a>@endif</td>
                    </tr>
                    @if($address->addr_send_jang > 0)
                    <tr>
                        <td>문자전송 결과</td>
                        <td>@foreach ($sms as $sms)
                                발송번호 : {{$sms->reci_num}}, 전송번호 : {{$sms->send_num}}, 발송장번호 : {{$sms->send_jang}}, 전송일자 : {{$sms->created_at}}, 발송여부 : {{$sms->send_yn}}<br>
                            @endforeach</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
        </table>
        <br>
        <table>
            <tr>
                <td width="30%"><a class="btn btn-link" href="/invoice?status=1">
                        뒤로가기
                    </a></td>
                <td width="30%"><a class="btn btn-link" href="/address/{{$id}}">
                        수정
                    </a></td>
                <td width="30%">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> 저장
                    </button></td>
                <td width="30%"><a class="btn btn-link" href="/address/label/{{$id}}">
                        발송장등록
                    </a></td>
        </table>
    </form>
    <script>
        function copy(val) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = val;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
        }
    </script>
@endsection
