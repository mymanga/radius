<div class="row">
   <div class="col-xl-12">
      <div class="card crm-widget">
         <div class="card-body p-0">
            <!-- System Resources -->
            <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-2 g-0">

               <!-- CPU Usage -->
               <div class="col col-small">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">CPU Usage <i class="ri-cpu-fill text-muted fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-cpu-line display-6 text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h3 class="mb-0"><span id="cpuload"></span>%</h3>
                           <div class="progress">
                              <div id="cpu_progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemax="100" style="width:%"></div>
                           </div>
                        </div>
                        <a class="text-muted">{{$operating_system ?? ''}}</a>
                     </div>
                  </div>
               </div>

               <!-- RAM Usage -->
               <div class="col col-last">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">RAM Usage <i class="ri-save-line text-info fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-save-3-fill display-6 text-muted"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="memused"></span>GB</h2>
                           <a class="text-muted">[Available: <span id="memavailable"></span> GB]</a>
                        </div>
                        <a class="d-none d-md-block">Total <span id="memtotal"></span> GB</a>
                     </div>
                  </div>
               </div>

               <!-- Disk Used -->
               <div class="col col-small no-bottom">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Disk Used <i class="ri-hard-drive-2-line text-info fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-hard-drive-2-line display-6 text-primary"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h3 class="mb-0"><span id="diskused"></span>GB</h3>
                           <a class="text-muted">[<span id="diskfree"></span> GB free]</a>
                        </div>
                        <a class="d-none d-md-block">Total <span id="disktotal"></span> GB</a>
                     </div>
                  </div>
               </div>

               <!-- Average Load Time -->
               <div class="col col-last no-bottom">
                  <div class="mt-md-0 py-4 px-3">
                     <h5 class="text-muted text-uppercase fs-13">Average Load Time <i class="ri-loader-2-line text-info fs-18 float-end align-middle"></i></h5>
                     <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                           <i class="ri-loader-2-line display-6 text-success"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                           <h2 class="mb-0"><span id="loadtime"></span>sec</h2>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
            <!-- end row -->
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   <!-- end col -->
</div>
