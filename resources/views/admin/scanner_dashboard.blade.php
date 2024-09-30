@extends('master')
@section('content')
@include('messages')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Scanner Events') }} </h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="">
                            <thead>
                                <tr>
                                    <th>{{__('Event Name')}}</th>
                                    <th>{{__('Event Address')}}</th>
                                    <th>{{__('Temple Name')}}</th>
                                    <th>{{__('City Name')}}</th>
                                    <th>{{__('Scan Now')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($scannerEvent as $item)
                                    @php
                                        $inputObj = new \stdClass();
                                        $inputObj->params = 'id='.$item->id;
                                        $inputObj->url = url('/scanner/scan');
                                        $urlEncrypt = Common::encryptLink($inputObj);
                                    @endphp
                                    <tr>
                                        <td><img width="50px" src="{{url('/')}}/images/upload/{{$item->image}}" alt=""> {{$item->name}}</td>
                                        <td>{{$item->address}}</td>
                                        <td>{{$item->temple_name}}</td>
                                        <th>{{$item->city_name}}</th>
                                        <th><a href="{{$urlEncrypt}}" class="btn btn-success"><i class="fa-solid fa-qrcode"></i> Scan Now</a></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
