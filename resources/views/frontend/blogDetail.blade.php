@extends('frontend.master', ['activePage' => 'blog'])
@section('title', __('Blog Detail'))
@section('content')

    <section class="section-area blog-details">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12">
                    <div class="blog-details-desc">
                        <div class="article-image">
                            <img src="{{ asset('images/upload/' . $data->image) }}" alt="image" class="img-fluid">
                        </div>
                        <div class="article-content">
                            <ul class="entry-list">
                                <li>{{ Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</li>
                            </ul>
                            <h1>{{ $data->title }}</h1>
                            <div>
                                {!! $data->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
