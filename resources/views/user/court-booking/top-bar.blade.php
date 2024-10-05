<div class="step-block row">
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('user/court-booking')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/court-booking') {{"active"}} @endif w-100  step-btn">1. Basic Information</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('user/court-information')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/court-information') {{"active"}} @endif w-100  step-btn">2. Court Information</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('user/court-book-description')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/court-book-description') {{"active"}} @endif w-100  step-btn">3. Description</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{url('user/court-book-images')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/court-book-images') {{"active"}} @endif w-100  step-btn">4. Images</a>
    </div>
   
</div>