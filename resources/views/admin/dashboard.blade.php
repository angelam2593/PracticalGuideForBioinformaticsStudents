@extends('layouts.app_dashboard')

@section('content')
  <div id="wrapper">
    @include('layouts.left_menu')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.nav_menu')
        <div class="container-fluid">
          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">СЕМЕСТАР</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $godina->name }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-university fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Број на студенти</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">6</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Број на тематики</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ count($temi) }}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Број на задачи</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($zadaci) }}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-code fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
             <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Број на задачи од тематика</h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> Биолошки бази на податоци
                    </span>
                    <br>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Репликација и централна догма
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Студенти запишани оваа сесија</h6>
                </div>
                <div class="card-body" style="height: 360px;">
                  <div class="row">
                    <table class="table table-hover" id="table_dashboard" style="width: 100%;">
            <thead>
              <tr>
                <th scope="col">Индекс</th>
                <th scope="col">Име</th>
                <th scope="col">Презиме</th>
                <th scope="col">Смер</th>
                <th scope="col">Положеност</th>
              </tr>
            </thead>
            <tbody>
             @foreach($studenti_ovaa_godina as $student)
              <tr>
                <td scope="col">{{ $student->userid }}</td>
                <td scope="col">{{ $student->name }}</td>
                <td scope="col">{{ $student->surename }}</td>
                <td scope="col">{{ $student->smer->ime }}</td>
                <td scope="col">
                  @if($student->polozenost == 1)
                    <span class="badge badge-success">Положен</span>
                  @elseif($student->polozenost == NULL)
                     <span class="badge badge-warning">Го слуша предметот</span>
                  @else
                    <span class="badge badge-danger">Не е положен</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
                  </div>
                   <!-- <div class="row">
                <div class="col-md-12">
                  <div class="d-sm-flex align-items-center justify-content-between mb-4" style="position:absolute; right:0;">
                    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                </div>
                </div>-->
                    </div>
                </div>
               
              </div>
            </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Струденти запишани низ семестрите</h6>
                </div>
                <div class="card-body">
                 <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
              </div>
            </div>
             <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Положени vs. неположени студенти</h6>
                </div>
                <div class="card-body">
                 <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
          
  <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script>
  // Create the chart
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    credits: {
        enabled: false,
    },
    yAxis: {
        title: {
            text: 'Број на студенти'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> од тотално<br/>'
    },

    "series": [
        {
            "name": "Години/Семестри",
            "colorByPoint": true,
            "data": [
                {
                    "name": "leten 2018/2019",
                    "y": 6,
                    "drilldown": "leten 2018/2019"
                },
                {
                    "name": "leten 2017/2018",
                    "y": 5,
                    "drilldown": "leten 2017/2018"
                }
            ]
        }
    ]
});

Highcharts.chart('container2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    credits: {
        enabled: false,
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                }
            }
        }
    },
    series: [{
        name: 'Статус на положеност',
        colorByPoint: true,
        data: [{
            name: 'Положени студенти',
            y: 0,
            sliced: true,
            selected: true
        }, {
            name: 'Неположени студенти',
            y: 6
        }]
    }]
});
  </script>
@endsection
