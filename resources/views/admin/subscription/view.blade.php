@extends('master')
@php
$currency = 'INR';
@endphp
@section('content')
<section class="section">
    @include('admin.layout.breadcrumbs', [
    'title' => __('View Subscription Details'),
    ])
    <div class="section-body">
        <div class="row event-single">
            <div class="col-lg-12">
                <div class="row align-items-center mb-4 mt-2">
                    <div class="col-lg-8"><h2 class="section-title mt-0"> {{__('View Subscription')}}</h2></div>
                    <div class="col-lg-4 text-right">
                        @can('blog_create')
                        <button class="btn btn-primary add-button"><a href="{{url('admin/create-subscription')}}"><i class="fas fa-plus"></i> {{__('Add New')}}</a></button>                
                        @endcan
                    </div>
                </div>    
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="">
                                <thead>
                                    <tr>
                                        <th>{{__('SNo.')}}</th>
                                        <th>{{__('Subscription Name')}}</th>
                                        <th>{{__('Price')}}</th>
                                        <th>{{__('Duration')}}</th>
                                        <th>{{__('Status')}}</th>
                                        <th>{{__('Created At')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscription as $item)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$item->title}}</td>
                                        <td>₹{{$item->price}}</td>
                                        <td>{{$item->duration}} {{$item->type}}</td>
                                        <td><span class="text-white badge bg-{{$item->status == 1 ? "success" : "danger"}}">{{$item->status == 1 ? "Active" : "Inactive"}}</span>   </td>
                                        <td>{{$item->created_at->format('Y-m-d')}}</td>
                                        @php
                                            // Edit
                                            $inputObjB = new \stdClass();
                                            $inputObjB->url = url('admin/edit-subscription');
                                            $inputObjB->params = 'id='.$item->id;
                                            $subLink = Common::encryptLink($inputObjB);

                                            // Change Status
                                            $inputObjB2 = new \stdClass();
                                            $inputObjB2->url = url('admin/update-status-subscription');
                                            $inputObjB2->params = 'id='.$item->id;
                                            $subLink2 = Common::encryptLink($inputObjB2);
                                        @endphp
                                        <td>
                                            <a href="{{$subLink}}" class="btn-icon"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>
                                            <a onclick="return confirm('Are You Sure?')" href="{{$subLink2}}" class="btn-icon text-{{$item->status != 1 ? "success" : "danger"}}"><i class="fas fa-{{$item->status != 1 ? "check-circle" : "ban"}} text-{{$item->status != 1 ? "success" : "danger"}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$item->status != 1 ? "Active" : "Inactive"}}"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection