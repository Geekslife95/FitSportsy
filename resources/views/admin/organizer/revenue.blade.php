@extends('master')
@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
        'title' => __('Revenue Report'),
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
                  <div class="row">
                      <div class="col-lg-8 p-3 ml-3"><h2 class="section-title"> {{__('Revenue Report')}}</h2></div>
                  </div>
                  <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="revenue_table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>{{__('Order Id')}}</th>
                                <th>{{__('Customer')}}</th>
                                <th>{{__('Event Name')}}</th>
                                <th>{{__('Quantity')}}</th>
                                <th>{{__('Payment Gateway')}}</th>
                                <th>{{__('GST')}}</th>
                                <th>{{__('Total Payment')}}</th>
                                <th>{{__('Organizer Commission')}}</th>
                                <th>{{__('Admin Revenue')}}</th>
                                <th>{{__('Convenience Fee')}}</th>
                                <th>{{__('Discount Amount')}}</th>
                                <th>{{__('Created at')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            @php
                                $currency = "₹";
                            @endphp
                                <?php $org =$item->org_commission+$item->tax;  ?>
                                <tr>
                                    <td></td>
                                    <td>{{$item->order_id}}</td>
                                    <td>
                                        @isset($item->customer->name)
                                            <h6>{{$item->customer->name.' '.$item->customer->last_name}}</h6>
                                            <p>{{$item->customer->email}}</p>
                                        @endisset
                                    </td>
                                    <td>{{$item->event->name}}</td>
                                    <td>{{$item->quantity.' tickets'}}</td>
                                    <td>{{$item->payment_type}}</td>
                                    <td>{{$currency.$item->tax}}</td>
                                    <td>{{$currency.$item->payment}}</td>
                                    <td>{{$currency.$org}}</td>
                                    <td>{{$currency.($item->payment - $org)}}</td>
                                    <td>{{$currency.$item->convenience_amount}}</td>
                                    <td>{{$currency.$item->discount_amount}}</td>
                                    <td>{{$item->created_at->format('Y-m-d')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
@endsection
