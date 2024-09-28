@extends('frontend.master', ['activePage' => 'event'])
@section('title', __($data->name.'-'.$data->temple_name))
@section('content')
<section class="section-area event-details">
    <div class="container">
        <div class="pt-3 mb-4 pb-3">
            <div class="osahan-slider" id="myslider">
                @if(count($images))
                    @foreach ($images as $img)
                    <div class="osahan-slider-item bg-white shadow-sm"><a href="{{asset('images/upload/'.$img)}}"><img
                            src="{{asset('images/upload/'.$img)}}" class="w-100 img-fluid rounded" alt="..."></a></div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-lg-8 col-md-8 col-12">
                <div class="event-img shadow-sm">
                	<span class="badge badge-pill badge-warning eventcat">{{$data->category->name}}</span>
                    @if(count($images))
                    <img src="{{asset('images/upload/'.$images[0])}}" alt="" class="img-fluid" id="cover_img">
                    @endif
                </div>
            </div> --}}
            {{-- <div class="col-lg-4 col-md-4 col-12">
                <div class="event-other-card shadow-sm">
                    <h5>Image Gallery</h5>
                    <div class="row">
                        @if(count($images))
                            @foreach ($images as $img)
                                <div class="col-lg-6 col-lg-6 col-6" style="cursor: pointer;">
                                    <div class="event-other-img">
                                        <img src="{{asset('images/upload/'.$img)}}" alt="" class="img-fluid event_img">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card event-info-card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="row mb-3">
                           <div class="col-lg-7 col-md-6 col-12"><h4>{{$data->name}}</h4></div>
                           <div class="col-lg-5 col-md-6 col-12">
                            <div class="small-user-info">
                                <img src="{{asset('images/upload/'.$data->organization->image)}}" alt="" class="img-fluid">
                                <div>
                                    <h6 class="mb-0">{{ucwords(strtolower($data->organization->name.' '.$data->organization->first_name.' '.$data->organization->last_name))}}</h6>
                                    <small>Organize By</small>
                                </div>
                            </div>
                           </div>                          
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-7 col-md-6 col-12">
                                <ul class="event-meta-info">
                                    <li>
                                        <span class="meta-icon" style="">
                                            {{-- <img src="{{asset('images/calender-icon.png')}}" alt="" class="img-fluid"> --}}
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <div class="meta-content">
                                            @if($data->event_type=='Particular')
                                                <p>{{date("d",strtotime($data->start_time))}} <span>{{date("M Y",strtotime($data->start_time))}}</span> - </p>
                                                <p>{{date("d",strtotime($data->end_time))}} <span>{{date("M Y",strtotime($data->end_time))}}</span></p>
                                            @elseif($data->event_type=='Reccuring')
                                                <p><span>{{str_replace(",",", ",$data->recurring_days)}}</span></p>
                                            @else
                                                <p><span>On Request Adventure</span></p>
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <span class="meta-icon" style="">
                                            {{-- <img src="{{asset('images/temple.png')}}" alt="" class="img-fluid"> --}}
                                            <i class="fas fa-bell"></i>
                                        </span>
                                        <div class="meta-content">
                                            <p> <span>{{$data->temple_name}}</span></p>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="meta-icon" style="">
                                            {{-- <img src="{{asset('images/location-icon.png')}}" alt="" class="img-fluid"> --}}
                                            <i class="fas fa-map-marker"></i>
                                        </span>
                                        <div class="meta-content">
                                            <p><span>{{$data->address}}</span></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-5 col-md-6 col-12">
                                <ul class="list-unstyled">
                                    <li>
                                       <p><i class="fas fa-bolt" style="width: 20px;"></i>Instant Confirmation</p>
                                    </li>
                                    <li>
                                        <p><i class="fas fa-mobile " style="width: 20px;"></i>Mobile Ticket</p>
                                    </li>
                                    <li>
                                        <p><i class="fas fa-heart " style="width: 20px;"></i>Adventure with your heart, explore with your spirit.
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <div class="card about-event shadow-sm mb-3">
                    <div class="card-body">
                        <h4>About Event</h4>
                        <div class="description">
                            <div id="short_desc">{!!substr(strip_tags($data->description),0,400)!!}<a href="javascript:void(0)" id="read_more_click" style="color:blue;display:block;"> Read More...</a></div>
                            <div id="full_desc" style="display: none;">{!!$data->description!!}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                @if(count($data->ticket_data))
                    @foreach ($data->ticket_data as $item)
                    @endforeach
                    <div class="event-ticket card shadow-sm mb-3">
                        <div class="card-body">
                            <div class="single-ticket">
                                @php
                                $inputObj = new stdClass();
                                $inputObj->params = 'id='.$item->id.'&type='.$data->event_type;
                                $inputObj->url = url('book-event-ticket');
                                $encLink = Common::encryptLink($inputObj);
                                @endphp
                                @if($item->ticket_sold!=1)
                                <a href="{{$encLink}}" class="btn default-btn w-100">Continue To Book Tickets</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="products-reviews">
                            <h3>Reviews</h3>
                            <div class="rating">
                                <h4 class="h3">4.5</h4>
                                <div>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star checked"></span>
                                    <span class="fas fa-star"></span>
                                </div>
                                <div>
                                    <p class="mb-0">501 review</p>
                                </div>
                            </div>
                            <div class="rating-count">
                                <span>Total review count and overall rating based on Visitor and Tripadvisior reviews</span>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>5 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-5"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>02</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>4 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-4"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>03</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>3 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-3"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>04</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>2 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-2"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>05</div>
                                </div>
                            </div>
                            <div class="rating-row">
                                <div class="side">
                                    <div>1 <span class="fas fa-star"></span></div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container">
                                        <div class="bar-1"></div>
                                    </div>
                                </div>
                                <div class="side right">
                                    <div>00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>














            </div>
        </div>

        @if(count($relatedEvents))
        <div class="row mt-3">
            <div class="col-md-12">
                <h4>Related Adventures</h4>
                <div class="event-block-slider">
                    @foreach ($relatedEvents as $val)

                    <div class="card m-card shadow-sm border-0 listcard">
                        <div>
                            <div class="m-card-cover">
                                <img src="{{asset('images/upload/'.$val->image)}}" class="card-img-top" alt="{{$val->name}}">
                            </div>
                            <div class="card-body">
                                @php
                                    $num = rand(3,5);
                                @endphp
                                <div class="rating-star mb-1">
                                        @for($i=1;$i<=5;$i++) <small><i class="fas fa-star {{$i<=$num ? 'active':''}}"></i></small>
                                        @endfor
                                        <span class="text-dark"> ({{$num}}) Ratings</span>
                                </div>
                                <h5 class="card-title mb-0">{{$val->name}}</h5>
                                 <p class="card-text mb-0"><small class="text-dark">{{$val->temple_name}}</small></p>
                                 <div class="mt-2">
                                   
                                    <a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}" class="btn btn-success btn-sm w-100">Book Ticket</a>
                                 
                                   
                                </div>
                            
                            </div>
                        </div>
                    </div>

                        {{-- <div class="card m-card shadow-sm border-0">
                            <a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}">
                                <div class="m-card-cover">
                                    <img src="{{asset('images/upload/'.$val->image)}}" class="card-img-top" alt="{{$val->name}}">
                                </div>
                                <div class="card-body p-3">
                                    <h5 class="card-title mb-1 text-dark">{{$val->name}}</h5>
                                    <p class="card-text mb-0"><small class="text-dark">{{$val->temple_name}}</small></p>
                                    @php
                                        $num = rand(3,5);
                                    @endphp

                                    <div class="rating-star">
                                        @for($i=1;$i<=5;$i++)
                                        <i class="fas fa-star {{$i<=$num ? 'active':''}}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </a>
                        </div> --}}
                    @endforeach
                </div>
            </div>
        </div>
        @endif

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
