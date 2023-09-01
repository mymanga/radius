<div class="row">
   <div class="col-xl-12">
      <div class="d-flex flex-column h-100">
         <div class="row">
            <div class="col-xl-4 col-md-4">
               <a href="{{ route('client.view.services', ['type' => 'expiring']) }}">
                  <div class="card card-animate overflow-hidden">
                     <div class="position-absolute start-0" style="z-index: 0;">
                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                           <style>
                              .s0 {
                              opacity: .05;
                              fill: var(--vz-success)
                              }
                           </style>
                           <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                        </svg>
                     </div>
                     <div class="card-body" style="z-index:1 ;">
                        <div class="d-flex align-items-center">
                           <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Expiring Today <i class="ri-links-line text-info"></i></p>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">KES <span class="counter-value" data-target="{{ $totalExpiringAmount }}">{{ number_format($totalExpiringAmount) }}</span></h4>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="position-relative border-circle" style="width: 70px; height: 70px;">
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(50%); background-color: rgba(118, 184, 215, 0.2);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 2px)); background-color: rgba(118, 184, 215, 0.5);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 4px)); background-color: rgba(118, 184, 215, 0.8);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle d-flex align-items-center justify-content-center stat-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 6px));">
                                    <span class="fs-22">{{ count($services_expiring_today) }}</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end card body -->
                  </div>
                  <!-- end card -->
               </a>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-md-4">
               <a href="{{ route('client.view.services', ['type' => 'dormant']) }}">
                  <div class="card card-animate overflow-hidden">
                     <div class="position-absolute start-0" style="z-index: 0;">
                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                           <style>
                              .s0 {
                              opacity: .05;
                              fill: var(--vz-success)
                              }
                           </style>
                           <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                        </svg>
                     </div>
                     <div class="card-body" style="z-index:1 ;">
                        <div class="d-flex align-items-center">
                           <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> Dormant Services <i class="ri-links-line text-info"></i></p>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">KES <span class="counter-value" data-target="{{ $totalDormantAmount }}">{{ number_format($totalDormantAmount) }}</span></h4>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="position-relative border-circle" style="width: 70px; height: 70px;">
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(50%); background-color: rgba(241, 143, 1, 0.2);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 2px)); background-color: rgba(241, 143, 1, 0.5);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 4px)); background-color: rgba(241, 143, 1, 0.8);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle d-flex align-items-center justify-content-center stat-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 6px));">
                                    <span class="fs-22">{{ count($services_dormant) }}</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end card body -->
                  </div>
                  <!-- end card -->
               </a>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-md-4">
               <a href="{{ route('client.view.services', ['type' => 'new']) }}">
                  <div class="card card-animate overflow-hidden">
                     <div class="position-absolute start-0" style="z-index: 0;">
                        <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                           <style>
                              .s0 {
                              opacity: .05;
                              fill: var(--vz-success)
                              }
                           </style>
                           <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                        </svg>
                     </div>
                     <div class="card-body" style="z-index:1 ;">
                        <div class="d-flex align-items-center">
                           <div class="flex-grow-1 overflow-hidden">
                              <p class="text-uppercase fw-medium text-muted text-truncate mb-3"> New services <code class="text-muted">[{{ date('M') }}]</code> <i class="ri-links-line text-info"></i> </p>
                              <h4 class="fs-22 fw-semibold ff-secondary mb-0">KES <span class="counter-value" data-target="{{ $totalNewAmount }}">{{ number_format($totalNewAmount) }}</span></h4>
                           </div>
                           <div class="flex-shrink-0">
                              <div class="position-relative border-circle" style="width: 70px; height: 70px;">
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(50%); background-color: rgba(10, 179, 156, 0.2);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 2px)); background-color: rgba(10, 179, 156, 0.5);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 4px)); background-color: rgba(10, 179, 156, 0.8);"></div>
                                 <div class="position-absolute top-0 start-0 border-circle d-flex align-items-center justify-content-center stat-circle" style="width: 100%; height: 100%; clip-path: circle(calc(50% - 6px));">
                                    <span class="fs-22">{{ count($services_created_this_month) }}</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- end card body -->
                  </div>
               </a>
               <!-- end card -->
            </div>
            <!--end col-->
         </div>
         <!--end row-->
      </div>
   </div>
</div>