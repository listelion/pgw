@extends('layouts.app')
@section('content')
    <!-- Bootstrap Boilerplate... -->
    @if ($id == 0)
        오류입니다.
    @endif
    @if ($id > 0)
        <form action="/trip/restore/{{$id}}" method="POST" class="form-horizontal">
            <div class="panel-body">
                <!-- Display Validation Errors -->
                <!-- New Task Form -->
            @csrf
            <!-- Task Name -->
                <div class="form-group">
                    <table>
                        <tr>
                            <td><br/>※ 반려 정보</td>
                        </tr>
                        <tr>
                            <td><label>반려사유 *</label></td>
                            <td><input type="text" name="r_comment" id="r_comment" class="form-control"></td>
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