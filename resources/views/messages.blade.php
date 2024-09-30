

<div class="col-md-12 p-0">
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show glbl-cust-message">
            <ul style="margin:0;padding:0;list-style:none;">
                @foreach ($errors->all() as $input_error)
                    <li>{{$input_error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Session::has('warning'))
        <div class="alert alert-danger alert-dismissible fade show glbl-cust-message">
           <p class="mb-0">{{Session::get("warning")}}</p>
        </div>
    @endif  

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show glbl-cust-message">
            <p class="mb-0">{{Session::get("success")}}</p>
        </div>
    @endif 

</div>