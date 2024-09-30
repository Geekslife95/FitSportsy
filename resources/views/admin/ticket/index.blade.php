@extends('master')

@section('content')
    <section class="section">
        @include('admin.layout.breadcrumbs', [
            'title' => __('Manage Tickets'),
            'headerData' => __('Event'),
            'url' => 'events/' . $event->id,
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
                        <div class="card-header d-block">
                            <h4>Temple - {{$event->temple_name}}</h4>
                            <h4>Event Type - {{$event->event_type}}</h4>
                            @if($event->event_type=='Particular')
                                <h4>Start Date - {{date("d M Y H:i A",strtotime($event->start_time))}}</h4>
                                <h4>End Date - {{date("d M Y H:i A",strtotime($event->end_time))}}</h4>
                            @else
                                <h4>Days - {{$event->recurring_days}}</h4>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="section-title mt-0"> {{ __('View Tickets') }}</h2>
                                @can('ticket_create')
                                    @if($event->ticket_type == 1)
                                        @if (count($ticket) < 3)
                                        <button class="btn btn-primary add-button"><a
                                            href="{{ url($event->id . '/ticket/create') }}"><i class="fas fa-plus"></i>
                                            {{ __('Add New') }}</a></button>
                                        @endif
                                    @else
                                        <button class="btn btn-primary add-button"><a
                                            href="{{ url($event->id . '/ticket/create') }}"><i class="fas fa-plus"></i>
                                            {{ __('Add New') }}</a></button>
                                    @endif
                                @endcan
                            </div>
                           
                            <div class="table-responsive">
                                <table class="table" id="report_table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>{{ __('Ticket Number') }}</th>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Quantity') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            @if($event->event_type=="Particular")
                                                <th>{{ __('Sales Start') }}</th>
                                                <th>{{ __('Sales End') }}</th>
                                            @endif
                                            <th>{{ __('Status') }}</th>
                                            {{-- <th>{{ __('Maximum Check-ins') }}</th> --}}
                                            @if (Gate::check('ticket_edit') || Gate::check('ticket_delete'))
                                                <th>{{ __('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ticket as $item)
                                            <tr>
                                                <td></td>
                                                <th> {{ $item->ticket_number }}</th>
                                                <th> {{ $item->name }}</th>
                                                <td> {{ $item->quantity }}</td>
                                                <td> {{ $item->type == 'paid' ? Common::siteGeneralSettings()->currency . $item->price : 'FREE' }}</td>
                                                @if($event->event_type=="Particular")
                                                <td>{{ date("d M Y H:i A, l",strtotime($item->start_time)) }}</td>
                                                <td>{{ date("d M Y H:i A, l",strtotime($item->end_time)) }}</td>
                                                @endif
                                                <td>
                                                    <h5>
                                                        <span
                                                            class="badge {{ $item->status == '1' ? 'badge-success' : 'badge-warning' }}  m-1">{{ $item->status == '1' ? 'Active' : 'Inactive' }}</span>
                                                    </h5>
                                                </td>
                                                @if (Gate::check('ticket_edit') || Gate::check('ticket_delete'))
                                                    <td>
                                                        @can('ticket_edit')
                                                            <a href="{{ url('ticket/edit/' . $item->id) }}" class="btn-icon"><i
                                                                    class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('ticket_delete')
                                                            <a href="#"
                                                                onclick="deleteData('deleteTickets','{{ $item->id }}');"
                                                                class="btn-icon"><i
                                                                    class="fas fa-trash-alt text-danger"></i></a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
