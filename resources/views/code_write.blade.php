@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    @if ($id == 0)
        <form action="/code" method="POST" class="form-horizontal">
            <div class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
            @csrf
            <!-- Task Name -->
                <div class="form-group">
                    <table>
                        <tr>
                            <td><label>코드번호</label></td>
                            <td><input type="text" name="code" id="code" class="form-control" value="{{$default_code}}"></td>
                        </tr>
                        <tr>
                            <td><label>내용</label></td>
                            <td><input type="text" name="content" id="content" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label>소속</label></td>
                            <td><select name="class" id="class" class="form-control">
                                    <option value="0" selected>최상위</option>
                                    @foreach($sub_codes as $sub_code)
                                        <option value="{{$sub_code->id}}" @if($request->class == $sub_code->id) selected @endif>{{$sub_code->content}}</option>
                                    @endforeach
                                </select></td>
                        </tr>

                    </table>
                </div>
            </div>
            <table>
                <tr>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus"></i> 저장
                            </button>
                        </div>
                    </div>
                </tr>
            </table>
        </form>
    @endif
    @if ($id > 0)
        <form action="/code/{{$id}}" method="POST" class="form-horizontal">
            <div class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
            @csrf
            <!-- Task Name -->
                <div class="form-group">
                    <table>
                        <tr>
                            <td><label>코드번호</label></td>
                            <td><input type="text" name="code" id="code" value={{$code->code}} class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label>내용</label></td>
                            <td><input type="text" name="content" id="content" value={{$code->content}} class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label>소속</label></td>
                            <td><select name="class" id="class" class="form-control">
                                    <option value="0" @if($code->class == 0) selected @endif>최상위</option>
                                    @foreach($sub_codes as $sub_code)
                                        <option value="{{$sub_code->id}}" @if($sub_code->code == $code->class) selected @endif>{{$sub_code->content}}</option>
                                    @endforeach
                                </select></td>
                        </tr>
                       
                    </table>
                </div>
            </div>
            <table>
                <tr>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-plus"></i> 저장
                            </button>
                        </div>
                    </div>
                </tr>
            </table>
        </form>
    @endif
    <!-- Current Tasks -->
@endsection