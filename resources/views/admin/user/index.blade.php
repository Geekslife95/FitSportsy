@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Users'),
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
                    @if (session('statusblock'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('statusblock') }}
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
                                    @can('user_create')
                                        <button class="btn btn-primary add-button"><a href="{{ url('users/create') }}"><i
                                                    class="fas fa-plus"></i> {{ __('Add New') }}</a></button>
                                    @endcan
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="event_table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('User') }}</th>
                                            <th>{{ __('First name') }}</th>
                                            <th>{{ __('Last name') }}</th>
                                            <th>{{ __('Phone') }}</th>
                                            <th>{{ __('Role') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            @if (Gate::check('user_edit') || Gate::check('user_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>
                                                    <div class="media">
                                                        <img alt="image" class="mr-3 avatar"
                                                            src="{{ url('images/upload/' . $item->image) }}">
                                                        <div class="media-body">
                                                            <div class="media-title mb-0">
                                                                {{ $item->first_name . ' ' . $item->last_name }}
                                                            </div>
                                                            <div class="media-description text-muted"> {{ $item->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{$item->first_name}}</td>
                                                <td>{{$item->last_name}}</td>

                                                <td>{{ $item->phone }}</td>
                                                <td>
                                                    @forelse ($item->roles as $roles)
                                                        <span class="badge badge-primary  m-1">{{ $roles->name }}</span>
                                                    @empty
                                                        <span class="badge badge-warning  m-1">{{ __('No Data') }}</span>
                                                    @endforelse
                                                </td>
                                                <td>
                                                    <h5><span
                                                            class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-danger' }}  m-1">{{ $item->status == '1' ? 'Active' : 'Block' }}</span>
                                                    </h5>
                                                </td>
                                                @if (Gate::check('user_edit') || Gate::check('user_delete'))
                                                    <td>
                                                        @if (!$item->hasRole('admin'))
                                                            @can('user_edit')
                                                                <a href="{{ route('users.edit', $item->id) }}"
                                                                    class="btn-icon"><i class="fas fa-edit"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Edit"></i></a>
                                                            @endcan
                                                            @if ($item->status == 1)
                                                                <a onclick="return confirm('Blocked person will not be able to Login, They will stay hidden from the public, including their events & bookings.\nAre you sure to block?')"
                                                                    href="{{ url('main_user_block/' . $item->id) }}"
                                                                    class="btn-icon text-danger"><i
                                                                        class="fas fa-ban text-danger" data-toggle="tooltip"
                                                                        data-placement="top" title="Block"></i></a>
                                                            @else
                                                                <a onclick="return confirm('Are you sure to Unblock!!')"
                                                                    href="{{ url('main_user_block/' . $item->id) }}"
                                                                    class="btn-icon text-danger"><i
                                                                        class="fa fa-unlock-alt text-danger"
                                                                        aria-hidden="true" data-toggle="tooltip"
                                                                        data-placement="top" title="Unblock"></i>
                                                                </a>
                                                            @endif
                                                        @endif

                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="w-100 mt-3 num_pagination">
                                    {{$users->appends(request()->input())->links('paginate')}}
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
                window.location.href = "{{url('users')}}?search="+vl;
            }
        })
    </script>
@endpush