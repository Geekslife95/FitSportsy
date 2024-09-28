@extends('frontend.qr-master')
@section('title', __('Book Tickets'))
@section('content')
<section class="section-area event-details">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card event-info-card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h4>{{ucwords(strtolower($data->name))}}</h4>
                           
                        </div>
                        <ul class="event-meta-info">
                            <li>
                                <span class="meta-icon" style="">
                                    <img src="{{asset('images/calender-icon.png')}}" alt="" class="img-fluid">
                                </span>
                                <div class="meta-content">
                                    @if($data->event_type=='Particular')
                                        <p>{{date("d",strtotime($data->start_time))}} <span>{{date("M Y",strtotime($data->start_time))}}</span> - </p>
                                        <p>{{date("d",strtotime($data->end_time))}} <span>{{date("M Y",strtotime($data->end_time))}}</span></p>
                                    @else
                                        <p><span>{{$data->recurring_days}}</span></p>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <span class="meta-icon" style="">
                                    <img src="{{asset('images/temple.png')}}" alt="" class="img-fluid">
                                </span>
                                <div class="meta-content">
                                    <p> <span>{{$data->temple_name}}</span></p>
                                </div>
                            </li>
                            <li>
                                <span class="meta-icon" style="">
                                    <img src="{{asset('images/location-icon.png')}}" alt="" class="img-fluid">
                                </span>
                                <div class="meta-content">
                                    <p><span>{{$data->address}}</span></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                @if(count($data->ticket_data))
                    @foreach ($data->ticket_data as $item)
                        <div class="event-ticket card shadow-sm mb-3">
                            <div class="card-body">
                                
                                <div class="single-ticket">
                                    <span class="badge badge-pill badge-success">{{$item->name}}</span>
                                    <h5 class="price mt-2">{{$currency.''.$item->price}}</h5>
                                    @if($data->event_type=='Particular')
                                        <span class="avalable-tickets ">{{(($item->total_orders_sum_quantity!=null) && ($item->quantity - $item->total_orders_sum_quantity > 0)) ? ($item->quantity - $item->total_orders_sum_quantity) : $item->quantity}} Ticket Available</span>
                                    @else
                                        <span class="avalable-tickets ">{{$item->quantity}} Ticket Available</span>
                                    @endif

                                    <div class="ticket-description">
                                        <p>{{$item->description}}</p>
                                    </div>
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
                                    <a href="{{$encLink}}" class="btn default-btn w-100">Buy Ticket Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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
@endpush
