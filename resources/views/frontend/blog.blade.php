@extends('frontend.master', ['activePage' => 'blog'])
@section('title', __('Our Latest Blog'))
@section('content')
   <section class="section-area blog-details " style="min-height: 60vh;">
    <div class="container">
        <h1 class="h3 mb-3">Our Blogs</h1>
    <div class="row pb-4 mb-2">
        @foreach ($blogs as $bgl)
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="blog-card shadow-sm">
                    <div class="row align-items-center no-gutters">
                        <div class="col-lg-4">
                            <div class="blog-image">
                                <a href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}"><img src="{{asset('images/upload/'.$bgl->image)}}" alt="image" class="img-fluid"></a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="blog-content">
                                <div class="date"><span><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($bgl->created_at)->format('d M Y') }}</span>
                                </div>
                                <h3>
                                    <a href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}">{{ $bgl->title }}</a>
                                </h3>
                                <p>{!! Str::substr(strip_tags($bgl->description), 0, 150).'...' !!}</p>
                                <div class="text-right">
                                    <a href="{{ url('/blog-detail/' . $bgl->id . '/' . Str::slug($bgl->title)) }}" class="blog-btn btn btn-sm btn-outline-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-12 col-md-12">
            <div class="w-100 mt-3 num_pagination">
                {{$blogs->appends(request()->input())->links('paginate')}}
            </div>
        </div>
    </div>
</div>
   </section>
@endsection
