@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Event Parent'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Event Parent') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" action="{{ url('events-parent') }}" id="event_form"  name="event_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Event Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="event_name[]"  placeholder="{{ __('Event Name') }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">-</label>
                                        <button class="btn btn-warning d-block" id="add_more_events" type="button">Add More</button>
                                    </div>
                                </div>
                                <div id="more_events">

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group mt-4">
                                            <button type="submit" id="continue_btn"  class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
@push('scripts')
<script>
    $("#add_more_events").on('click',function(){
        $("#more_events").append(`<div class="row remove_events_prnt"><div class="col-lg-6">
                            <div class="form-group">
                                <label>{{ __('Event Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="event_name[]" placeholder="{{ __('Event Name') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">-</label>
                            <button class="btn btn-danger d-block remove_events" type="button">Remove</button>
                        </div><div>`);
    })
</script>

<script>
    $(document).on('click',".remove_events",function(){
        $(this).parents('.remove_events_prnt').remove();
    })
</script>
<script>
    $("#event_form").on('submit',function(){
        $("#continue_btn").attr('disabled','disabled').text('Processing...');
    })
</script>
@endpush
