<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © {{Setting::get('company')}}.
            </div>
            @if(auth()->check() && auth()->user()->type != 'client')
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Designed & Developed by Simplux &nbsp; <span class="badge badge-outline-success">Version {{appVersion()}}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</footer>
