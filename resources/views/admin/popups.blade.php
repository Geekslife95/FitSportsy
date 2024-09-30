@extends('master')

@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('Location Wise Popup'),
    ])

    <div class="section-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="col-lg-8">
                <h2 class="section-title mt-0">{{ __('Location Wise') }}</h2>
            </div>
            <div class="col-lg-4 text-right">
                <button class="btn btn-primary add-button"><a href="/add-popup"><i class="fas fa-plus"></i> Add New</a></button>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @foreach ($popups as $pop) 
                            <div class="col-lg-3 p-2 py-3">
                                <div class="bg-primary text-light text-center rounded py-2 popup_box">
                                    <a class="text-decoration-none" href="{{$pop->img_url}}">
                                        <h5 class="text-white mb-1">{{$pop->city}}</h5>
                                        <img class="img-fluid" src="/upload/popup/{{$pop->image}}" alt="">
                                    </a>
                                    <a href="/delete-popup/{{$pop->id}}" class="text-decoration-none delete_icon" onclick="return confirm('Are you sure you want to delete this?');" >x</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection