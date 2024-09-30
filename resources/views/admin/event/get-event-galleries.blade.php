
<div class="row">
    @forelse ($galleryData as $val)
        <div class="col-md-3">
            <img src="{{asset('images/upload/'.$val->image)}}" data-id="{{$val->image}}" class="img-fluid img_gallery" style="cursor: pointer;">
        </div> 
    @empty    
        <div class="col-md-12">
            <h5 class="text-center mt-4">No Gallery Images to show</h5>
        </div> 
    @endforelse
</div>

<div class="row mt-5">
    <div class="col-lg-12 col-md-12">
        <div class="w-100 mt-3 num_pagination">
            {{$galleryData->appends(request()->input())->links('paginate')}}
        </div>
    </div>
</div>