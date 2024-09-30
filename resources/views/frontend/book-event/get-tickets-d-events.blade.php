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