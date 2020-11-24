@extends('layouts.app')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['상품', '개수'],
            @foreach($sale_products as $sale_product)
            ['{{$sale_product->addr_product}}' , {{$sale_product->amount}}],
            @endforeach
        ]);
        var options = {
            title: '상품 누적 판매량'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['일자', '양주성', '허순례'],
            @foreach($address_daily_counts as $k => $v)
            ['{{$k}}', {{$address_daily_counts[$k][1]}},{{$address_daily_counts[$k][3]}}],
            @endforeach
        ]);

        var options = {
            title: 'Company Performance',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="#">오늘 해야할일</a></div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">발송준비중</div>
                <div class="card-body">
                    @if(count($address_counts) > 0)
                        @foreach($address_counts as $address_count)
                            {{$address_count->addr_send_date}} : {{$address_count->addr_user_id}} {{$address_count->count}}건<br>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">입금확인중</div>
                <div class="card-body">
                    @if(count($deposit_counts) > 0)
                        @foreach($deposit_counts as $deposit_count)
                            {{$deposit_count->addr_send_date}} : {{$deposit_count->addr_user_id}} {{$deposit_count->count}}건<br>
                        @endforeach
                    @endif</div>
            </div>
        </div>
    </div>
</div>
<div id="piechart" style="width: 700px; height: 400px;"></div>
<div id="curve_chart" style="width: 700px; height: 400px"></div>
<example></example>

@endsection