@if (session()->has('success'))
    <div class="alert alert-success d-flex justify-content-center align-items-center">
        <span class="fw-bold">{!! session()->get('success') !!}</span>
    </div>
@endif
@if (session()->has('error'))
    <div class="alert alert-danger d-flex justify-content-center align-items-center">
        <span class="fw-bold">{!! session()->get('error') !!}</span>
    </div>
@endif