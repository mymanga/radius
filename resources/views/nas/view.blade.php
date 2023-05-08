@extends('layouts.master') @section('title') view nas @endsection 
@section('css') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/highcharts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/10.0.0/modules/exporting.min.js"></script>
@endsection
 @section('content') @component('components.breadcrumb') @slot('li_1') Nas @endslot @slot('title') Create @endslot
@endcomponent
<!-- .card-->
<div class="row">
   <div class="col-xl-12">
      <div class="card crm-widget">
         <div class="card-body p-0">
            <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-1 g-0">
               <div class="col">
                  <div class="py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">System date & time <i class="ri-calendar-line text-primary fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-calendar-fill display-6 text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <p class="mb-0">{{ucfirst($clock['date'])}} {{$clock['time']}}</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Uptime:</span> {{$resource['uptime']}}</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Timezone:</span> {{$clock['time-zone-name']}} </p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-3 mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Routerboard <i class="ri-information-line text-primary fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-information-fill display-6 text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Board Name:</span> {{$resource['board-name']}}</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Model:</span> {{$routerboard['model']}}</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Router OS:</span> {{$resource['version']}} </p>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-3 mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">System resources <i class="ri-cpu-fill text-primary fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-cpu-line display-6 text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">CPU Load:</span> {{$resource['cpu-load']}}%</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Free Memory:</span> {{formatSizeUnits($resource['free-memory'])}}</p>
                           <p class="mb-0"><span class="text-muted text-uppercase fs-13">Free HDD:</span> {{formatSizeUnits($resource['free-hdd-space'])}} </p>
                        </div>
                     </div>
                  </div>
               </div>
               
               <!-- end col -->
            </div>
            <!-- end row -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>

<!-- Chart -->
<div class="row">
  <div class="col-lg-12">
    <div class="d-flex align-items-center mb-3">
      <div class="flex-grow-1">
        <h5 class="mb-0 text-uppercase text-muted">Live bandwidth </h5>
      </div>
      <div class="flex-shrink-0">
        <select class="form-select" name="interface" id="interface">
          @foreach($interfaces as $interface) 
          <option value='{{$interface['name']}}'>{{$interface['name']}} {{$interface['comment'] ?? ''}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="card">
      <div hidden>
        <input type="number" id="nas" name="nas" value="{{$nas->id}}">
        <select id="type_interface" name="type_interface">
          <option value="0" selected>interfaces</option>
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

@endsection 
@section('script')
<script src="{{ URL::asset('/assets/js/jquery-3.6.1.js')}}"></script>
<script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>

<script> 
		function formatBytes(a,b){if(0==a)return"0 Bytes";var c=1024,d=b||2,e=["Bytes","KB","MB","GB","TB","PB","EB","ZB","YB"],f=Math.floor(Math.log(a)/Math.log(c));return parseFloat((a/Math.pow(c,f)).toFixed(d))+" "+e[f]}

		var chart;
		function requestDatta(interface,type_interface,nas) {
			$.ajax({
				 url: "{{route('nas.traffic')}}",
             data: { interface: interface, type_interface: type_interface, nas:nas },
				datatype: "json",
				success: function(data) {
					var midata = JSON.parse(data);
					if( midata.length > 0 ) {
						var TX=parseInt(midata[0].data);
						var RX=parseInt(midata[1].data);
						var x = (new Date()).getTime(); 
						shift=chart.series[0].data.length > 19;
						chart.series[0].addPoint([x, TX], true, shift);
						chart.series[1].addPoint([x, RX], true, shift);
						document.getElementById("trafik").innerHTML="<h5><i class='ri-download-2-line text-success'></i>&nbsp;&nbsp;" +formatBytes(TX) +  "&nbsp;&nbsp;&nbsp;<i class='ri-upload-2-line text-primary'></i>&nbsp;&nbsp;" +formatBytes(RX)+"</h5>";
					}else{
						document.getElementById("trafik").innerHTML="- / -";
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
					console.error("Status: " + textStatus + " request: " + XMLHttpRequest); console.error("Error: " + errorThrown); 
				}       
			});
		}	

		$(document).ready(function() {
				Highcharts.setOptions({
					global: {
						useUTC: false
					},
				    colors: ['#40d30e', '#8085e9', '#8d4654', '#7798BF', '#aaeeee',
				        '#ff0066', '#eeaaee', '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
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
						load: function () {
                     setInterval(function () {
                        var e = document.getElementById("type_interface");
                        var nas = document.getElementById("nas").value;
								var type_interface = e.options[e.selectedIndex].value;
								requestDatta(document.getElementById("interface").value,type_interface,nas);
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
	              formatter: function () {
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
	                return '<b>'+ this.series.name +'</b>'+': '+parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i]+'<br>';
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