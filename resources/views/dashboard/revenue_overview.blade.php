<div class="row ">
    @php
    $previous = null; // holds the sum of the previous month's transaction
    $growthPercentages = [];

    // Calculate growth percentages
    foreach($transactions as $index => $transaction) {
        $percentage = 0;
        if ($previous !== null) {
            $percentage = (($transaction->sum - $previous) / $previous) * 100;
        }
        $growthPercentages[] = $percentage;
        $previous = $transaction->sum; // update the previous sum for the next iteration
    }
    @endphp

    @foreach($transactions as $index => $transaction)
        @php
        $percentage = $growthPercentages[$index];
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate overflow-hidden">
                <!-- ... card styling ... -->

                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                            <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                {{$transaction->months}}
                            </p>
                            <h5 class=" mb-0"> KES <span class="counter-value" data-target="{{$transaction->sum}}"> {{$transaction->sum}}</span></h5>
                        </div>
                        <div class="flex-shrink-0 align-self-end">
                            @if($percentage == 0 && $index == 0)
                            <!-- No output for the first month -->
                            @elseif($percentage > 0)
                            <span class="badge badge-soft-success badge-percentage"><i class="ri-arrow-up-s-fill align-middle me-1"></i>{{ floor($percentage) }}%</span>
                            @elseif($percentage < 0)
                            <span class="badge badge-soft-danger badge-percentage"><i class="ri-arrow-down-s-fill align-middle me-1"></i>{{ floor($percentage) }}%</span>
                            @else
                            <span class="badge badge-soft-primary badge-percentage">0%</span>
                            @endif
                        </div>

                        <!-- ... rest of card content ... -->
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

