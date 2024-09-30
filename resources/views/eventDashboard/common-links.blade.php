@php
    $urlVar = app('request')->input('eq');
@endphp
<div class="step-block row">
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('/')}}/dashboard-events?eq='{{$urlVar}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/dashboard-events') {{"active"}} @endif w-100  step-btn">1. Basic Information</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('/')}}/dashboard-event-location?eq='{{$urlVar}}" class="btn btn-outline-primary w-100  @if(Request::url() === url('/').'/dashboard-event-location') {{"active"}} @endif step-btn">2.
            Location</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('/')}}/dashboard-event-description?eq='{{$urlVar}}" class="btn btn-outline-primary w-100 @if(Request::url() === url('/').'/dashboard-event-description') {{"active"}}@endif step-btn">3.
            Description</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('/')}}/dashboard-event-photos?eq='{{$urlVar}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/dashboard-event-photos') {{"active"}}@endif w-100 step-btn">4. Photos</a>
    </div>
</div>