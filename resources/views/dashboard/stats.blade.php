<div class="row">
   <div class="col-xl-12">
      <div class="card crm-widget bg-marketplace">
         <div class="card-body p-0">
            <div class="row row-cols-xxl-3 row-cols-md-3 row-cols-2 g-0">
               <div class="col col-small">
                  <div class="py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">All Clients <i class="ri-user-2-fill text-info fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-team-fill display-6 text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="totalclients">{{$total_clients}}</span></h2>
                        </div>
                        <a href="{{route('client.index')}}" class="text-muted d-none d-md-block">View clients</a>
                        <a href="{{route('client.index')}}" class="text-muted d-md-none">View</a>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Online Sessions <i class="ri-wifi-fill text-success fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-pulse-line display-6 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="onlinesessions">{{$onlinesessions}}</span></h2>
                        </div>
                        <a href="{{route('client.online')}}" class="text-muted d-none d-md-block">View Sessions</a>
                        <a href="{{route('client.online')}}" class="text-muted d-md-none">View</a>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col col-last col-small">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Active Services <i class="ri-shut-down-fill text-primary fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-space-ship-line display-6 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="activeservices">{{$services}}</span></h2>
                        </div>
                        <a href="{{ route('client.view.services', ['type' => 'active']) }}" class="text-muted d-none d-md-block">View all</a>
                        <a href="{{ route('client.view.services', ['type' => 'active']) }}" class="text-muted d-md-none">View</a>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Inactive Services <i class="ri-shut-down-fill text-danger fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-arrow-left-down-fill display-6 text-danger"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="inactiveservices">{{$inactiveservices}}</span></h2>
                        </div>
                        <a href="{{ route('client.view.services', ['type' => 'inactive']) }}" class="text-muted d-none d-md-block">View all</a>
                        <a href="{{ route('client.view.services', ['type' => 'inactive']) }}" class="text-muted d-md-none">View</a>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col col-small no-bottom">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Consumed data [24h] <i class="ri-database-2-fill text-warning fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-stack-fill display-6 text-warning"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h3 class="mb-0"><span id="consumed_data">{{$totaldata}}</span></h3>
                           <span class="nowrap"> <i class="ri-arrow-up-circle-line text-muted align-middle"></i> <span id="upload" class="text-muted"> {{$totalupload}}</span></span>
                           <span class="nowrap"> <i class="ri-arrow-down-circle-line text-muted align-middle"></i> <span id="download" class="text-muted"> {{$totaldownload}}</span></span>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end col -->
               <div class="col col-last no-bottom">
                  <div class="py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Payments today<i class="ri-money-dollar-circle-line text-info fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-exchange-dollar-line display-6 text-info"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h4 class="mb-0"><span id="payments">{{$payments}}</span></h4>
                           <span class="text-muted"><span>This month:</span></span>
                           <span class="text-muted"><span id="monthpayments">{{$monthpayments}}</span></span>
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