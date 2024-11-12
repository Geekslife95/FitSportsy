@php
    $inputObj = new stdClass();
    $inputObj->params = 'coaching_id='.$bookData->id;
    $inputObj->url = url('user/edit-coach-book');
    $encLink = Common::encryptLink($inputObj);

    $inputObj1 = new stdClass();
    $inputObj1->params = 'coaching_id='.$bookData->id;
    $inputObj1->url = url('user/edit-coach-book-information');
    $encLink1 = Common::encryptLink($inputObj1);

    $inputObj2 = new stdClass();
    $inputObj2->params = 'coaching_id='.$bookData->id;
    $inputObj2->url = url('user/edit-coach-book-session');
    $encLink2 = Common::encryptLink($inputObj2);

    $inputObj3 = new stdClass();
    $inputObj3->params = 'coaching_id='.$bookData->id;
    $inputObj3->url = url('user/edit-coach-book-media');
    $encLink3 = Common::encryptLink($inputObj3);
@endphp

<div class="step-block row">
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{$encLink}}" class="btn btn-outline-primary @if($type === 'basic_info') {{"active"}} @endif w-100  step-btn">1. Basic Information</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{$encLink1}}" class="btn btn-outline-primary @if($type === 'book_info') {{"active"}} @endif w-100  step-btn">2. Coach Book Information</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{$encLink2}}" class="btn btn-outline-primary @if($type === 'session_details') {{"active"}} @endif w-100  step-btn">3. Session Details</a>
    </div>
    <div class="col-lg-3 col-md-3 col-6">
        <a href="{{$encLink3}}" class="btn btn-outline-primary @if($type === 'images') {{"active"}} @endif w-100  step-btn">4. Images</a>
    </div>
</div>