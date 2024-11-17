@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Coach Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Bookings At Center</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>select coaching session to book</p>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" id="coaching" onchange="generatePackageCards(event)">
                                <option value="">Select Coaching Session</option>
                                @foreach ($coachingData as $coach)
                                    <option value="{{ $coach->id }}">{{ $coach->coaching_title  }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-5" id="response_pst">
                        
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        async function fetchCoachData(coachId){
            const data = {
                coachId: coachId,
            };

            try {
                const response = await fetch("{{url('user/get-packages-by-coach-id')}}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{csrf_token()}}"
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
                return result;
            } catch (error) {
                console.error("Error:", error);
            }
        }
    </script>

    <script>
        async function generatePackageCards(event) {
            var coachId = event.target.value;
            let pstDiv = document.getElementById('response_pst');
            pstDiv.innerHTML = '';
            if(coachId == ''){  
                return;
            }
            let packageData = await fetchCoachData(coachId);
            if(packageData.data.length > 0){
                var str = '';
                var fData = packageData.data;
                for(var i in fData){
                    str += `
                        <div class="col-md-4">
                            <div class="card shadow-sm border-primary bg-white">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="my-0">${fData[i].package_name}</h4>
                                </div>
                                <div class="card-body">
                                    <h1 class="card-title pricing-card-title text-dark">
                                        ${fData[i].final_price} <small class="text-muted">/ ${fData[i].package_duration}</small>
                                    </h1>
                                    <ul class="list-unstyled mt-3 mb-4">
                                        <li>
                                        ${fData[i].description}    
                                        </li>
                                    </ul>
                                    <a href="${fData[i].book_link}" class="btn btn-lg btn-primary w-100">Book Now</a>
                                </div>
                            </div>
                        </div>`;
                }
                pstDiv.innerHTML = str;
            }
        }
    </script>

@endpush

@endsection