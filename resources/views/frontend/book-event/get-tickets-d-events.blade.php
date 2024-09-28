@if(count($data->ticket_data))
    @foreach ($data->ticket_data as $item)
        <div class="p-2 border mb-2 single-ticket rounded text-lg-left text-center">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-5 col-12">
                    <h6 class="mb-0">{{$item->name}}</h6>
                    <p class="mb-0 ticket-description">{{$item->description}}</p>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="my-2">
                        <h5 class="price mb-0">
                            
                            @if ($item->discount_amount > 0)
                                <del class="pl-1 pr-2 text-muted">  ₹{{$item->price}}</del>
                            @endif
                            
                            <span>  
                                @php
                                    $totalAmnt = $item->price;
                                    if($item->discount_type == "FLAT"){
                                        $totalAmnt = ($item->price) - ($item->discount_amount);
                                    }elseif($item->discount_type == "DISCOUNT"){
                                        $totalAmnt = ($item->price) - ($item->price * $item->discount_amount)/100;
                                    }
                                @endphp
                                    ₹{{$totalAmnt}}
                                </span>
                        </h5>

                        @if($item->ticket_sold!=1)
                        @if($data->event_type=='Particular')
                            <b class="text-success  d-block">{{(($item->total_orders_sum_quantity!=null) && ($item->quantity - $item->total_orders_sum_quantity > 0)) ? ($item->quantity - $item->total_orders_sum_quantity) : $item->quantity}} Ticket Available</b>
                        @else
                            <b class="text-success  d-block">{{$item->quantity}} Ticket Available</b>
                        @endif
                        @else
                            <span class="text-danger text-center d-block">Tickets Soldout</b>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-12">
                    @if($item->ticket_sold!=1)
                        <a href="javascript:void(0)" data-amount="{{$totalAmnt}}" class="btn default-btn btn-sm buy_ticket_click" data-id="{{$item->id}}">Buy Ticket Now</a>
                    @endif
                </div>
            </div>
        
        </div>
    @endforeach
@else
    <h3 class="text-center">No Ticket Availble</h3>
@endif
{{-- @if(count($data->ticket_data))
<div class="row justify-content-center">
    @foreach ($data->ticket_data as $item)
        <div class="event-ticket card shadow-sm mb-3 col-md-4">
            <div class="card-body">

                <div class="single-ticket">
                    <span class="badge badge-pill badge-success">{{$item->name}}</span>
                    <h5 class="price mt-2">
                        <del class="ml-1 mr-2 text-muted">
                            @if ($item->discount_type != null)
                            ₹{{$item->price}}
                            @endif
                        </del>
                        <span>
                            @php
                                $totalAmnt = $item->price;
                                if($item->discount_type == "FLAT"){
                                    $totalAmnt = ($item->price) - ($item->discount_amount);
                                }elseif($item->discount_type == "DISCOUNT"){
                                    $totalAmnt = ($item->price) - ($item->price * $item->discount_amount)/100;
                                }
                            @endphp
                            ₹{{$totalAmnt}}
                        </span>
                        </h5>

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
                    </div>
                    @if($item->ticket_sold!=1)
                        <a href="javascript:void(0)" data-amount="{{$totalAmnt}}" class="btn default-btn w-100 buy_ticket_click" data-id="{{$item->id}}">Buy Ticket Now</a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
    <h3 class="text-center">No Ticket Availble</h3>
@endif --}}
