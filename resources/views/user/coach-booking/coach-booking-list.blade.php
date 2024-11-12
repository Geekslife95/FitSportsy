@extends('eventDashboard.master', ['activePage' => 'events'])
@section('title', __('Coach Booking'))
@section('content')
<section class="page-wrapper">
    <div class="content container-fluid">
        @include('messages')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Coach Listing</h4>
                    <a href="{{url('user/coach-book')}}" class="btn btn-primary">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark">
                            <thead>
                                <tr class="">
                                    <th>Coaching Title</th>
                                    <th>Venue Name</th>
                                    <th>Image</th>
                                    <th>Area</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($coachData as $coach)
                                    <tr>
                                        <td>{{$coach->coaching_title}}</td>
                                        <td>{{$coach->venue_name}}</td>
                                        <td><img style="object-fit: cover;height:40px;width:40px;" src="{{asset('uploads/'.$coach->poster_image)}}" alt=""></td>
                                        <td>{{$coach->venue_area}}</td>
                                        <td>{{$coach->venue_city}}</td>
                                        <td>
                                            <div class="d-flex">
                                                @php
                                                    $inputObj = new stdClass();
                                                    $inputObj->params = 'coaching_id='.$coach->id;
                                                    $inputObj->url = url('user/coaching-packages-list');
                                                    $encLink = Common::encryptLink($inputObj);

                                                    $inputObjE = new stdClass();
                                                    $inputObjE->params = 'coaching_id='.$coach->id;
                                                    $inputObjE->url = url('user/edit-coach-book');
                                                    $encLinkE = Common::encryptLink($inputObjE);

                                                    $inputObjD = new stdClass();
                                                    $inputObjD->params = 'coaching_id='.$coach->id;
                                                    $inputObjD->url = url('user/remove-coach-book');
                                                    $encLinkD = Common::encryptLink($inputObjD);

                                                @endphp
                                                <a href="javascript:Void(0);" class="btn text-white btn-primary package_link" data-link="{{$encLink}}">Packages</a>
                                                <a href="{{ $encLinkE }}" class="btn btn-warning text-white ml-1"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:Void(0);" class="btn btn-danger remove_coach_list text-white ml-1" data-link="{{$encLinkD}}"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6"><h5 class="text-center text-danger">NO DATA</h5></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{$coachData->links('paginate')}}
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="packageModalLabel">Packages</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal_body">
                    <h6 class="text-center mt-4">Loading Data...</h6>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

</section>
@endsection
@push('scripts')
    <script>
        $(".package_link").on('click',function(){
            let link = $(this).data('link');
            $("#packageModal").modal('show');
            $("#modal_body").html('<h6 class="text-center mt-4">Loading Data...</h6>');
            $.get(link,function(data){
                $("#modal_body").html(data);
            });
        });
    </script>
    <script>
        $(document).on('click', ".remove_coach_list", function(){
            let link = $(this).data('link');
            if(confirm('Are you sure? you want to delete this')){
                window.location.href = link;
            }
        })
    </script>
@endpush