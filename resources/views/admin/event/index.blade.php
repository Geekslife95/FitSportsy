@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Events'),
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
                            <div class="row mb-3">
                               

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
                                <div class="col-lg-3">
                                    <select name="city" class="form-control" id="select_city">
                                        <option value="" selected disabled>Select City</option>
                                        @foreach ($citys as $city)
                                            <option value="{{$city->city_name}}">{{$city->city_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 text-right">
                                    @can('event_create')
                                        <button class="btn btn-primary add-button mt-3"><a href="{{ url('event/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                        {{-- <button class="btn btn-primary add-button mt-3"><a href="{{ url('/dashboard') }}"><i
                                            class="fas fa-plus"></i> {{ __('Add New') }}</a></button> --}}
                                    @endcan
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="event_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Image') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Total Tickets') }}</th>
                                            <th>{{ __('Tickets Type') }}</th>
                                            {{-- <th>{{ __('Number of People') }}</th> --}}
                                            <th>{{ __('Category') }}</th>
                                            @if (Auth::user()->hasRole('admin'))
                                                <th>{{ __('Organization') }}</th>
                                            @endif
                                            @if (Auth::user()->hasRole('Organizer'))
                                                <th>{{ __('Scanner') }}</th>
                                            @endif
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                            @if (Gate::check('ticket_access'))
                                                <th>{{ __('Tickets') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($events as $item)
                                            <tr>
                                                <th> <img class="table-img"
                                                        src="{{ url('images/upload/' . $item->image) }}">
                                                </th>
                                                <td>
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    <p class="mb-0">{{ $item->address }} </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0">
                                                        {{$item->ticket_count}}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="mb-0">{{ $item->ticket_type == 1 ? "Advance" : "Basic" }}</p>
                                                </td>
                                                {{-- <td>{{ $item->people }}</td> --}}
                                                <td>{{ $item->category->name }}</td>
                                                @if (Auth::user()->hasRole('admin'))
                                                    <td>{{ $item->user->first_name . ' ' . $item->user->last_name }}
                                                    </td>
                                                @endif
                                                @if (Auth::user()->hasRole('Organizer'))
                                                    <td>{{ $item->scanner == null ? '' : $item->user->first_name . ' ' . $item->user->last_name }}
                                                    </td>
                                                @endif
                                                <td>
                                                    <h5><span
                                                            class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-warning' }}  m-1">{{ $item->status == '1' ? 'Publish' : 'Draft' }}</span>
                                                    </h5>
                                                </td>
                                                @if (Gate::check('event_edit') || Gate::check('event_delete'))
                                                    <td>
                                                        <a href="{{url('event/'.$item->id.'/'.Str::slug($item->name))}}" target="_blank" title="View Event"
                                                            class="btn-icon"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ url('event-gallery/' . $item->id) }}"
                                                            title="Event Gallery" class="btn-icon"><i
                                                                class="far fa-images"></i></a>
                                                        @can('event_edit')
                                                            <a href="{{ route('events.edit', $item->id) }}" title="Edit Event"
                                                                class="btn-icon"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('event_delete')
                                                            <a href="#"
                                                                onclick="deleteData('events','{{ $item->id }}');"
                                                                title="Delete Event" class="btn-icon text-danger"><i
                                                                    class="fas fa-trash-alt text-danger"></i></a>
                                                        @endcan
                                                    </td>
                                                @endif
                                                @if (Gate::check('ticket_access'))
                                                    <td>
                                                        <a href="{{ url($item->id . '/' . Str::slug($item->name) . '/tickets') }}"
                                                            class=" btn btn-primary">{{ ($item->ticket_count > 0) ? "Manage Tickets"  : "Add Tickets"}}</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$events->appends(request()->input())->links('paginate')}}
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
                window.location.href = "{{url('events')}}?search="+vl;
            }
        })
    </script>
     <script>
        $("#select_city").on('change',function(){
            var vl = $('#select_city').val();
            if(vl!=''){
                window.location.href = "{{url('events')}}?city="+vl;
            }
        })
    </script>
@endpush
