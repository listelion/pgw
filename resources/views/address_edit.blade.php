@extends('layouts.app')
@section('content')

    <!-- Bootstrap Boilerplate... -->
    <form action="/address/{{$id}}" method="POST" class="form-horizontal">
        <div class="panel-body">
            <!-- Display Validation Errors -->
            <!-- New Task Form -->
        @csrf

        <!-- Task Name -->

            <script>
                function find_num1() {
                    window.name = "parentForm";
                    openWin = window.open("/findnum?ver=1",
                        "childForm", "width=1000, height=350, resizable = no, scrollbars = no");

                    openWin.document.getElementById("send_num1").value = send_num1;
                    openWin.document.getElementById("send_num2").value = send_num2;
                    openWin.document.getElementById("send_num3").value = send_num3;
                }
            </script>
            <div class="form-group">
                <p>받는 사람 <input type="button" onclick="find_num1()" value="검색">
                    @if ($errors->has('send_name'))
                        <span>
                              <strong>받는사람을 검색해주세요.</strong>
                        </span>
                    @endif
                </p>
                <table>
                    <tr>
                        <td><label>이름</label></td>
                        <td>
                            <input type="text" name="send_name" id="send_name" value="{{$address->addr_send_name}}" class="form-control" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td><label>전화번호</label></td>
                        <td><input type="text" name="send_num1" id="send_num1" value="{{$address->addr_send_num1}}" class="form-control" readonly></td>
                        <td>-</td>
                        <td><input type="text" name="send_num2" id="send_num2" value="{{$address->addr_send_num2}}" class="form-control" readonly></td>
                        <td>-</td>
                        <td><input type="text" name="send_num3" id="send_num3" value="{{$address->addr_send_num3}}" class="form-control" readonly></td>
                    </tr>
                    <tr>
                        <td><label>주소</label></td>
                        <td colspan="5"><input type="text" name="send_addr" id="send_addr" value="{{$address->addr_send_addr}}" class="form-control" readonly></td>
                    </tr>
                    <tr>
                        <td><label>상세주소</label></td>
                        <td colspan="5"><input type="text" name="send_addr2" id="send_addr2" value="{{$address->addr_send_addr2}}" class="form-control" readonly></td>
                    </tr>
                    <tr>
                        <td><label>메모</label></td>
                        <td colspan="5"><input type="text" name="addr_memo" id="addr_memo" value="{{$address->addr_memo}}" class="form-control"></td>
                    </tr>
                </table>
            </div>
            <script>
                function find_num2() {
                    window.name = "parentForm";
                    openWin = window.open("/findnum?ver=2",
                        "childForm", "width=570, height=350, resizable = no, scrollbars = no");

                    openWin.document.getElementById("send_num1").value = send_num1;
                    openWin.document.getElementById("send_num2").value = send_num2;
                    openWin.document.getElementById("send_num3").value = send_num3;
                }
            </script>
            <div class="form-group">
                <p>보내는 사람 <input type="button" onclick="find_num2()" value="검색">
                    <select name="bookmark" onchange="bookmarkDisplay(this.form)">
                        <option selected value="0">자주 쓰는 주소</option>
                        <option value="1">공음수산</option>
                        <option value="2">풍기원</option>
                        <option value="3">해남수산</option>
                    </select>
                    @if ($errors->has('reci_name'))
                        <span>
                              <strong>보내는사람을 검색해주세요.</strong>
                        </span>
                    @endif
                </p>
                <script language="javascript">

                    function bookmarkDisplay(frm) {
                        var bookmark = frm.bookmark.selectedIndex;
                        switch( bookmark ){
                            case 0:
                                break;
                            case 1:
                                frm.reci_name.value = '공음수산';
                                frm.reci_num1.value = '010';
                                frm.reci_num2.value = '3516';
                                frm.reci_num3.value = '4921';
                                break;
                            case 2:
                                frm.reci_name.value = '풍기원';
                                frm.reci_num1.value = '062';
                                frm.reci_num2.value = '226';
                                frm.reci_num3.value = '2314';
                                break;
                            case 3:
                                frm.reci_name.value = '해남수산';
                                frm.reci_num1.value = '010';
                                frm.reci_num2.value = '5714';
                                frm.reci_num3.value = '5715';
                                break;
                        }

                        return true;
                    }

                </script>
                <table>
                    <tr>
                        <td><label>이름</label></td>
                        <td><input type="text" name="reci_name" id="reci_name" value="{{$address->addr_reci_name}}" class="form-control" readonly></td>
                    </tr>
                    <tr>
                        <td><label>전화번호</label></td>
                        <td><input type="text" name="reci_num1" id="reci_num1" value="{{$address->addr_reci_num1}}" class="form-control" readonly></td><td>-</td>
                        <td><input type="text" name="reci_num2" id="reci_num2" value="{{$address->addr_reci_num2}}" class="form-control" readonly></td><td>-</td>
                        <td><input type="text" name="reci_num3" id="reci_num3" value="{{$address->addr_reci_num3}}" class="form-control" readonly></td>
                    </tr>
                </table>
            </div>
            <p>발송 정보</p>
            <table>
                <tr>
                    <td><label>상품</label></td>
                    <td>
                        <select name="addr_product" id="addr_product" onchange="productChange(this.form)" class="form-control">
                            @foreach ($products as $product)
                                <option value="{{$product->id}}" @if($address->addr_product == $product->id) selected @endif>{{$product->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <script language="javascript">
                        function productChange(frm) {
                            var product = frm.addr_product.value;
                            product *= 1;
                            switch(product){
                                @foreach($products as $product)
                                case {{$product->id}}:
                                    frm.closing_value.value = {{$product->price}};
                                    var amount = frm.addr_amount.value;
                                    var value = frm.closing_value.value;
                                    amount *= 1;
                                    value *=1;
                                    result = amount * value;
                                    frm.closing_result.value = result;
                                    break;
                                    @endforeach
                            }
                            return true;
                        }
                    </script>
                    <td>
                        <input type="text" style="width:90px; text-align:right;"name="closing_value" id="closing_value" onchange="valueChange(this.form)" class="form-control" value="80000">
                    </td>
                    <script language="javascript">
                        function productStart(frm) {
                            var product = frm.addr_product.value;
                            product *= 1;
                            switch(product){
                                @foreach($products as $product)
                                case {{$product->id}}:
                                    frm.closing_value.value = {{$product->price}};
                                    var amount = frm.addr_amount.value;
                                    var value = frm.closing_value.value;
                                    amount *= 1;
                                    value *=1;
                                    result = amount * value;
                                    frm.closing_result.value = result;
                                    break;
                                    @endforeach
                            }
                            return true;
                        }
                    </script>
                    <td>원</td>
                    <script language="javascript">
                        function valueChange(frm) {
                            var amount = frm.addr_amount.value;
                            var value = frm.closing_value.value;
                            amount *= 1;
                            value *=1;
                            result = amount * value;
                            frm.closing_result.value = result;
                            return true;
                        }
                    </script>
                    <td>
                        <input type="text" style="width:40px; text-align:right;" name="addr_amount" id="addr_amount" value="{{$address->addr_amount}}" onchange="amountChange(this.form)" class="form-control{{ $errors->has('addr_amount') ? ' is-invalid' : '' }}">
                    </td>
                    <script language="javascript">
                        function amountChange(frm) {
                            var amount = frm.addr_amount.value;
                            var value = frm.closing_value.value;
                            amount *= 1;
                            value *=1;
                            result = amount * value;
                            frm.closing_result.value = result;
                            return true;
                        }
                    </script>
                    <td>box</td>
                    <td>
                        <input type="text" style="width:90px; text-align:right;"name="closing_result" id="closing_result" value="{{$closing->value}}" class="form-control">

                    </td>
                    <td>원</td>
                </tr>
                @if ($errors->has('addr_amount'))
                    <tr>
                        <td></td>
                        <td>
                            <span>
                                  <strong>박스 수량을 입력해주세요.</strong>
                            </span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td><label>선/착불</label></td>
                    <td><select name="addr_send_gubun" id="addr_send_gubun" class="form-control">
                            <option value="1" @if($address->addr_send_gubun == 1) selected @endif>선불</option>
                            <option value="2" @if($address->addr_send_gubun == 2) selected @endif>착불</option></select></td>
                </tr>
                <tr>
                    <td><label>상품구분</label></td>
                    <td><select name="addr_gubun" id="addr_gubun" class="form-control">
                            <option value="1" @if($address->addr_gubun==1) selected @endif>구매</option>
                            <option value="2" @if($address->addr_gubun==2) selected @endif>이벤트</option></select></td>
                </tr>
                <tr>
                    <td><label>발송예정일</label></td>
                    <td><input type="date" name="addr_date" id="addr_date" class="form-control" value="{{$address->addr_send_date}}"></td>
                </tr>
            </table>
            <br/><p>매출 정보</p>
            <table>
                <tr>
                    <td><label>주문받은자</label></td>
                    <td><select name="addr_user_id" id="addr_user_id" class="form-control">
                            @foreach($user_list as $user_list)
                                <option value="{{$user_list->id}}" @if($user_list->id == $address->addr_user_id) selected @endif>{{$user_list->name}}</option>
                            @endforeach
                        </select></tr>
                <tr>
                    <td><label>구매처</label></td>
                    <td><select name="closing_shop" id="closing_shop" class="form-control">
                            @foreach($codelist_shop as $codelist_shop)
                                <option value="{{$codelist_shop->code}}" @if($codelist_shop->code == $closing->shop) selected @endif>{{$codelist_shop->content}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td><label>택배사</label></td>
                    <td><select name="addr_courier" id="addr_courier" class="form-control">
                            @foreach($codelist_couriers as $codelist_courier)
                                <option value="{{$codelist_courier->code}}" @if($codelist_courier->code == $address->addr_courier)selected @endif>{{$codelist_courier->content}}</option>
                            @endforeach
                        </select></td>
                </tr>
                <tr>
                    <td>입금확인</td>
                    <td>
                        <select name="deposit_yn" class="form-control">
                            <option value="y" @if($address->deposit_yn == 'y') selected @endif>입금완료</option>
                            <option value="n" @if($address->deposit_yn == 'n') selected @endif>미입금</option>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> 저장
                    </button>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-default" onclick="delete_yn()">
                    <i class="fa fa-plus"></i> 삭제
                </button>
                <script>
                    function delete_yn() {
                    var delete_yn = confirm("삭제하시겠습니까?");
                    if(delete_yn == true){
                        location.href="/address/delete/{{$address->id}}";
                    }
                    }
                </script>
            </div>
    </form>
    </div>

    <!-- Current Tasks -->

@endsection