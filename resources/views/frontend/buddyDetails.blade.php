@extends('frontend.master', ['activePage' => 'event'])
{{-- @section('title', __($buddyDetails->name)) --}}
@section('content')


<section class="section-area buddy-details">
    <div class="container pt-5 pb-4">
     <div class="row list-bp">
         <div class="col-md-4 col-lg-3">
             <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                <div class="box">
                    <div class="cover-ribbon">
                       <div class="cover-ribbon-inside">Verified</div>
                    </div>
                    <img width="100%" height="auto" src="/upload/buddy/{{$buddyDetails->profile_photo}}" class="rounded" alt="...">
                  </div>

                 {{-- <img width="100%" height="auto" src="/upload/buddy/{{$buddyDetails->profile_photo}}" class="rounded" alt="..."> --}}
                 <h1 class="h6 mb-3 mt-4 font-weight-bold text-gray-900">Personal Info</h1>
                 <p class="mb-3"><b class="text-danger"><i class="fas fa-street-view me-2"></i>    Name :</b> {{$buddyDetails->name}}</p>
                <p class="mb-3"><b class="text-danger"><i class="far fa-envelope me-2"></i>   Email :</b> {{$buddyDetails->email}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-mobile-alt me-2"></i>   Phone :</b> {{$buddyDetails->phone}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-venus-mars me-2"></i>   Gender :</b> {{$buddyDetails->gender == 1 ? "Male" : ($buddyDetails->gender == 2 ? "Female" : "Other" )}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-map-marked-alt me-2"></i>   Location :</b>  {{$buddyDetails->location}}</p>
                <p class="mb-3"><b class="text-danger"><i class="far fa-calendar-alt me-2"></i>   DOB :</b> {{$buddyDetails->dob}}</p>
                <p class="mb-3"><b class="text-danger"><i class="far fa-star me-2"></i>   Hobbies :</b> {{$buddyDetails->hobbies}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-language me-2"></i>   Language Spoken :</b> {{$buddyDetails->lang}}</p>
             </div>
         </div>
         <div class="col-md-8 col-lg-9">
             <div class="bg-white info-header shadow-sm rounded mb-4">
                 <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                     <div>
                         <h3 class="text-gray-900 mb-0 mt-0 font-weight-bold"><img width="40px" height="40px" class="rounded-circle" src="/upload/buddy/{{$buddyDetails->profile_photo}}" alt=""> {{$buddyDetails->name}}</h3>
                     </div>
                     <div>
                         {{-- <a href="" class="btn btn-primary">
                             <p class="text-white mb-0">Share</p>
                         </a> --}}
                     </div>
                 </div>
                 <div class="p-3 mb-4">
                     <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Trip Discription</h1>
                     <div>
                         <p class="mb-0 text-gray-600">
                            <div id="short_desc">{!!substr(strip_tags($buddyDetails->trip_desc),0,400)!!}<a href="javascript:void(0)" id="read_more_click" style="color:blue;display:block;"> Read More...</a></div>
                            <div id="full_desc" style="display: none;">{!!$buddyDetails->trip_desc!!}</div>
                         </p>
                     </div>
                 </div>
             </div>
             <div class="row">
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Trip Budget :- <span class="text-danger">{{$buddyDetails->budget}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Date :- <span class="text-danger">{{$buddyDetails->travel_date}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Destination :- <span class="text-danger">{{$buddyDetails->destination}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Interests :- <span class="text-danger">{{$buddyDetails->travel_interests}}</span> </h1>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Preference :- <span class="text-danger">{{$buddyDetails->travel_preference}}</span> </h1>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Style :- <span class="text-danger">{{$buddyDetails->travel_style}}</span></h1>
                    </div>
                </div>
             </div>
             <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                 <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Additional Comments</h1>
                 <div class="row px-3">
                    <p>{{$buddyDetails->Additional_comment}}</p>
                 </div>
             </div>
         </div>
     </div>
 </div>
</section>

@endsection
@push('scripts')
    <script>
        $(".event_img").on('click',function(){
            var src = $(this).attr('src');
            $("#cover_img").attr('src',src);
        })
    </script>
    <script>
        $("#read_more_click").on('click',function(){
            $("#short_desc").hide();
            $("#full_desc").show();
        })
    </script>
@endpush
