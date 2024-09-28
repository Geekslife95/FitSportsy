@extends('frontend.qr-master')
@section('title', __('Book Tickets'))
@section('content')
<div class="text-center">
    <h1 class="h4 mb-1">{{ucWords(strtolower($userData->name.' '.$userData->first_name.' '.$userData->last_name))}}</h1>
    <p>{{ucWords(strtolower($userData->address))}}</p>
</div>
<form name="sentMessage" id="sentMessage" method="post" action="{{url('store-orn-code-scan-sel')}}">
    @csrf
    <div class="form-group">
        <label>Category<span class="text-danger">*</span></label>
        <select class="form-control default-select" id="category" name="category" required>
            <option value="">Choose Category</option>
            @foreach ($categoryData as $item)
                <option value="{{$item->id}}">{{ucwords($item->name)}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Event <span class="text-danger">*</span></label>
        <select class="form-control default-select" id="event" name="event" required>
            <option value="">Choose Events</option>
        </select>
    </div>
    <div class="text-right">
        <button type="submit" class="btn w-100 default-btn">Send Message</button>
    </div>
</form>
@endsection

@push('scripts')
    <script>
        var uId = "{{$userId}}";
        $("#category").on('change',function(){
            var catId = $('#category :selected').val();
            if(catId > 0){
                $("#event").html('<option value="">Loading...</option>');
                // cat_id  uId
                $.post('{{url("get-events-by-category")}}',{"_token":$("meta[name=csrf-token]").attr('content'),"uId":uId,"cat_id":catId},function(data){
                    if(data.s==1){
                        if(data.event_data.length > 0){
                            var str = '';
                            for(var i in data.event_data){
                                str+=`<option value="${data.event_data[i].id}">${data.event_data[i].name} (${data.event_data[i].temple_name})</option>`;
                            }
                            $("#event").html(str);
                        }else{
                            $("#event").html('<option value="">No Events</option>');
                        }
                    }
                })
            }else{
                $("#event").html('<option value="">Choose Events</option>');
            }

        });
    </script>
    <script>
        $("#sentMessage").on('submit',function(){
            $("button[type=submit]").attr('disabled','disabled').text('Processing...');
        });
    </script>
@endpush