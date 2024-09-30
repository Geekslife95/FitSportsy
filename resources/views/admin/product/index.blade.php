@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Products'),
        ])

        <div class="section-body">

            <div class="row">
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
                            <div class="row mb-4 mt-2">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                      
                                        <div class="input-group">
                                          <input type="text" id="search_txt" value="{{$search}}"  class="form-control">
                                          <div class="input-group-append">
                                            <div class="input-group-text" id="search_btn" style="cursor: pointer;">
                                              <i class="fas fa-search"></i>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-9 text-right">
                                    @can('add_product')
                                        <button class="btn btn-primary add-button"><a href="{{ url('products/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="event_table">
                                    <thead>
                                        <tr>
                                         
                                            <th>{{ __('Image') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Rating') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('edit_product'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productData as $item)
                                            <tr>
                                             
                                                <th> <img class="table-img" src="{{ url('images/upload/' . $item->image) }}">
                                                </th>
                                                <td>{{ $item->product_name }}</td>
                                                <td>₹{{ $item->product_price + 0 }} </td>
                                                <td> {{ $item->rating }} </td>
                                                <td>{{ $item->quantity }} </td>
                                                <td>
                                                    <h5><span class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-warning' }}  m-1">{{ $item->status == '1' ? 'Active' : 'Inactive' }}</span>
                                                    </h5>
                                                </td>
                                                @if (Gate::check('edit_product'))
                                                    <td>
                                                        @can('edit_product')
                                                            <a href="{{ route('products.edit', $item->id) }}"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$productData->appends(request()->input())->links('paginate')}}
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $("#search_btn").on('click',function(){
            var vl = $('#search_txt').val();
            if(vl!=''){
                window.location.href = "{{url('products')}}?search="+vl;
            }
        })
    </script>
@endpush
