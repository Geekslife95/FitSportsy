@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Add Event Description'),
            'headerData' => __('Event'),
            'url' => 'events',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Add Event Description') }}</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" class="event-form" action="{{ url('eventss-description') }}" id="event_form"  name="event_form" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="title"  placeholder="{{ __('Title') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{ __('Description') }} <span class="text-danger">*</span></label>
                                            <textarea name="description" Placeholder="Description"
                                                class="textarea_editor @error('description')? is-invalid @enderror">
                                                {{ old('description') }}
                                            </textarea>
                                            @error('description')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
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
    $("#event_form").on('submit',function(){
        $("#continue_btn").attr('disabled','disabled').text('Processing...');
    })
</script>
@endpush
