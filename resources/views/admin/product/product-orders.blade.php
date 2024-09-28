@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Products'),
        ])

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body relative">
                            <div id="loader_parent">
                                <span class="loader"></span>
                            </div>
                            <div class="row mb-4 mt-2">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                      
                                        <div class="input-group">
                                          <input type="text" id="search_txt" value=""  class="form-control">
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
                                <table class="table" id="event_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{__('User')}}</th>
                                            <th>{{ __('Payment ID') }}</th>
                                            <th>{{ __('Total Payment') }}</th>
                                            @if (Gate::check('edit_product'))
                                                <th>{{ __('Payment Status') }}</th>
                                                <th>{{ __('Delivery Status') }}</th>
                                            @endif
                                            <th>Pay Type</th>
                                            <th>Date</th>
                                            <th>View</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productData as $item)
                                            @php
                                                $inputObj = new stdClass();
                                                $inputObj->url = url('change-payment-status');
                                                $inputObj->params = 'id='.$item->id;
                                                $encLink = Common::encryptLink($inputObj);

                                                $inputObjD = new stdClass();
                                                $inputObjD->url = url('change-delivery-status');
                                                $inputObjD->params = 'id='.$item->id;
                                                $encLinkD = Common::encryptLink($inputObjD);

                                                $inputObjO = new stdClass();
                                                $inputObjO->url = url('view-order-details');
                                                $inputObjO->params = 'id='.$item->id;
                                                $encLinkO = Common::encryptLink($inputObjO);
                                            @endphp
                                            <tr>
                                                <th>{{$item->order_u_id}}</th>
                                                <td>{{ $item->user->name.' '.$item->user->last_name }}</td>
                                                <td>{{ $item->payment_id }} </td>
                                                <td> {{ "₹".($item->total_paid + 0) }} </td>
                                                @if (Gate::check('edit_product'))
                                                    <td>
                                                        <select class="form-control payment_status" data-id="{{$encLink}}">
                                                            <option value="Paid" {{$item->payment_status=='Paid' ? 'selected':''}}>Paid</option>
                                                            <option value="Pending" {{$item->payment_status=='Pending' ? 'selected':''}}>UnPaid</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control delivery_status" data-id="{{$encLinkD}}">
                                                            <option value="Pending" {{$item->status=='Pending' ? 'selected':''}}>Pending</option>
                                                            <option value="Shipped" {{$item->status=='Shipped' ? 'selected':''}}>Shipped</option>
                                                            <option value="Delivered" {{$item->status=='Delivered' ? 'selected':''}}>Delivered</option>
                                                        </select>
                                                    </td>
                                                    
                                                @endif

                                               <td>{{$item->pay_type}}</td>
                                               <td>{{date("d M Y h:i A",strtotime($item->created_at))}}</td>
                                               <td><a class="btn btn-sm btn-primary" href="{{$encLinkO}}"><i class="fas fa-eye"></i> view</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$productData->appends(request()->input())->links('paginate')}}
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
                window.location.href = "{{url('user-product-orders')}}?search="+vl;
            }
        })
    </script>
    <script>
        $(".payment_status").on('change',function(){
            $("#loader_parent").css('display','flex');
            var pay_status = $('.payment_status option:selected').val();
            var link = $(this).data('id');
            $.post(link,{"_token":"{{csrf_token()}}","status":pay_status},function(data){
                $("#loader_parent").hide();
            })
        })
    </script>
    <script>
        $(".delivery_status").on('change',function(){
            $("#loader_parent").css('display','flex');
            var pay_status = $('.delivery_status option:selected').val();
            var link = $(this).data('id');
            $.post(link,{"_token":"{{csrf_token()}}","status":pay_status},function(data){
                $("#loader_parent").hide();
            })
        })
    </script>
@endpush
