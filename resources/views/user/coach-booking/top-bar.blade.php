<div class="step-block row">
    <div class="col-lg-4 col-md-4 col-6">
        <a href="{{url('user/coach-book')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/coach-book') {{"active"}} @endif w-100  step-btn">1. Basic Information</a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
        <a href="{{url('user/coach-book-information')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/coach-book-information') {{"active"}} @endif w-100  step-btn">2. Coach Book Information</a>
    </div>
    <div class="col-lg-4 col-md-4 col-6">
        <a href="{{url('user/coach-book-media')}}" class="btn btn-outline-primary @if(Request::url() === url('/').'/user/coach-book-media') {{"active"}} @endif w-100  step-btn">3. Images</a>
    </div>
   
</div>