@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Coach Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')

        @php
             $realPrice = $packageData->package_price;
            $afterDiscountPrice = $packageData->package_price;
            if($packageData->discount_percent > 0 && $packageData->discount_percent <= 100){
                $perc = ($realPrice * $packageData->discount_percent) / 100;
                $afterDiscountPrice = round($realPrice - $perc, 2);
            }
        @endphp

        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">{{$packageData->package_name}}</h4>
                </div>
                <div class="card-body">
                   <form action="{{$book_link}}" method="post">
                    @csrf
                      <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 ">
                            <div class="form-group">
                                <label for="full_name" class="form-label">Name <span class="text-danger">*</span></label>      
                                <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter Name" required>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 ">
                            <div class="form-group">
                                <label for="mobile_number" class="form-label">Mobile No. <span class="text-danger">*</span></label>      
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control" placeholder="Enter Moblie Number" required>
                            </div>
                        </div>
                      </div>  
                      
                      <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 ">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>      
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" required>
                            </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 ">
                            <div class="form-group">
                                <label for="amount" class="form-label">Amount To Pay(₹) <span class="text-danger">*</span></label>      
                                <input type="text" name="amount" id="amount" value="{{round($afterDiscountPrice,2)}}" class="form-control" required readonly>
                            </div>
                        </div>
                      </div>
                     
                      <div class="row">
                        <div class="col-lg-6 col-md-12 col-12 ">
                            <div class="form-group">
                                <label for="transaction_id" class="form-label">Transaction ID </label>      
                                <input type="text" name="transaction_id" id="transaction_id" class="form-control" value="">
                            </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <input type="submit" value="Book Now" class="btn btn-primary">
                        </div>
                      </div>
                   </form>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

@endsection