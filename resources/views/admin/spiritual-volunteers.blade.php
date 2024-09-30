@extends('master')
@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Spiritual Volunteers'),
    ])

    <div class="section-body">
        <div class="d-flex justify-content-between mb-3">
        
                <h2 class="section-title mt-0">{{ __('Spiritual Volunteers') }}</h2>
            <div>
                <button class="btn btn-primary add-button"><a href="{{url('/create-volunteer')}}"><i
                    class="fas fa-plus"></i> Add New</a></button>
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
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Location') }}</th>
                                                <th>{{ __('Areas Of Interest') }}</th>
                                                <th>{{ __('Experience') }}</th>
                                                <th>{{ __('Reference') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($buddys as $buddy)
                                            @if ($buddy->status == 1)
                                            <tr>
                                                <td></td>
                                                <th><img width="40px" height="40px" class="rounded-circle"
                                                        src="/upload/buddy/{{$buddy->profile_photo}}" alt=""> </th>
                                                <th>{{$buddy->name}}</th>
                                                <th>{{$buddy->phone}}</th>
                                                <th>{{$buddy->email}}</th>
                                                <th>{{$buddy->location}}</th>
                                                <th>{{$buddy->areas_of_interest}}</th>
                                                <th>{{$buddy->experience}}</th>
                                                <th>{{$buddy->refer}}</th>
                                                <th><span
                                                        class="badge {{$buddy->status == 1 ? "badge-success": "badge-warning"}}  m-1">{{$buddy->status == 1 ? "Active": "Pending"}}</span>
                                                </th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <td>
                                                    <a href="/update-volunteer/{{$buddy->id}}" class="btn-icon"><i
                                                            class="fas fa-edit" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Edit"></i></a>
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
                                                <th>{{ __('Phone') }}</th>
                                                <th>{{ __('Email') }}</th>
                                                <th>{{ __('Location') }}</th>
                                                <th>{{ __('Areas Of Interest') }}</th>
                                                <th>{{ __('Experience') }}</th>
                                                <th>{{ __('Reference') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Action') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($buddys as $buddy)
                                            @if ($buddy->status == 0)
                                            <tr>
                                                <td></td>
                                                <th><img width="40px" height="40px" class="rounded-circle"
                                                        src="/upload/buddy/{{$buddy->profile_photo}}" alt=""> </th>
                                                <th>{{$buddy->name}}</th>
                                                <th>{{$buddy->phone}}</th>
                                                <th>{{$buddy->email}}</th>
                                                <th>{{$buddy->location}}</th>
                                                <th>{{$buddy->areas_of_interest}}</th>
                                                <th>{{$buddy->experience}}</th>
                                                <th>{{$buddy->refer}}</th>
                                                <th><span
                                                        class="badge {{$buddy->status == 1 ? "badge-success": "badge-warning"}}  m-1">{{$buddy->status == 1 ? "Active": "Pending"}}</span>
                                                </th>
                                                @if (Auth::user()->hasRole('admin'))
                                                <td>
                                                    <a href="/update-volunteer/{{$buddy->id}}" class="btn-icon"><i
                                                            class="fas fa-edit" data-toggle="tooltip"
                                                            data-placement="top" title=""
                                                            data-original-title="Edit"></i></a>
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