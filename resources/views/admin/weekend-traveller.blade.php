@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Weekend Traveller'),
    ])

    <div class="section-body">
        <div class="row mb-4 mt-2">
            <div class="col-lg-8">
                <h2 class="section-title mt-0">{{ __('Weekend Traveller') }}</h2>
            </div>
            <div class="col-lg-4 text-right">
                <button class="btn btn-primary add-button"><a href="{{url('/create-weekend-traveller')}}"><i
                            class="fas fa-plus"></i> Add
                        New</a></button>
            </div>
        </div>
        <p class="section-lead"></p>
        <div class="row mt-sm-4">
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
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                            aria-controls="home" aria-selected="true">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                            aria-controls="profile" aria-selected="false">Pending</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="report_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{ __('Profile') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                {{-- <th>{{ __('Email') }}</th> --}}
                                                <th>{{ __('Phone') }}</th>
                                                {{-- <th>{{ __('Gender') }}</th> --}}
                                                <th>{{ __('Location') }}</th>
                                                <th>{{ __('Weekend Avability') }}</th>
                                                {{-- <th>{{ __('Travel Interest') }}</th> --}}
                                                <th>{{ __('Budget') }}</th>
                                                {{-- <th>{{ __('Travel Perference') }}</th> --}}
                                                {{-- <th>{{ __('Langugae Spoken') }}</th> --}}
                                                {{-- <th>{{ __('Travel Style') }}</th> --}}
                                                {{-- <th>{{ __('Additional Comments') }}</th> --}}
                                                <th>{{ __('Status') }}</th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($weekends as $weekend)
                                            @if ($weekend->status == 1)
                                            <tr>
                                                <td></td>
                                                <th><img width="40px" height="40px" class="rounded-circle"
                                                        src="/upload/weekend/{{$weekend->profile_photo}}" alt=""> </th>
                                                <th>{{$weekend->name}}</th>
                                                {{-- <th>{{$weekend->email}}</th> --}}
                                                <th>{{$weekend->phone}}</th>
                                                {{-- <th>{{$weekend->gender}}</th> --}}
                                                <th>{{$weekend->location}}</th>
                                                <th>{{$weekend->weekend_avability}}</th>
                                                {{-- <th>{{$weekend->travel_interests}}</th> --}}
                                                <th>{{$weekend->budget}}</th>
                                                {{-- <th>{{$weekend->travel_preference}}</th> --}}
                                                {{-- <th>{{$weekend->lang}}</th> --}}
                                                {{-- <th>{{$weekend->travel_style}}</th> --}}
                                                {{-- <th>{{$weekend->Additional_comment}}</th> --}}
                                                <th><span
                                                        class="badge {{$weekend->status == 1 ? "badge-success": "badge-warning"}}  m-1">{{$weekend->status == 1 ? "Active": "Pending"}}</span>
                                                </th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <td>
                                                    <a href="/update-weekend/{{$weekend->id}}" class="btn-icon"><i
                                                            class="fas fa-edit" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Edit"></i></a>
                                                    {{-- <a onclick="return confirm('Blocked person will not be able to Login, They will stay hidden from the public, including their events &amp; bookings.\nAre you sure to block?')" href="http://localhost:8000/main_user_block/18" class="btn-icon text-danger"><i class="fas fa-ban text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Block"></i></a> --}}
                                                </td>
                                                @endif
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="review_table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>{{ __('Profile') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                {{-- <th>{{ __('Email') }}</th> --}}
                                                <th>{{ __('Phone') }}</th>
                                                {{-- <th>{{ __('Gender') }}</th> --}}
                                                <th>{{ __('Location') }}</th>
                                                <th>{{ __('Weekend Avability') }}</th>
                                                <th>{{ __('Budget') }}</th>
                                                {{-- <th>{{ __('Travel Perference') }}</th> --}}
                                                {{-- <th>{{ __('Langugae Spoken') }}</th> --}}
                                                {{-- <th>{{ __('Travel Style') }}</th> --}}
                                                {{-- <th>{{ __('Additional Comments') }}</th> --}}
                                                <th>{{ __('Status') }}</th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($weekends as $weekend)
                                            @if ($weekend->status == 0)
                                            <tr>
                                                <td></td>
                                                <th><img width="40px" height="40px" class="rounded-circle"
                                                        src="/upload/weekend/{{$weekend->profile_photo}}" alt=""> </th>
                                                <th>{{$weekend->name}}</th>
                                                {{-- <th>{{$weekend->email}}</th> --}}
                                                <th>{{$weekend->phone}}</th>
                                                {{-- <th>{{$weekend->gender}}</th> --}}
                                                <th>{{$weekend->location}}</th>
                                                <th>{{$weekend->weekend_avability}}</th>
                                                {{-- <th>{{$weekend->travel_interests}}</th> --}}
                                                <th>{{$weekend->budget}}</th>
                                                {{-- <th>{{$weekend->travel_preference}}</th> --}}
                                                {{-- <th>{{$weekend->lang}}</th> --}}
                                                {{-- <th>{{$weekend->travel_style}}</th> --}}
                                                {{-- <th>{{$weekend->Additional_comment}}</th> --}}
                                                <th><span
                                                        class="badge {{$weekend->status == 1 ? "badge-success": "badge-warning"}}  m-1">{{$weekend->status == 1 ? "Active": "Pending"}}</span>
                                                </th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <td>
                                                    <a href="/update-weekend/{{$weekend->id}}" class="btn-icon"><i
                                                            class="fas fa-edit" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Edit"></i></a>
                                                    {{-- <a onclick="return confirm('Blocked person will not be able to Login, They will stay hidden from the public, including their events &amp; bookings.\nAre you sure to block?')" href="http://localhost:8000/main_user_block/18" class="btn-icon text-danger"><i class="fas fa-ban text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Block"></i></a> --}}
                                                </td>
                                                @endif
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection