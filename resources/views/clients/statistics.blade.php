@extends('layouts.master') @section('title') statistics @endsection @section('css')
<link href="{{URL::asset('assets/js/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('assets/css/datatable-custom.css')}}" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/highcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/modules/exporting.min.js"></script>
@endsection @section('content') 
{{-- @component('components.breadcrumb') @slot('li_1') Services @endslot @slot('title') Online @endslot @endcomponent --}}
<div class="row">
   <div class="col-lg-12">
      <div class="card mt-n4 mx-n4">
         <div class="bg-soft-light">
            @include('clients.header')
            <!-- end card body -->
         </div>
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row h-100">
   <div class="col-lg-4 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-timer-fill align-middle"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                     Total time
                  </p>
                  <h4 class=" mb-0">{{ isset($time) ? calculateSessionTime($time) : 'Time is not set' }}</h4>
                  {{-- gmdate("H:i:s", $time) --}}
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-lg-4 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-download-cloud-2-fill align-middle"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                     Download
                  </p>
                  <h4 class=" mb-0">{{ isset($download) ? formatSizeUnits($download) : 'N/A' }}</h4>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
   <div class="col-lg-4 col-md-6">
      <div class="card">
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                  <i class="ri-upload-cloud-2-fill align-middle"></i>
                  </span>
               </div>
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Upload</p>
                  <h4 class="mb-0">{{ isset($upload) ? formatSizeUnits($upload) : 'N/A' }}</h4>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
<div class="row">
   <div class="col-lg-12">
      <div class="card" id="orderList">
         <div style="margin-bottom:-10px; border-bottom:none" class="card-header">
            <div class="d-flex align-items-center">
               <h5 class="card-title mb-0 flex-grow-1"><i class="ri-notification-badge-fill text-success"></i> Online Sessions</h5>
            </div>
         </div>
         <div class="card-body">
            <div>
               @if(isset($client) && count($client->activeServices))
               <div class="table-responsive table-card mb-1">
                  <table class="table table-nowrap align-middle" id="datatable-online" style="width: 100%;">
                     <thead class="text-muted table-light">
                        <tr class="text-uppercase">
                           <th></th>
                           <th>Client</th>
                           <th>Package</th>
                           <th>Name</th>
                           <th>Username</th>
                           <th>Ip address</th>
                           <th>Start Time</th>
                           <th>Download</th>
                           <th>Upload</th>
                           <th>Time online</th>
                        </tr>
                     </thead>
                     <tbody class="list form-check-all">
                        @foreach($client->activeServices as $service)
                        <tr class="no-border">
                           <td><span class="badge badge-soft-success text-uppercase">online</span></td>
                           <td>{{$client->firstname}} {{$client->lastname}}</td>
                           <td>{{$service->package->name}}</td>
                           <td>{{$service->description}}</td>
                           <td>{{$service->username}}</td>
                           <td>{{$service->framedipaddress}}</td>
                           <td>{{Carbon\Carbon::parse($service->acctstarttime)->format('d M Y H:i')}}</td>
                           <td><i class="ri-download-2-fill text-info"></i> {{formatSizeUnits($service->acctoutputoctets)}}</td>
                           <td><i class="ri-upload-2-fill text-info"></i> {{formatSizeUnits($service->acctinputoctets)}}</td>
                           <td>{{calculateSessionTime($service->acctsessiontime)}}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
               @else
               <div class="noresult" style="display: block;">
                  <div class="text-center">
                     <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width: 75px; height: 75px;"> </lord-icon>
                     <h5 class="mt-2 text-danger">Sorry! No service Online at the moment</h5>
                  </div>
               </div>
               @endif
            </div>
            <!--end modal -->
         </div>
      </div>
      {{-- Data usage card --}}
   </div>
   <!--end col-->
</div>
<!-- Chart -->
<div class="row">
   <div class="col-lg-12">
      <div class="d-flex align-items-center mb-3">
         <div class="flex-grow-1">
            <h5 class="mb-0 text-uppercase text-muted">Live bandwidth </h5>
         </div>
         <div class="flex-shrink-0">
            @if(count($client->activeServices))
            <select class="form-select" name="interface" id="interface">
               @foreach($client->activeServices as $service) 
               <option value='{{$service->username}}'>{{$service->username}} - {{$service->package->name}} </option>
               @endforeach
            </select>
            @else
            <p>No online services found.</p>
            @endif
         </div>
      </div>
      <div class="card">
         <div hidden>
            <select id="type_interface" name="type_interface">
               <option value="1" selected>interfaces</option>
            </select>
         </div>
         <div class="card-header border-bottom-dashed">
            <div class="d-flex text-center">
               <h5 style="margin-bottom:-10px" class="card-title flex-grow-1" id="trafik"></h5>
               <div class="flex-shrink-0"></div>
            </div>
         </div>
         <div class="card-body">
            <div id="chart"></div>
         </div>
      </div>
   </div>
</div>
<!--end row-->
@endsection @section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/datatables/datatables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/datatable.js') }}"></script>
<script>
   $(document).ready(function () {
       $('#datatable-online').DataTable({
           responsive: true,
           deferRender: true,
           paging: false,
           searching: false,
           info: false,
       });
   });
</script>

<script >
    function formatBytes(a, b) {
        if (0 == a) return "0 Bytes";
        var c = 1024,
            d = b || 2,
            e = ["Bytes", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"],
            f = Math.floor(Math.log(a) / Math.log(c));
        return parseFloat((a / Math.pow(c, f)).toFixed(d)) + " " + e[f]
    }

var chart;

function requestDatta(interface, type_interface) {
    $.ajax({
        url: "{{route('nas.traffic')}}",
        data: {
            interface: interface,
            type_interface: type_interface
        },
        datatype: "json",
        success: function(data) {
            var midata = JSON.parse(data);
            if (midata.length > 0) {
                var TX = parseInt(midata[0].data);
                var RX = parseInt(midata[1].data);
                var x = (new Date()).getTime();
                shift = chart.series[0].data.length > 19;
                chart.series[0].addPoint([x, TX], true, shift);
                chart.series[1].addPoint([x, RX], true, shift);
                document.getElementById("trafik").innerHTML = "<h5><i class='ri-download-2-line text-success'></i>&nbsp;&nbsp;" + formatBytes(TX) + "&nbsp;&nbsp;&nbsp;<i class='ri-upload-2-line text-primary'></i>&nbsp;&nbsp;" + formatBytes(RX) + "</h5>";
            } else {
                document.getElementById("trafik").innerHTML = "- / -";
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
            console.error("Error: " + errorThrown);
        }
    });
}

$(document).ready(function() {
    Highcharts.setOptions({
        global: {
            useUTC: false
        },
        colors: ['#40d30e', '#8085e9', '#8d4654', '#7798BF', '#aaeeee',
            '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'
        ],
        chart: {
            backgroundColor: null,
        },
        title: {
            style: {
                color: 'black',
                fontSize: '16px',
                fontWeight: 'bold'
            }
        },
        credits: {
            enabled: false
        },
        subtitle: {
            style: {
                color: 'black'
            }
        },
        tooltip: {
            borderWidth: 5
        },
        legend: {
            itemStyle: {
                fontWeight: 'bold',
                fontSize: '13px'
            }
        },
        xAxis: {
            gridLineWidth: 1,
            labels: {
                style: {
                    color: '#6e6e70'
                }
            }
        },
        yAxis: {
            gridLineWidth: 1,
            labels: {
                style: {
                    color: '#6e6e70'
                }
            }
        },
        navigator: {
            xAxis: {
                gridLineColor: '#D0D0D8'
            }
        },
        scrollbar: {
            trackBorderColor: '#C0C0C8'
        },
    });


    chart = new Highcharts.Chart({
        chart: {
            plotOptions: {
                areaspline: {
                    fillOpacity: 0.1
                }
            },
            type: 'areaspline',
            renderTo: 'chart',
            animation: Highcharts.svg,
            events: {
                load: function() {
                    setInterval(function() {
                        var e = document.getElementById("type_interface");
                        var type_interface = e.options[e.selectedIndex].value;
                        requestDatta(document.getElementById("interface").value, type_interface);
                    }, 2000);
                }
            }
        },
        title: {
            text: ''
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 60,
            maxZoom: 10 * 2000
        },
        yAxis: {
            title: {
                text: 'speed',
                margin: 0
            },
            labels: {
                formatter: function() {
                    var bytes = this.value;
                    var sizes = ['b', 'kb', 'Mb', 'Gb', 'Tb'];
                    if (bytes == 0) return '0 bps';
                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                },
            },
        },
        tooltip: {
            formatter: function() {
                var bytes = this.y;
                var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                if (bytes == 0) return '0 bps';
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return '<b>' + this.series.name + '</b>' + ': ' + parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i] + '<br>';
            }
        },
        series: [{
            name: '(TX)',
            data: [],
            dashStyle: 'dash',
            //  color: "#FFA500",
            color: '#eca762',
        }, {
            name: '(RX)',
            data: [],
            dashStyle: 'dash',
            color: "#b2e5e9",
        }]
    });
}); 
</script>
@endsection