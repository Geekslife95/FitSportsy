@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('All Events'))
@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-12">
                    <h3 class="page-title">Ticket Information</h3>
                </div>
            </div>
        </div>
        
        <!-- /Page Header -->
        <div class="row">
            @if ($ticket != NULL)
                @foreach ($ticket as $item)
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{$item->ticket_number}}</h5>
                            </div>
                            <div class="card-body py-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex justify-content-between">Ticket Name: <span
                                            class="text-primary pl-3">{{$item->name}}</span></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">Quantity: <span
                                            class="text-primary pl-3">{{$item->quantity}}</span></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">Ticket Type : <span
                                        class="text-primary pl-3">{{ucfirst($item->type)}}</span></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">Price: <span
                                            class="text-primary pl-3">₹{{$item->price}}</span></li>
                                    <li class="list-group-item px-0 d-flex justify-content-between">Status: <span
                                            class="badge badge-success ">{{$item->status == 1 ? "Active" : "Inactive" }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="col-lg-12 col-12">
                <div class="card text-center">
                    <div class="card-body">
                        <img src="{{asset('/images/add-ticket.png')}}" alt="" class="img-fluid mx-auto" width="450px">
                        <div class="mt-3">
                            <a href="{{$subLink}}" class="btn btn-outline-primary px-3 mx-1 mb-2"><i
                                    class="fas fa-plus-circle"></i> {{ count($ticket) > 0 ? "Add Another Ticket" : "Add Ticket"}}  </a>
                            @if (count($ticket) > 0 )
                            <a href="{{$subLink2}}" class="btn btn-primary px-3 mx-1 mb-2">Next Step <i
                                class="far fa-arrow-alt-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection