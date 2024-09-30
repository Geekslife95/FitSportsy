@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Events Description'),
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
                                          <input type="text" id="search_txt"  class="form-control">
                                          <div class="input-group-append">
                                            <div class="input-group-text" id="search_btn" style="cursor: pointer;">
                                              <i class="fas fa-search"></i>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9 text-right">
                                    @can('event_create')
                                        <button class="btn btn-primary add-button"><a href="{{ url('eventss-description/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="event_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('Name') }}</th>
                                            @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cnt=1;
                                        @endphp
                                        @foreach ($eventData as $item)
                                            <tr>
                                                <td>{{$cnt}}</td>
                                                <td>
                                                    <h6 class="mb-0">{{ $item->title }}</h6>
                                                </td>

                                                @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                    <td>
                                                        @can('event_edit')
                                                            <a href="{{ route('eventss-description.edit', $item->id) }}" title="Edit Event"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                       
                                                    </td>
                                                @endif
                                                
                                            </tr>
                                            @php
                                                $cnt++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$eventData->appends(request()->input())->links('paginate')}}
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
                window.location.href = "{{url('events-parent')}}?search="+vl;
            }
        })
    </script>
@endpush
