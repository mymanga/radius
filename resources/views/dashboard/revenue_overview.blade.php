<div class="row ">
   @php
   // initialize it with 0
   $counter = 0;
   // Loop starts from here
   foreach ($transactions as $item) { 
   // Check condition if count is 0 then
   // it is the first iteration
   // then it is last iteration
   if( $counter == count( $transactions ) - 1) { 
   // Print the array content
   $previous = $item->sum;
   } 
   $counter = $counter + 1;
   }
   @endphp
   @foreach($transactions as $transaction)
   @php
   $percentage = ($transaction->sum - $previous)/$previous *100;
   @endphp
   <div class="col-lg-4 col-md-6">
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
         <div class="card-body">
            <div class="d-flex align-items-center">
               <div class="flex-grow-1 ms-3">
                  <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                     {{$transaction->months}}
                  </p>
                  <h5 class=" mb-0"> KES <span class="counter-value" data-target="{{$transaction->sum}}"> {{$transaction->sum}}</span></h5>
               </div>
               <div class="flex-shrink-0 align-self-end">
                  @if($transaction->sum == $previous)
                  @elseif($transaction->sum > $previous)
                  <span class="badge badge-soft-success badge-percentage"><i class="ri-arrow-up-s-fill align-middle me-1"></i>{{floor($percentage)}}
                  %<span>
                  @else
                  <span class="badge badge-soft-danger badge-percentage"><i class="ri-arrow-down-s-fill align-middle me-1"></i>{{floor($percentage)}}
                  %<span>
                  @endif
               </div>
               <div class="avatar-sm flex-shrink-0">
                  <span class="avatar-title bg-light text-info rounded-circle fs-3">
                  <i class="ri-money-dollar-circle-fill align-middle"></i>
                  </span>
               </div>
            </div>
         </div>
         <!-- end card body -->
      </div>
      <!-- end card -->
   </div>
   @endforeach
   <!-- end col -->
</div>