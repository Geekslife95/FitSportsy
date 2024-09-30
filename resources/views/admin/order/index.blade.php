@extends('master')

@section('content')
@php
    $currency = 'INR';
@endphp
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('View Orders'),
    ])
    <div class="section-body">

        <div class="row">
            <div class="col-12">
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                    

                    <div class="row mb-4 mt-2">
                               

                        <div class="col-lg-3">
                            <div class="form-group">
                              
                                <div class="input-group">
                                  <input type="text" id="search_txt"  class="form-control">
                                  <div class="input-group-append">
                                    <div class="input-group-text" id="search_btn" style="cursor: pointer;">
                                      <i class="fas fa-search"></i>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>


                  <div class="table-responsive">

                    <table class="table" id="event_table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('Order Id')}}</th>
                                <th>{{__('Customer Name')}}</th>
                                <th>{{__('Customer Mobile')}}</th>
                                <th>{{__('Organiser')}}</th>
                                <th>{{__('Event Name')}}</th>
                                <th>{{__('Slot Time')}}</th>
                                <th>{{__('Slot Date')}}</th>
                                <th>{{__('Sold Ticket')}}</th>
                                <th>{{__('Payment')}}</th>
                                <th>{{__('Payment Gateway')}}</th>
                                <th>{{__('Payment ID')}}</th>
                                <th>{{__('Order Date')}}</th>
                                <th class="d-none">{{ __('Order Status') }}</th>{{-- for print and pdf only --}}
                                <th>{{__('Order Status')}}</th>
                                <th class="d-none">{{ __('Payment Status') }}</th>{{-- for print and pdf only --}}
                                <th>{{__('Payment Status')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i=1;
                            @endphp
                            @foreach ($orders as $item)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$item->order_id}} </td>
                                    @isset($item->orderchildC->devotee_persons)
                                    @php
                                        $pData = json_decode($item->orderchildC->devotee_persons);
                                    @endphp
                                    @endisset
                                    <td>@isset ($pData->prasada_name) {{$pData->prasada_name}} @endisset</td>
                                    <td>@isset ($pData->prasada_mobile){{$pData->prasada_mobile}} @endisset</td>
                                    <td>{{$item->organization->first_name.' '.$item->organization->last_name}}</td>
                                    <td>
                                        <h6 class="mb-0">{{$item->event->name}}</h6>
                                        {{-- <p class="mb-0">{{$item->event->start_time}}</p> --}}
                                    </td>
                                    <td>{{$item->ticket_slot}}</td>
                                    <td>{{$item->ticket_date}}</td>
                                    <td>{{$item->quantity.' ticket'}}</td>
                                    <td>{{$currency.$item->payment}}</td>
                                    <td>{{$item->payment_type}}</td>
                                    <td>{{$item->payment_token}}</td>
                                    <td>
                                        <p class="mb-0">{{$item->created_at->format('Y-m-d')}}</p>
                                        <p class="mb-0">{{$item->created_at->format('h:i a')}}</p>
                                    </td>
                                    <td class="d-none">{{ $item->order_status }}</td>{{-- for print and pdf only --}}
                                    <td>
                                         <select name="order_status" id="status-{{ $item->id }}" class="form-control p-2" onchange="changeOrderStatus({{$item->id}})" {{ $item->order_status == "Complete" || $item->order_status == "Cancel"? 'disabled':'' }}>
                                            <option  value="Pending" {{ $item->order_status == "Pending"? 'selected':''}}> {{ __('Pending') }} </option>
                                            <option  value="Complete" {{ $item->order_status == "Complete"? 'selected':''}}> {{ __('Complete') }} </option>
                                            <option  value="Cancel" {{ $item->order_status == "Cancel"? 'selected':''}}> {{ __('Cancel') }} </option>
                                        </select>
                                    </td>
                                    @if ($item->payment_status == 0)
                                    <td class="d-none">{{ $item->payment_status == 0? 'Pending':'' }}</td>{{-- for print and pdf only --}}
                                    @else
                                    <td class="d-none">{{ $item->payment_status == 1? 'Complete':'' }}</td>{{-- for print and pdf only --}}
                                    @endif

                                    <td>
                                        <select name="payment_status" id="payment-{{ $item->id }}" class="form-control p-2" onchange="changePaymentStatus({{$item->id}})" {{ $item->payment_status == 1? 'disabled':'' }}>
                                            <option value="0" {{ $item->payment_status == 0? 'selected':''}}> {{ __('Pending') }} </option>
                                            <option value="1" {{ $item->payment_status == 1? 'selected':''}}> {{ __('Complete') }} </option>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="{{url('order-invoice/'.$item->id)}}" class="btn-icon text-primary"><i class="far fa-eye"></i></a>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                  <div class="col-lg-12 col-md-12">
                    <div class="w-100 mt-3 num_pagination">
                        {{$orders->appends(request()->input())->links('paginate')}}
                    </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $("#search_btn").on('click',function(){
            var vl = $('#search_txt').val();
            if(vl!=''){
                window.location.href = "{{url('orders')}}?search="+vl;
            }
        })
    </script>
@endpush
