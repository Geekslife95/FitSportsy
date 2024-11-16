<div class="row">
    <div class="col-md-12 text-right mb-2">
        <a href="{{$addLink}}" class="btn btn-primary btn-sm">Add Coaching Package</a>
    </div>
    <div class="col-md-12">
        <div class="table-resposive">
            <table class="table table-dark table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Package Name</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Description</th>
                        {{-- <th>End Time</th>
                        <th>Session Days</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @forelse ($coachingData as $package)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $package->package_name }}</td>
                            <td>{{ $package->package_price }}</td>
                            <td>{{ $package->package_duration }}</td>
                            <td>{!! $package->description !!}</td>
                            {{-- <td>{{ date("h:i A",strtotime($package->session_end_time)) }}</td>
                            <td>{{ implode(",",json_decode($package->session_days,true))}}</td> --}}
                            <td>
                                @php
                                    $inputObj = new stdClass();
                                    $inputObj->params = 'coaching_id='.$package->id;
                                    $inputObj->url = url('user/edit-coaching-package');
                                    $editLink = Common::encryptLink($inputObj);

                                    $inputObjR = new stdClass();
                                    $inputObjR->params = 'coaching_id='.$package->id;
                                    $inputObjR->url = url('user/remove-coaching-package');
                                    $removeLink = Common::encryptLink($inputObjR);

                                    $inputObjB = new stdClass();
                                    $inputObjB->params = 'package_id='.$package->id;
                                    $inputObjB->url = url('user/coaching-bookings');
                                    $encLinkB = Common::encryptLink($inputObjB);

                                @endphp
                                <div class="flex">
                                    <a href="{{$editLink}}" class="btn btn-danger btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{$encLinkB}}" class="text-white btn btn-primary btn-sm">Bookings</a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm remove_package" data-link="{{$removeLink}}"><i class="fas fa-trash-alt"></i></a>
                                    
                                </div>
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @empty
                        <tr>
                            <td colspan="6">
                                <h5 class="text-center">NO DATA</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(".remove_package").on('click',function(){
        if(confirm('are you sure ? you want to remove this package')){
            window.location.href = $(this).data('link');
        }
    })
</script>