@extends('frontend.master', ['activePage' => 'event'])
{{-- @section('title', __($weekends->name)) --}}
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
                    <img alt="" height="atuo" width="100%" src="/upload/weekend/{{$weekends->profile_photo}}"/>
                  </div>

                 {{-- <img width="100%" height="auto" src="/upload/weekend/{{$weekends->profile_photo}}" class="rounded" alt="..."> --}}



                 <h1 class="h6 mb-3 mt-4 font-weight-bold text-gray-900">Personal Info</h1>
                 <p class="mb-3"><b class="text-danger"><i class="fas fa-street-view me-2"></i>    Name :</b> {{$weekends->name}}</p>
                <p class="mb-3"><b class="text-danger"><i class="far fa-envelope me-2"></i>   Email :</b> {{$weekends->email}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-mobile-alt me-2"></i>   Phone :</b> {{$weekends->phone}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-map-marked-alt me-2"></i>   Location :</b>  {{$weekends->location}}</p>
                <p class="mb-3"><b class="text-danger"><i class="far fa-star me-2"></i>   Hobbies :</b> {{$weekends->hobbies}}</p>
                <p class="mb-3"><b class="text-danger"><i class="fas fa-language me-2"></i>   Language Spoken :</b> {{$weekends->lang}}</p>
             </div>
         </div>
         <div class="col-md-8 col-lg-9">
             <div class="row">
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Prefered Destinations :- <span class="text-danger">{{$weekends->prefered_destinations}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Interest :- <span class="text-danger">{{$weekends->travel_interest}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Trip Budget :- <span class="text-danger">{{$weekends->budget}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Transportation :- <span class="text-danger">{{$weekends->transportation}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Accomodation Prefered :- <span class="text-danger">{{$weekends->accomodation_prefered}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Travel Style :- <span class="text-danger">{{$weekends->travel_style}}</span> </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Weekent Avability :- <span class="text-danger">{{$weekends->weekend_avability}}</span>  </h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                        <h1 class="h6 mb-0 mt-0 font-weight-bold text-gray-900">Companionship Preference :- <span class="text-danger">{{$weekends->companionship_preference}}</span> </h1>
                    </div>
                </div>
             </div>
             <div class="bg-white p-3 widget shadow-sm rounded mb-4">
                 <h1 class="h6 mb-3 mt-0 font-weight-bold text-gray-900">Additional Comments</h1>
                 <div class="row px-3">
                    <p>{{$weekends->additional_comments}}</p>
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
