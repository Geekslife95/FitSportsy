
@extends('eventDashboard.master', ['activePage' => 'category'])
@section('title', __('All categories'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('eventDashboard.common-links')
        @include('messages')
        @isset($checkEvent)
            @php $checkEvent = json_decode($checkEvent->location_info,true); @endphp
        @endisset
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <form action="" method="POST" id="event_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Location Details</h5>
                        </div>
                        <div class="card-body" id="more_temples">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Venue Name <span class="text-danger">*</span></label>
                                        <input type="text" name="venue_name" value="@isset($checkEvent['venue_name']){{$checkEvent['venue_name']}}@endisset" class="form-control"
                                            required="" placeholder="Enter Venue Name" >
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Venue Address <span class="text-danger">*</span></label>
                                        <input type="text" name="temple_name" value="@isset($checkEvent['temple_name']){{$checkEvent['temple_name']}}@endisset" class="form-control"
                                            required="" placeholder="Enter Venue Address" >
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>Venue Area <span class="text-danger">*</span></label>
                                        <input type="text" name="address" placeholder="Venue Area"
                                            class="form-control" value="@isset($checkEvent['address']){{$checkEvent['address']}}@endisset" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group">
                                        <label>City Name <span class="text-danger">*</span></label>
                                        <select name="city_name" id="city_name" class="form-control select2" required>
                                            <option value="">Select City</option>
                                            @foreach(Common::allEventCities() as $city)
                                                <option value="{{$city->city_name}}" @isset($checkEvent['city_name']){{$checkEvent['city_name']==$city->city_name ? 'selected':''}}@endisset>{{$city->city_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" id="continue_btn" class="btn btn-primary d-block">Next Step</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@push('scripts')

@endpush
@endsection