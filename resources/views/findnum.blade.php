@extends('layouts.nomenu')
@section('content')

    <!-- Bootstrap Boilerplate... -->
    <form action="/findnum" method="get" class="form-horizontal">
        @csrf
            <input type="hidden" name="ver" value="{{$ver}}">
            <table>
                <tr>
                    <td><label>이름</label></td>
                    <td><input type="text" name="find_name" id="find_name" class="form-control"></td>
                </tr>
                <tr>
                    <td><label>전화번호</label></td>
                    <td><input type="text" name="find_num1" id="find_num1" class="form-control"></td>
                    <td>-</td>
                    <td><input type="text" name="find_num2" id="find_num2" class="form-control"></td>
                    <td>-</td>
                    <td><input type="text" name="find_num3" id="find_num3" class="form-control"></td>
                    <td>
                    <input type="submit" value="검색">
                    </td>
                </tr>
                @if (count($finders) == 0 && $countreq > 1)
                    <table>
                        <tr><td><p>검색 결과가 없습니다. @if($ver == 1)<a class="btn btn-link" href="/finder?ver=1">@else<a class="btn btn-link" href="/finder?ver=2">@endif
                                    등록하기
                                    </a></p></td></tr>
                    </table>
                @endif
                @if (count($finders) > 0)
                    <table class="border-collapse w-full">
                        <thead>
                        <tr>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden text-center lg:table-cell">이름</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden text-center lg:table-cell">연락처</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden text-center lg:table-cell">주소</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden text-center lg:table-cell">상세주소</th>
                            <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden text-center lg:table-cell">@if($ver==1)
                                    받는<br/>사람
                                @else
                                    보내는<br/>사람
                                @endif</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($finders as $finder)
                            <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-20 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">
                                    이름
                                </span>
                                <a href="finder/edit/{{$finder->id}}?ver={{$ver}}">{{ $finder->find_name }}</a>
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">
                                    연락처
                                </span>
                                {{ $finder->find_num1}}-{{ $finder->find_num2}}-{{ $finder->find_num3}}
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">
                                    주소
                                </span>
                                {{ $finder->find_addr }}
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">
                                    상세주소
                                </span>
                                {{ $finder->find_addr2 }}
                                </td>
                                <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">
                                    받는주소
                                </span>
                                @if($ver==1)
                                <input type="button" value="받는" onclick="setParentSend{{$finder->id}}(),window.close()">
                                @else
                                    <input type="button" value="보내는" onclick="setParentReci{{$finder->id}}(),window.close()">
                                    @endif
                                </td>
                                <script>
                                    function setParentSend{{$finder->id}}(){
                                        opener.document.getElementById("send_name").value = "{{$finder->find_name}}"
                                        opener.document.getElementById("send_num1").value = "{{$finder->find_num1}}"
                                        opener.document.getElementById("send_num2").value = "{{$finder->find_num2}}"
                                        opener.document.getElementById("send_num3").value = "{{$finder->find_num3}}"
                                        opener.document.getElementById("send_addr").value = "{{$finder->find_addr}}"
                                        opener.document.getElementById("send_addr2").value = "{{$finder->find_addr2}}"
                                    }
                                    function setParentReci{{$finder->id}}(){
                                        opener.document.getElementById("reci_name").value = "{{$finder->find_name}}"
                                        opener.document.getElementById("reci_num1").value = "{{$finder->find_num1}}"
                                        opener.document.getElementById("reci_num2").value = "{{$finder->find_num2}}"
                                        opener.document.getElementById("reci_num3").value = "{{$finder->find_num3}}"
                                    }
                                </script>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    </div>
                @endif
                <tr>
                    <td>
                        <input type="button" value="창닫기" onclick="window.close()">
                    </td>
                </tr>
            </table>
    </form>
    <br>


    <!-- Current Tasks -->

@endsection
