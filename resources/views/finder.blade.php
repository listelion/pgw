@extends('layouts.nomenu')
@section('content')
    @if($id == 0)
    <!-- Bootstrap Boilerplate... -->
    <form action="/finder?ver={{$ver}}" method="post" class="form-horizontal">
    <table class="panel-body">
        <!-- Display Validation Errors -->

        <!-- New Task Form -->

    @csrf

        <!-- Task Name -->
            <table>
                    <tr>
                        <td><label>이름</label></td>
                        <td>
                            <input type="text" name="find_name" id="find_name" class="form-control{{ $errors->has('find_name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('find_name'))
                            <span>
                                <strong>이름을 입력해주세요.</strong>
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><label>전화번호</label></td>
                        <td><input type="text" name="find_num1" id="find_num1" class="form-control{{ $errors->has('find_num1') ? ' is-invalid' : '' }}"></td>
                        <td>-</td>
                        <td><input type="text" name="find_num2" id="find_num2" class="form-control{{ $errors->has('find_num2') ? ' is-invalid' : '' }}"></td>
                        <td>-</td>
                        <td><input type="text" name="find_num3" id="find_num3" class="form-control{{ $errors->has('find_num3') ? ' is-invalid' : '' }}"></td>
                        <script>
                            function find_num() {
                                var find_num1 = $('#find_num1').val();
                                var find_num2 = $('#find_num2').val();
                                var find_num3 = $('#find_num3').val();

                                location.href = "/finder?find_num1=" + find_num1 + "&find_num2=" + find_num2 + "&find_num3=" + find_num3;
                            }
                        </script>
                    </tr>
                    @if ($errors->has('find_num3'))
                    <tr>
                        <td></td>
                        <td colspan="5">
                            <span>
                                <strong>전화번호를 입력해주세요.</strong>
                            </span>
                        </td>
                    </tr>
                    @endif
                @if (count($finders) > 0)
                        <table class="table table-striped task-table">

                            <!-- Table Headings -->
                            <thead>
                            <tr>
                                <th>이름</th>
                                <th>연락처</th>
                                <th>주소</th>
                                <th>상세주소</th>
                                <th>삭제여부</th>
                            </tr>

                            </thead>

                            <!-- Table Body -->
                            <tbody>
                            @foreach ($finders as $finders)
                                <tr>
                                    <td class="table-text">
                                        <div>{{ $finders->find_name }}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{ $finders->find_num1}}-{{ $finders->find_num2}}-{{ $finders->find_num3}}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{ $finders->find_addr }}</div>
                                    </td>
                                    <td class="table-text">
                                        <div>{{ $finders->find_addr2 }}</div>
                                    </td>
                                    <td>
                                        <form action="/finder/{{ $finders->id}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button>삭제</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
                    <tr>
                        <td><input type="button" onclick="sample6_execDaumPostcode()" value="우편번호 찾기"></td>
                        <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                        <script>
                            function sample6_execDaumPostcode() {
                                new daum.Postcode({
                                    oncomplete: function(data) {
                                        // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                        var fullAddr = ''; // 최종 주소 변수
                                        var extraAddr = ''; // 조합형 주소 변수

                                        // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                        if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                            fullAddr = data.roadAddress;

                                        } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                            fullAddr = data.jibunAddress;
                                        }

                                        // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                        if(data.userSelectedType === 'R'){
                                            //법정동명이 있을 경우 추가한다.
                                            if(data.bname !== ''){
                                                extraAddr += data.bname;
                                            }
                                            // 건물명이 있을 경우 추가한다.
                                            if(data.buildingName !== ''){
                                                extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                            }
                                            // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                            fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                                        }

                                        // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                        document.getElementById('find_addr').value = fullAddr;

                                        // 커서를 상세주소 필드로 이동한다.
                                        document.getElementById('find_addr2').focus();
                                    }
                                }).open();
                            }
                        </script>
                        <td colspan="5"><input type="text" name="find_addr" id="find_addr" class="form-control{{ $errors->has('find_addr') ? ' is-invalid' : '' }}" placeholder="주소"></td>
                        <tr>
                        <td colspan="5"><input type="text" name="find_addr2" id="find_addr2" class="form-control" placeholder="상세주소"></td>
                        </tr>
                    </tr>
                </tr>
            <!-- Add Task Button -->
                <tr>
                    <td>
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> 저장
                    </button>
                    </td>
                </tr>
            </table>
    </table>
    </form>
    <br>
    @endif
    @if($id > 0)
        <!-- Bootstrap Boilerplate... -->
        <form action="/finder/edit/{{$id}}" method="post" class="form-horizontal">
            <table class="panel-body">
                <!-- Display Validation Errors -->
                <input type="hidden" name="ver" value="{{$ver}}">
                <!-- New Task Form -->

            @csrf

            <!-- Task Name -->
                <table>
                    <tr>
                        <td><label>이름</label></td>
                        <td>
                            <input type="text" name="find_name" id="find_name" value="{{$finder->find_name}}" class="form-control{{ $errors->has('find_name') ? ' is-invalid' : '' }}">
                            @if ($errors->has('find_name'))
                                <span>
                                <strong>이름을 입력해주세요.</strong>
                            </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><label>전화번호</label></td>
                        <td><input type="text" name="find_num1" id="find_num1" value="{{$finder->find_num1}}" class="form-control{{ $errors->has('find_num1') ? ' is-invalid' : '' }}"></td>
                        <td>-</td>
                        <td><input type="text" name="find_num2" id="find_num2" value="{{$finder->find_num2}}" class="form-control{{ $errors->has('find_num2') ? ' is-invalid' : '' }}"></td>
                        <td>-</td>
                        <td><input type="text" name="find_num3" id="find_num3" value="{{$finder->find_num3}}" class="form-control{{ $errors->has('find_num3') ? ' is-invalid' : '' }}"></td>
                    </tr>
                    @if ($errors->has('find_num3'))
                        <tr>
                            <td></td>
                            <td colspan="5">
                            <span>
                                <strong>전화번호를 입력해주세요.</strong>
                            </span>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td><input type="button" onclick="sample6_execDaumPostcode()" value="우편번호 찾기"></td>
                        <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                        <script>
                            function sample6_execDaumPostcode() {
                                new daum.Postcode({
                                    oncomplete: function(data) {
                                        // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                        // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                        // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                        var fullAddr = ''; // 최종 주소 변수
                                        var extraAddr = ''; // 조합형 주소 변수

                                        // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                        if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                            fullAddr = data.roadAddress;

                                        } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                            fullAddr = data.jibunAddress;
                                        }

                                        // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                        if(data.userSelectedType === 'R'){
                                            //법정동명이 있을 경우 추가한다.
                                            if(data.bname !== ''){
                                                extraAddr += data.bname;
                                            }
                                            // 건물명이 있을 경우 추가한다.
                                            if(data.buildingName !== ''){
                                                extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                            }
                                            // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                            fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                                        }

                                        // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                        document.getElementById('find_addr').value = fullAddr;

                                        // 커서를 상세주소 필드로 이동한다.
                                        document.getElementById('find_addr2').focus();
                                    }
                                }).open();
                            }
                        </script>
                        <td colspan="5"><input type="text" name="find_addr" id="find_addr" value="{{$finder->find_addr}}" class="form-control{{ $errors->has('find_addr') ? ' is-invalid' : '' }}" placeholder="주소"></td>
                    <tr>
                        <td colspan="5"><input type="text" name="find_addr2" id="find_addr2" value="{{$finder->find_addr2}}"  class="form-control" placeholder="상세주소"></td>
                    </tr>
                    </tr>
                    </tr>
                    <!-- Add Task Button -->
                    <tr>
                        <td>
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus"></i> 저장
                            </button>
                        </td>
                    </tr>
                </table>
            </table>
        </form>
        <br>
    @endif
@endsection
