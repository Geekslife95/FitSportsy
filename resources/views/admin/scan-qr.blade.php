<!-- Index.html file -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ url('admin/css/custom.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Supershows</title>
</head>

<style>
    /* style.css file*/
    html,body{
        height: 100%;
    }
    #show_user_details{
        height: 100%;
    }
    div.qr-code-box {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px 0px;
        height: 100%;
        box-sizing: border-box;
        text-align: center;
        background: rgb(18 18 18 / 66%);
    }

    div.qr-code-box .scannerLayout {
        width: 100%;
        
    }

    .scannerLayout h4 {
        color: #ffffff;
    }

   

    #my-qr-reader {
        padding: 20px !important;
        border: 1.5px solid #b2b2b2 !important;
        border-radius: 8px;
    }

    #my-qr-reader img[alt="Info icon"] {
        display: none;
    }

    #my-qr-reader img[alt="Camera based scan"] {
        width: 100px !important;
        height: 100px !important;
    }

    button {
        color: white;
        font-size: 15px;
        cursor: pointer;
        margin-top: 15px;
        margin-bottom: 10px;
        background-color: #008000ad;
        transition: 0.3s background-color;
        padding: 5px 18px;
        border-radius: 20px;
        border: none
    }

    button:hover {
        background-color: #008000;
    }

    #html5-qrcode-anchor-scan-type-change {
        text-decoration: none !important;
        color: #ffffff;
        background: black;
        padding: 5px 18px;
        border-radius: 20px;
    }

    video {
        width: 100% !important;
        border: 1px solid #b2b2b2 !important;
        border-radius: 0.25em;
    }
</style>

<body>


  
    <div  id="show_user_details">
        <div class="qr-code-box">
            <div class="container">
                <div class="scannerLayout" >
               
                    <h4 class="text-white">Scan QR Codes</h4>
        
                    <div class="card">
                        <div class="card-body">
                            <div class="scanner_div">
                                <h5 class="mb-3 text-primary">
                                    {{$eventData->name}}
                                    <input type="hidden" id="eventId" value="{{$eventData->id}}">
                                </h5>
                                <div id="my-qr-reader">
                                </div>
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
            
        </div>
    </div>

   
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="{{asset('admin/js/qr-code-reader.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        {{-- <script src="https://unpkg.com/html5-qrcode"></script>  --}}
</body>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    // script.js file 
    function domReady(fn) {
        if (
            document.readyState === "complete" ||
            document.readyState === "interactive"
        ) {
            setTimeout(fn, 1000);
        } else {
            
            document.addEventListener("DOMContentLoaded", fn);
        }

       
    }
    domReady(function() {
        // If found you qr code 
        function onScanSuccess(decodeText, decodeResult) {
            // alert("You Qr is : " + decodeText, decodeResult);
            // console.log(decodeText);
            // console.log(decodeResult);
            $event = $('#eventId').val();

            function showTicketDetails($code) {
                if ($code != "") {
                    $.ajax({
                        url: '{{ url("/scan-order-details")}}',
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                            orderCode: $code,
                            event_id: $event
                        },
                        dataType: 'json',
                        success: function(respond) {
                            $htmlView = "";
                            $devoteeDetails = "";
                            if (respond.status == 1) {
                                $devotee = $.parseJSON(respond.childOrder.devotee_persons);
                                $prasada = $.parseJSON(respond.childOrder.prasada_address);
                                $htmlView = `<section class="py-5 customer-tdetail">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-12">
                                            <div class="card h-auto">
                                                <div class="card-header">
                                                    <h4 class="fs-20">Order Details</h4>
                                                </div>
                                                <div class="card-body p-0">
                                                    <div class="basic-list-group">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Ticket Name</span>
                                                                <span class="text-black">${respond.orderDetails['ticket'].name != null ? respond.orderDetails['ticket'].name : ""}</span>
                                                            </li>

                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Ticket Date</span>
                                                                <input id="orderId" type="hidden" value="${respond.orderDetails.id}">
                                                                <span class="text-black">${respond.orderDetails.ticket_date != null ? respond.orderDetails.ticket_date : ""}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Ticket Slot</span>
                                                                <span class="text-black">${respond.orderDetails.ticket_slot != null ? respond.orderDetails.ticket_slot : ""}</span>
                                                            </li>

                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Payment Amount</span>
                                                                <span class="text-black">₹${respond.orderDetails.payment != null ? respond.orderDetails.payment : ""}/-</span>
                                                            </li>

                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Payment Type</span>
                                                                <span class="text-black">${respond.orderDetails.payment_type != null ? respond.orderDetails.payment_type : ""}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between">
                                                                <span>Payment Status</span>
                                                                <span class="badge badge-${respond.orderDetails.payment_status == 1 ? 'success' : 'danger'} light">${respond.orderDetails.payment_status == 1 ? "Paid" : "Unpaid"}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 col-md-8 col-12">
                                            <div class="card ">
                                                <div class="card-header"> 
                                                    <h4 class="fs-20">Customer Details</h4>
                                                </div>
                                                <div class="card-body">
                                        <ul class="list-group list-group-flush mb-3">
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Customer Name</span>
                                                <span class="text-black">${respond.orderDetails.customer['name'] != null ? respond.orderDetails.customer['name'] : ""} ${respond.orderDetails.customer['last_name'] != null ? respond.orderDetails.customer['last_name'] : ""}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Customer Email </span>
                                                <input id="orderId" type="hidden" value="${respond.orderDetails.id}">
                                                <span class="text-black">${respond.orderDetails.customer['email'] != null ? respond.orderDetails.customer['email']  : ""}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Customer Mobile No</span>
                                                <span class="text-black">${respond.orderDetails.customer['phone'] != null ? respond.orderDetails.customer['phone']  : ""}</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between px-0">
                                                <span>Customer Address</span>
                                                <span class="text-black">${respond.orderDetails.customer['address'] != null ? respond.orderDetails.customer['address']  : ""} ${respond.orderDetails.customer['address_two'] != null ? respond.orderDetails.customer['address_two']  : ""}</span>
                                            </li>
                                        </ul>
                                        <div class="row ">
                                            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                                <h6>Devotee Details:</h6>
                                                <div class="mb-0">Devotee Name : ${$devotee[0].full_name != null ? $devotee[0].full_name  : ""}</div>
                                                <div class="mb-0">Devotee Gotra : ${$devotee[0].gotra != null ? $devotee[0].gotra  : ""}</div>
                                                <div class="mb-0">Devotee Rashi : ${$devotee[0].rashi != null ? $devotee[0].rashi : ""}</div>
                                                <div class="mb-0">Devotee Nakshatra : ${$devotee[0].nakshatra != null ? $devotee[0].nakshatra  : ""}</div>
                                                <div class="mb-0">Devotee Occasion : ${$devotee[0].occasion != null ? $devotee[0].occasion : ""}</div>
                                            </div>
                                            <div class="mb-3 col-lg-6 col-md-6 col-sm-12">
                                                <h6>Prasada Details:</h6>
                                                <div class="mb-0">Prasada Name : ${$prasada['prasada_name'] != null ? $prasada['prasada_name'] : ""}</div>
                                                <div class="mb-0">Prasada Address : ${$prasada['prasada_address'] != null ? $prasada['prasada_address'] : ""}</div>
                                                <div class="mb-0">Prasada City : ${$prasada['prasada_city'] != null ? $prasada['prasada_city']  : ""}</div>
                                                <div class="mb-0">Prasada Mobile : ${$prasada['prasada_mobile'] != null ? $prasada['prasada_mobile'] : ""}</div>
                                                <div class="mb-0">Prasada Email : ${$prasada['prasada_email'] != null ? $prasada['prasada_email'] : ""}</div>
                                            </div>
                                        </div>                       
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-lg-6 col-6">
                                                <a href="/scanner/home" class="btn btn-danger w-100">Cancel</a>
                                            </div>
                                            <div class="col-lg-6 col-6">
                                                <a id="verify_customers" class="btn btn-success text-white w-100">Verify Customer</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>            
                        </div>
                    </div>
                </section>`;
                                $('#show_user_details').html($htmlView);
                            } else if(respond.status == 2){
                                Swal.fire({
                                    title: 'This Qr Already Used',
                                    icon: 'warning',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes',
                                    allowOutsideClick: false
                                })
                            }
                            else{
                                Swal.fire({
                                    title: 'Invalid Qr',
                                    icon: 'error',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Yes',
                                    allowOutsideClick: false
                                })
                            }
                        }
                    });
                }
            }
            // function showTicketDetails(){
            //     console.log(window.location.origin+"/api/leave/customize");
            //     const location = window.location.origin+"/api/leave/customize";
            //     const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //     const data = {
            //         ticketId: decodeText,
            //     };
            //     let options={ 
            //         method: "POST",
            //         body: JSON.stringify(data),
            //         headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            //         'Content-Type': 'application/json'}
            //     }
            //     fetch(location, options).then(res=>console.log(res));
            // }
            showTicketDetails(decodeText);
        }
        let htmlscanner = new Html5QrcodeScanner(
            "my-qr-reader", {
                fps: 10,
                qrbos: 250
            }
        );
        htmlscanner.render(onScanSuccess);

    
    });

    $(document).ready(function(){
        $(document).on('click','#verify_customers',function(){
            Swal.fire({
            title: 'Are you sure',
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            allowOutsideClick: false
            }).then((result) => {
                // if (result.isConfirmed) {
                //     $orderId = $('orderId').val();
                //     $.ajax({
                //         url: '{{ url("/update-scaned-user")}}',
                //         type: 'post',
                //         data: {
                //             _token: '{{csrf_token()}}',
                //             orderCode: $orderId
                //         },
                //         dataType: 'json',
                //         success: function(respond) {
                //             if(respond.status == 1){
                //                 alert('');
                //             }else{
                //                 alert('Something Went Wrong!!');
                //             }
                //         }
                //     });
                // }

                $orderId = $('#orderId').val();
                console.log($orderId);
                if (result.isConfirmed) {
                    window.location.href = "/update-scaned-user?id="+$orderId;
                }

            })
        })
    });
</script>

</html>