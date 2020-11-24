@extends('master')
@extends('menu')
@section('content')
    <table>
        <tr>
            @for($x = 0; $x < 11; $x++)
                <th>{{$x}}</th>
            @endfor
        </tr>
        @for($y = 1; $y < 7; $y++)
            <tr>
                <th>{{$y}}</th>
                @for($x = 1; $x < 11; $x++)
                    <td>
                        @foreach($citys as $city)
                            @if($city->city_x == $x && $city->city_y == $y)
                                {{ $city->city_name }}
                            @endif
                        @endforeach
                    </td>
                @endfor
            </tr>
        @endfor
    </table>
@stop
@include('footer')
