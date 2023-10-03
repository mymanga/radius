<div class="alert alert-primary alert-dismissible alert-additional fade show" role="alert">
    <div class="alert-body">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <i class="ri-information-line fs-16 align-middle"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading">New Update Available! </h5>
                <p class="mb-0">Version: {{ $updateData['version'] }} (Released on: {{ $updateData['release_date'] }})</p>
            </div>
        </div>
    </div>
    <div class="alert-content">
        <p class="mb-0"><strong>What's new:</strong> {{ $updateData['summary'] }}</p><br>
        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changelogModal">View Changelog</button>
        <a href="{{ route('updater.index') }}" class="btn btn-info btn-sm">Click here to update</a>
    </div>
</div>

 <!-- Modal -->
<div class="modal fade" id="changelogModal" tabindex="-1" aria-labelledby="changelogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="changelogModalLabel">Changelog</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {!! $updateData['changelog'] !!}
            </div>
        </div>
    </div>
</div>