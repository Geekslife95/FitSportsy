@extends('frontend.master', ['activePage' => 'event'])
@section('title', __($data->name.'-'.$data->temple_name))
@section('content')

@push('scripts')
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=65327c612ee074001200f29d&product=inline-share-buttons&source=platform" async="async"></script>
@endpush
<section class="section-area event-details">
    <div class="container">
        <div class="banner-image mb-4">
            @isset($data->banner_img)
                <img src="{{asset('images/upload/'.$data->banner_img)}}" class="w-100 img-fluid rounded border" alt="...">
            @endisset
        </div>
        <div class="row">
            {{-- <a target="_blank" href="">Facebook</a> --}}
            <div class="col-lg-8 col-md-8 col-12">
                <div class="d-flex align-items-center justify-content-between pb-3 ">
                    <div>
                        <h5>Share Now</h5>
                    </div>
                    <div class="sharethis-inline-share-buttons" style="position: relative;z-index: 1;"></div>


                    {{-- <div>
                        <a href="https://www.facebook.com/sharer.php?u={{Request::url()}}" target="_blank" class="btn btn-sm btn-primary btn-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        @php
                            $title = $data->name;
                            $short_url = Request::url();


                            $twitterlink = "http://twitter.com/share?text=$title&url=$short_url";
                            $walink = "whatsapp://send?text=$short_url";
                        @endphp

                        <a href="{{$walink}}" target="_blank" class="btn btn-sm btn-success btn-circle">
                            <i class="fab fa-whatsapp"></i>
                        </a>


                        <a href="{{$twitterlink}}" target="_blank" class="btn btn-sm btn-info btn-circle">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div> --}}
                </div>
                {{-- <div class="event-img shadow-sm">
                	<span class="badge badge-pill badge-warning eventcat">{{$data->category->name}}</span>
                    @if(count($images))
                    <img src="{{asset('images/upload/'.$images[0])}}" alt="" class="img-fluid" id="cover_img">
                    @endif
                </div> --}}
            </div>
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
        <div class="row mb-3">
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
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                        <div class="meta-content">
                                            @if($data->event_type=='Particular')
                                                <p>{{date("d",strtotime($data->start_time))}} <span>{{date("M Y",strtotime($data->start_time))}}</span> - </p>
                                                <p>{{date("d",strtotime($data->end_time))}} <span>{{date("M Y",strtotime($data->end_time))}}</span></p>
                                            @elseif($data->event_type=='Reccuring')
                                                <p style="margin-top:3px;"><span>{{str_replace(",",", ",$data->recurring_days)}}</span></p>
                                            @else
                                                <p style="margin-top:3px;"><span>On Request Supershows</span></p>
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <span class="meta-icon" style="">
                                            <i class="fas fa-gopuram"></i>
                                        </span>
                                        <div class="meta-content">
                                            <p style="margin-top:3px;"> <span>{{$data->temple_name}}</span></p>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="meta-icon" style="">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <div class="meta-content">
                                            <p style="margin-top:3px;"><span>{{$data->address}}</span></p>
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
                                        <p><i class="fas fa-heart " style="width: 20px;"></i>Pray with your heart, serve with your hands</p>
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
                            {{-- <div id="short_desc">{!!substr(strip_tags($data->description),0,400)!!}<a href="javascript:void(0)" id="read_more_click" style="display:block;"> Read More...</a></div> --}}
                            <div id="full_desc" >{!!$data->description!!}</div>
                        </div>
                    </div>
                </div>

                <div class="card about-event shadow-sm mb-3">
                    <div class="card-body">
                        <h4 class="mb-0">
                            <a href="javascript:void(0)" class="text-light w-100 d-block" id="toggleTerms">
                                <i id="icon" class="fas fa-plus text-warning"></i> Terms and Conditions
                            </a>
                        </h4>
                    
                        <div class="terms-description pt-3" id="termsContent" style="display: none;">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Please ensure that you bring a valid ID proof for verification at the venue.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Purchased tickets are non-refundable, even in case of event postponement or rescheduling.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Security protocols, including thorough checks and frisking, are at the discretion of the event management.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Dangerous or restricted items such as weapons, knives, fireworks, helmets, laser pointers, bottles, and musical instruments are strictly prohibited inside the venue.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> The event organizers, sponsors, and performers are not liable for any injuries, damages, or losses that occur during the event. Any disputes will be settled exclusively in Mumbai courts.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Entry may be denied to individuals appearing intoxicated or under the influence of substances.
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-light"></i> Late entry will not be allowed after the event begins, as per the discretion of the organizers.
                                </li>
                                <li>
                                    <i class="fas fa-check-circle text-light"></i> All attendees must adhere to the specific rules and regulations of the venue.
                                </li>
                            </ul>
                            
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
                                {{-- <span class="badge badge-pill badge-success">{{$item->name}}</span>
                                <h5 class="price mt-2">
                                    <del class="ml-1 mr-2 text-muted">
                                        @if ($item->discount_type != null)
                                        ₹{{$item->price}}
                                        @endif
                                    </del>
                                     </h5> --}}
                               {{-- 
                                @if($item->ticket_sold!=1)
                                    @if($data->event_type=='Particular')
                                        <span class="avalable-tickets ">{{(($item->total_orders_sum_quantity!=null) && ($item->quantity - $item->total_orders_sum_quantity > 0)) ? ($item->quantity - $item->total_orders_sum_quantity) : $item->quantity}} Ticket Available</span>
                                    @else
                                        <span class="avalable-tickets ">{{$item->quantity}} Ticket Available</span>
                                    @endif
                                @else
                                    <span class="text-danger text-center">Tickets Soldout</span>
                                @endif

                                <div class="ticket-description">
                                    <p>{{$item->description}}</p>
                                </div> --}}
                                @php
                                    $inputObj = new stdClass();
                                    $inputObj->params = 'id='.$item->id.'&type='.$data->event_type;
                                    $inputObj->url = url('book-event-ticket');
                                    $encLink = Common::encryptLink($inputObj);
                                @endphp
                                {{-- @if(Auth::guard('appuser')->check())
                                    <a href="{{$encLink}}" class="btn default-btn w-100">Buy Ticket Now</a>
                                @else
                                    <a href="{{url('user-login')}}" class="btn default-btn w-100">Buy Ticket Now</a>
                                @endif --}}
                                @if($item->ticket_sold != 1)
                                    <a href="{{$encLink}}" class="btn default-btn w-100">Continue To Book {{$data->category->name}}</a>
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
        @if(count($images) > 0)
        <h2>Star Cast</h2>
            <div class="d-flex flex-wrap">
                @foreach ($images as $img)
                    @if ($img != null)
                        <div class="p-2">
                            <img src="{{asset('images/upload/'.$img)}}" style="width:120px !important;height:120px !important;padding:2px;" class="rounded-circle bg-light img-fluid" alt="...">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        @if(count($relatedEvents))
        <div class="row mt-3">
            <div class="col-md-12">
                <h4>Related Events</h4>
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
                                <h5 class="card-title mb-2"><u>{{$val->name}}</u></h5>
                                  <p class="card-text mb-0">
                                    <small class="text-dark" title="{{ $val->temple_name }}"><i class="fas fa-map-marker-alt pr-2"></i>
                                      {{ strlen($val->temple_name) > 50 ? substr($val->temple_name, 0, 50) . '...' : $val->temple_name }}
                                    </small>
                                  </p>
        
                                  @if ($val->event_type == "Recurring")
                                    @php
                                        $days = explode(',', $val->recurring_days);
                                        $slotTime =  explode(',', $val->slot_time);
                                        $currentDaySlot = array_search(date('l'), $days);
                                    @endphp
                                    <p class="my-1 text-light"><small><i class="fas fa-calendar-alt pr-2"></i> {{$currentDaySlot}}</small></p>
                                  @else
                                    <p class="my-1 text-light"><small style="font-size: 12px !important;"><i class="fas fa-calendar-alt pr-2"></i> {{date('F d | H:i A',strtotime($val->start_time))}} - {{date('F d | H:i A',strtotime($val->end_time))}}</small></p>
                                  @endif
        
                                 
        
                                  <span class="text-warning">{{$val->event_cat}}</span>
                                 <div class="mt-2 d-flex justify-content-between align-items-center">
                                    @if ($val->discount_amount > 0)
                                    {{-- <p class="font-weight-bold h6 text-dark mb-0">
                                         
                                    </p> --}}
                                    @endif 
                                    <p class=" h6 text-dark mb-1">
                                        <small>
                                            <del class="mr-1 text-muted "> 
                                                ₹{{$val->price}}
                                            </del>
                                        </small>
                                        <span class="font-weight-bold pr-2">
                                            @if ($val->discount_type == "FLAT")
                                            ₹{{($val->price) - ($val->discount_amount) }}
                                            @elseif($val->discount_type == "DISCOUNT")
                                            ₹{{($val->price) - ($val->price * $val->discount_amount)/100 }}
                                            @else
                                            ₹{{$val->price}}
                                            @endif
                                        </span>
                                        @if ($val->discount_amount > 0)
                                        <small class="text-danger">
                                            @if ($val->discount_type == "FLAT")
                                            {{$val->discount_type}} ₹{{$val->discount_amount}} OFF
                                            @endif 
                                            @if ($val->discount_type == "DISCOUNT")
                                            {{$val->discount_amount}}% OFF
                                            @endif     
                                        </small>
                                        @endif     
                                    </p>
                                    <a href="{{url('event/'.$val->id.'/'.Str::slug($val->name))}}" class="mt-1 btn btn-success btn-sm mb-1 ">Book Now</a>
                                </div>
                            
                            </div>
                        </div>
                    </div>
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
    {{-- <script>
        $("#read_more_click").on('click',function(){
            $("#short_desc").hide();
            $("#full_desc").show();
        })
    </script> --}}

<script>
    $(document).ready(function() {
        $('#toggleTerms').click(function() {
            $('#termsContent').slideToggle(); // Slide toggle for animation
            var icon = $('#icon');

            if (icon.hasClass('fa-plus')) {
                icon.removeClass('fa-plus').addClass('fa-minus');
            } else {
                icon.removeClass('fa-minus').addClass('fa-plus');
            }
        });
    });
</script>
@endpush
