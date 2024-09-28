@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Edit Coupon'),
            'headerData' => __('Coupon'),
            'url' => 'coupon',
        ])

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <h2 class="section-title"> {{ __('Edit Coupon') }}</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ url('coupon/' . $coupon->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Name') }}</label>
                                            <input type="text" name="name" placeholder="{{ __('Name') }}"
                                                value="{{ $coupon->name }}" class="form-control @error('name')? is-invalid @enderror" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Discount type ') }}</label>
                                            <select name="discount_type" class=" form-control w-100" id="" required>
                                                <option value='0' {{$coupon->discount_type==0 ? 'selected':''}}>Percentage</option>
                                                <option value='1' {{$coupon->discount_type==1 ? 'selected':''}}>Amount</option>
                                            </select>
                                            @error('discount_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Discount/Amount') }}</label>
                                            <input type="number" min="1" name="discount"  step="any" placeholder="{{ __('Discount/Amount') }}" value="{{$coupon->discount}}"
                                                class="form-control @error('discount')? is-invalid @enderror" required >
                                            @error('discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Valid From') }}</label>
                                            <input type="text" name="start_date" placeholder="{{ __('Valid From') }}"
                                                id="start_date" value="{{ $coupon->start_date }}"
                                                class="form-control date @error('start_date')? is-invalid @enderror" required>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>{{ __('Valid Till') }}</label>
                                            <input type="text" name="end_date" placeholder="{{ __('Valid Till') }}"
                                                id="end_date" value="{{ $coupon->end_date }}"
                                                class="form-control date @error('end_date')? is-invalid @enderror" required>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label>{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control @error('description')? is-invalid @enderror"
                                        placeholder="{{ __('Description') }}">{{ $coupon->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>{{ __('status') }}</label>
                                    <select name="status" class="form-control select2">
                                        <option value="1" {{$coupon->status==1 ? 'selected':''}}>{{ __('Active') }}</option>
                                        <option value="0" {{$coupon->status==0 ? 'selected':''}}>{{ __('Inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="btn btn-primary demo-button">{{ __('Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
