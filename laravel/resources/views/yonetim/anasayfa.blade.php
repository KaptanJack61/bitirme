@extends('yonetim.layouts.master')

@section('title','SYTS | '.config('app.name'))

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Anasayfa</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Yardım Masası</a></li>
                            <li class="breadcrumb-item active">Anasayfa</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    @if(Auth::guard('yonetim')->user()->admin)

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $helps }}</h3>

                                    <p>Bugüne kadar yapılan yardım</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-hands-helping"></i>
                                </div>
                                <a href="{{ route('yapilanyardimlar.index') }}" class="small-box-footer">Detaylı Bilgi <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $people }}</h3>

                                    <p>Bugüne kadar yardım yapılan vatandaş</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-people-carry"></i>
                                </div>
                                <a href="#" class="small-box-footer">Detaylı Bilgi <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $maskeSayisi }}</h3>

                                    <p>Dağıtılan toplam maske</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-theater-masks"></i>
                                </div>
                                <a href="#" class="small-box-footer">Detaylı Bilgi <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                @endif
                <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $bekleyenTalep }}</h3>

                                <p>Bekleyen yardım talebi var</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-hand-paper"></i>
                            </div>
                            <a href="{{ route('yapilanyardimlar.notCompletedHelps') }}" class="small-box-footer">Detaylı Bilgi <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- LINE CHART -->
                        <div class="card card-info">
                            <div class="text-center mt-3">
                                <h4 class="card-title" id="daily-mask-title">Dağıtılan Maskelerin Günlük Değişimi</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart" style="height: 300px; width: 100%">
                                    <div id="daily-mask-loader" class="col-md-12 text-center"><img src="/img/loader.gif"></div>
                                    <div id="daily-mask-error" class="col-md-12 text-center" style="display: none"></div>
                                    <canvas id="daily-mask-chart" style="min-height: 250px; height: 300px; max-height: 350px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- LINE CHART -->
                        <div class="card card-info">
                            <div class="text-center mt-3">
                                <h4 class="card-title" id="daily-food-title">Verilen Erzakların Günlük Değişimi</h4>
                            </div>
                            <div class="card-body">
                                <div class="chart" style="height: 300px; width: 100%">
                                    <div id="daily-food-loader" class="col-md-12 text-center"><img src="/img/loader.gif"></div>
                                    <div id="daily-food-error" class="col-md-12 text-center" style="display: none"></div>
                                    <canvas id="daily-food-chart" style="min-height: 250px; height: 300px; max-height: 350px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
                <!-- /.row (main row) -->
                <br /><br /><br /><br />
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('script')
<script src="/js/plugins/chart.js/Chart.min.js"></script>
<script>
    let dailyMaskChartCanvas = $('#daily-mask-chart').get(0).getContext('2d');
    let dailyFoodChartCanvas = $('#daily-food-chart').get(0).getContext('2d');
    let dailyMaskData;
    let dailyFoodData;
    let dailyChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: false
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : true,
                    },
                    ticks: {
                        reverse: false
                    },
                    stacked: false
                }],
                yAxes: [{
                    gridLines : {
                        display : true,
                    },
                    stacked: false
                }]
            }
        };

        $.ajax({
                type: 'GET',
                url: "{{ route('statistic.dashboard.dashboardShowSumMask') }}",
                success: function(res) {
                    $('#daily-mask-loader').hide();
                    $('#daily-mask-chart').show();
                    $('#daily-mask-error').hide();
                    dailyMaskData = res;
                    dailyMaskData.datasets[0].fill = false;
                    dailyChartOptions.datasetFill = true;
                    var dailyMaskChart = new Chart(dailyMaskChartCanvas, {
                        type: 'line',
                        data: dailyMaskData,
                        options: dailyChartOptions
                    })
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'İstek yapılan sayfa bulunamadı. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'İstek server tarafında işlenirken hata oldu [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Zaman aşımı.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax isteği iptal oldu.';
                    } else {
                        msg = 'Bilinmeyen bir hata oldu.\n' + jqXHR.responseText;
                    }
                    $('#daily-mask-loader').hide();
                    $('#daily-mask-error').show().text(msg);
                },
        });

        $.ajax({
                type: 'GET',
                url: "{{ route('statistic.dashboard.dashboardShowSumFood') }}",
                success: function(res) {
                    $('#daily-food-loader').hide();
                    $('#daily-food-chart').show();
                    $('#daily-food-error').hide();
                    dailyFoodData = res;
                    dailyFoodData.datasets[0].fill = false;
                    dailyChartOptions.datasetFill = true;
                    var dailyFoodChart = new Chart(dailyFoodChartCanvas, {
                        type: 'line',
                        data: dailyFoodData,
                        options: dailyChartOptions
                    })
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'İstek yapılan sayfa bulunamadı. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'İstek server tarafında işlenirken hata oldu [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Zaman aşımı.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax isteği iptal oldu.';
                    } else {
                        msg = 'Bilinmeyen bir hata oldu.\n' + jqXHR.responseText;
                    }
                    $('#daily-food-loader').hide();
                    $('#daily-food-error').show().text(msg);
                },
        });

</script>

@endsection