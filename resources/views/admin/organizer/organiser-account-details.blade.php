@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', ['title' => __('Bank Details'),])
    <div class="section-body">
   
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/submit-organizer-bank-details" method="post" class="row">
                            @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" name="bank_name" placeholder="Enter Bank Name" class="form-control"
                                        required="" value="@isset($bank_details->bank_name) {{$bank_details->bank_name}}  @endisset">
                                    <input type="hidden" name="user_id" value="@isset($user_id) {{$user_id}}  @endisset">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Account Number <span class="text-danger">*</span></label>
                                    <input type="text" name="account_number" placeholder="Enter Account Number"
                                        class="form-control" value="@isset($bank_details->account_no) {{$bank_details->account_no}} @endisset" required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>IFSC Code <span class="text-danger">*</span></label>
                                    <input type="text" value="@isset($bank_details->ifsc_code) {{$bank_details->ifsc_code}}  @endisset" name="ifsc_code" placeholder="Enter IFSC Code" class="form-control"
                                        required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>UPI ID <span class="text-danger">*</span></label>
                                    <input type="text" value="@isset($bank_details->upi_id) {{$bank_details->upi_id}}  @endisset" name="upi_id" placeholder="Enter UPI ID" class="form-control"
                                        required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-primary w-100" type="submit">
                                    <?php if(isset($bank_details->upi_id)){ echo "Update";  }else{ echo "Submit"; } ?></button>
                            </div>
                        </form>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
   
    
    
@endsection