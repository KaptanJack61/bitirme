@extends('yonetim.layouts.master')

@section('title','İstatistik | '.config('app.name'))
@section('header')

<link rel="stylesheet" href="/css/plugins/datatables/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/css/magic-check.min.css">

@stop

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">İstatistikler
                </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('yonetim.anasayfa') }}">Yardım Masası</a></li>
              <li class="breadcrumb-item active">İstatistikler</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <!-- Main content -->
  <section class="content">
      <section class="content">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <!--Accordion wrapper-->
                      <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

                          <!-- Accordion card -->
                          <div class="card">

                              <!-- Card header -->
                              <div class="card-header" role="tab" id="headingOne1">
                                  <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="false"
                                     aria-controls="collapseOne1">
                                      <h5 class="mb-0 text-dark">
                                          İstatistik Özelleştir
                                      </h5>
                                  </a>
                              </div>

                              <!-- Card body -->
                              <div id="collapseOne1" class="collapse hidden" role="tabpanel" aria-labelledby="headingOne1"
                                   data-parent="#accordionEx">
                                  <div class="card-body">
                                      <div class="col-md-12 row">
                                          @php($helpTypes = Helpers::getHelpTypes())
                                          @php($x=0)
                                          @foreach($helpTypes as $h)
                                              @php($x++)
                                              <div class="col-md-2 text-left">
                                                  <input class="magic-checkbox helptype" type="checkbox" name="helptypes[]" id="{{$h->slug}}" value="{{$h->id}}">
                                                  <label class="font-size-4 ml-4 mt" for="{{$h->slug}}" style="font-weight: normal">
                                                      {{ $h->name }}
                                                  </label>
                                              </div>
                                          @endforeach
                                          <div class="col-md-2 text-left">
                                              <input class="magic-checkbox" type="checkbox" name="allhelptype" id="allhelptype" value="0">
                                              <label class="font-size-4 ml-4 mt" for="allhelptype" style="font-weight: normal">
                                                  Hepsi
                                              </label>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="card-footer text-right">
                                      <a href="#" class="btn btn-success text-left" id="customize">
                                          <label class="fa fa-cog"> </label> Özelleştir
                                      </a>
                                  </div>
                              </div>

                          </div>
                          <!-- Accordion card -->

                      </div>
                      <!-- Accordion wrapper -->
                  </div>
                  <div class="col-md-8">

                      <!-- MAHALLE CHART -->
                      <div class="card card-info" id="neighborhood-chart-card">
                          <div class="card-body text-center">

                              <div class="text-center mt-0">
                                  <h4 class="card-title" id="neighborhood-title"></h4>
                              </div>

                              <div class="chart" style="width: 100%; height: 450px;">
                                  <div id="nb-loader" class="col-md-12 text-center"><img src="/img/loader.gif"></div>
                                  <div id="nb-error" class="col-md-12 text-center" style="display: none"></div>
                                  <canvas id="neighborhood-chart" style="min-height: 250px; height: 450px; max-height: 450px; max-width: 100%; display: none"></canvas>
                              </div>

                          </div>
                          <!-- /.card-body -->
                      </div>
                      <!-- /.card -->

                  </div>
                  <!-- /.col (LEFT) -->
                  <div class="col-md-4">
                    <div class="col-md-12">
                        <!-- BAR CHART -->
                        <div class="card card-success">

                            <div class="card-body">
                                <div class="text-center mt-3">
                                    <h4 class="card-title" id="helptype-title"></h4>
                                </div>
                                <div class="chart" style="width: 100%; height: 410px;">
                                    <div id="yt-loader" class="col-md-12 text-center"><img src="/img/loader.gif"></div>
                                    <div id="yt-error" class="col-md-12 text-center" style="display: none"></div>
                                    <canvas id="yardim-turu-chart" style="min-height: 250px; height: 410px; max-height: 450px; max-width: 100%; display: none"></canvas>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                  </div>

                  <div class="col-md-12">
                      <!-- LINE CHART -->
                      <div class="card card-info">
                          <div class="text-center mt-3">
                              <h4 class="card-title" id="daily-title"></h4>
                          </div>
                          <div class="card-body">
                              <div class="chart" style="height: 350px; width: 100%">
                                  <div id="daily-loader" class="col-md-12 text-center"><img src="/img/loader.gif"></div>
                                  <div id="daily-error" class="col-md-12 text-center" style="display: none"></div>
                                  <canvas id="daily-chart" style="min-height: 250px; height: 350px; max-height: 350px; max-width: 100%;"></canvas>
                              </div>
                          </div>
                          <!-- /.card-body -->
                      </div>
                  </div>

                  <!-- /.col (RIGHT) -->
              </div>
              <!-- /.row -->
          </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<br /><br /><br /><br />

@stop

@section('script')
    <script src="/js/plugins/chart.js/Chart.min.js"></script>
    <script>

        function addData(chart, label, datasets) {
            chart.data.labels = label;
            chart.data.datasets = datasets
            chart.update();
        }

        function removeData(chart) {
            chart.data.labels = [];
            chart.data.datasets.forEach((dataset) => {
                dataset.data = [];
            });
            chart.update();
        }

        let neighborhoodsChartCanvas = $('#neighborhood-chart').get(0).getContext('2d');
        let dailyChartCanvas = $('#daily-chart').get(0).getContext('2d');
        let helpTypesChartCanvas = $('#yardim-turu-chart').get(0).getContext('2d');

        let neighborhoodsChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            legend: {
                display: true
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                xAxes: [
                    {
                        beginAtZero: true,
                        ticks: {
                            autoSkip: false
                        },
                        stacked: false
                    }
                ],
                yAxes: [
                    {
                        stacked: false
                    }
                ]
            }
        };

        let dailyChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: true
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

        let helpTypeChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            legend: {
                display: true
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            scales: {
                xAxes: [
                    {
                        beginAtZero: true,
                        ticks: {
                            autoSkip: false
                        }
                    }
                ]
            }
        }

        let neighborhoodsData;
        let dailyData;
        let helpTypeChartData;

        let neighborhoodsChart;
        let dailyChart;
        let helpTypeChart;


        $(function () {

            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */
            $.ajax({
                type: 'POST',
                url: "{{ route('statistic.neighborhoodPie') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    $('#nb-loader').hide();
                    $('#neighborhood-chart').show();
                    $('#nb-error').hide();
                    neighborhoodsData = res;
                    neighborhoodsChart = new Chart(neighborhoodsChartCanvas, {
                        type: 'bar',
                        data: neighborhoodsData,
                        options: neighborhoodsChartOptions
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
                    $('#nb-loader').hide();
                    $('#nb-error').show().text(msg);
                },
            });


            // Güünlük değişim tablosu
            $.ajax({
                type: 'POST',
                url: "{{ route('statistic.daily.line') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    $('#daily-loader').hide();
                    $('#daily-chart').show();
                    $('#daily-error').hide();
                    dailyData = res;
                    dailyData.datasets[0].fill = false;
                    dailyChartOptions.datasetFill = true;
                    dailyChart = new Chart(dailyChartCanvas, {
                        type: 'line',
                        data: dailyData,
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
                    $('#daily-loader').hide();
                    $('#daily-error').show().text(msg);
                },
            });

            //Yardım Türüne göre
            $.ajax({
                type: 'POST',
                url: "{{ route('statistic.helptype.cycle') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    $('#yt-loader').hide();
                    $('#yardim-turu-chart').show();
                    $('#yt-error').hide();
                    helpTypeChartData = res;
                    helpTypeChart = new Chart(helpTypesChartCanvas, {
                        type: 'bar',
                        data: helpTypeChartData,
                        options: helpTypeChartOptions
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
                    $('#yt-loader').hide();
                    $('#yt-error').show().text(msg);
                },
            });
        })

        function changeChooseHelpType() {
            var checked = $( ".helptype:checked" ).length;
            var hepsi = {{ $x }};

            if(hepsi == checked) {
                $('#allhelptype').prop('checked', true);

            }else {
                $('#allhelptype').prop('checked', false);

            }
        }

        $('#allhelptype').change(function () {
            if(this.checked) {
                $('.helptype').prop('checked', true);
            }else{
                $('.helptype').prop('checked', false);
            }
        });

        $('.helptype').change(function () {

            changeChooseHelpType();

        });

        $('#customize').click(function () {

            var checked = $( ".helptype:checked" ).length;

            if(checked == 0){
                return false;
            }

            var urlnb = "";
            var urldc = "";
            let allhelptypechecked = $( "#allhelptype:checked" ).length;

            if( allhelptypechecked == 1) {
                urlnb = "{{ route('statistic.neighborhoodPie') }}";
                urldc = "{{ route('statistic.daily.line') }}";
                urlht = "{{ route('statistic.helptype.cycle') }}"
            }else {
                urlnb = "{{ route('statistic.customize') }}";
                urldc = "{{ route('statistic.customize.daily') }}";
                urlht = "{{ route('statistic.customize.helpType') }}"
            }

            var data = new Array();

            if ($('.helptype').is(":checked"))
            {
                $( ".helptype:checked" ).each(function(){
                    data.push($(this).val());
                });
            }
            
            //Mahalle Dağılımı
            $.ajax({
                type: 'POST',
                url: urlnb,
                data:{
                    helptypes: data,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#nb-loader').show();
                    $('#neighborhood-chart').hide();
                },
                success: function(res) {
                    $('#nb-loader').hide();
                    $('#neighborhood-chart').show();
                    $('#nb-error').hide();

                    removeData(neighborhoodsChart);
                    addData(neighborhoodsChart,res.labels,res.datasets);

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
                    $('#nb-loader').hide();
                    $('#nb-error').show().text(msg);
                },
            });

            //Yardım Türü Değişim
            $.ajax({
                type: 'POST',
                url: urlht,
                data:{
                    helptypes: data,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#yt-loader').show();
                    $('#yardim-turu-chart').hide();
                },
                success: function(res) {
                    $('#yt-loader').hide();
                    $('#yardim-turu-chart').show();
                    $('#yt-error').hide();

                    res.datasets.forEach((dataset)=>{
                        dataset.fill = false;
                    });

                    if( allhelptypechecked == 1) {
                        helpTypeChart.destroy();
                        helpTypeChart = new Chart(helpTypesChartCanvas, {
                            type: 'bar',
                            data: res,
                            options: helpTypeChartOptions
                        });
                        $('#helptype-title').text("");
                    }else {
                        helpTypeChart.destroy();

                        var options = {
                            responsive: true,
                            maintainAspectRatio     : false,
                            datasetFill             : false,
                            legend: {
                                display: true,
                                position: "bottom",
                                align: "start"
                            },
                            title: {
						        display: true,
						        text: res.customTitle
					        },
                            tooltips: {
                                mode: 'index',
                                intersect: false
                            },                       
                        }
                    
                        helpTypeChart = new Chart(helpTypesChartCanvas, {
                            type: 'pie',
                            data: res,
                            options: options
                        });
                    
                        var labels = "";
                        var str = "";
                        res.customLabel.forEach((label)=>{
                            str = str + label + ", "
                            var strlength = str.length;
                            labels = str.substring(0, strlength - 2);
                        });

                        $('#helptype-title').text(labels);
                    }

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
                    $('#yt-loader').hide();
                    $('#yt-error').show().text(msg);
                },
            });

            // Günlük Değişim
            $.ajax({
                type: 'POST',
                url: urldc,
                data:{
                    helptypes: data,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $('#daily-loader').show();
                    $('#daily-chart').hide();
                },
                success: function(res) {
                    $('#daily-loader').hide();
                    $('#daily-chart').show();
                    $('#daily-error').hide();

                    res.datasets.forEach((dataset)=>{
                        dataset.fill = false;
                    });

                    removeData(dailyChart);
                    addData(dailyChart,res.labels,res.datasets);

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
                    $('#daily-loader').hide();
                    $('#daily-error').show().text(msg);
                },
            });

            $('#collapseOne1').removeClass('show');
            $('#collapseOne1').addClass('hidden');

        });
    </script>


@stop