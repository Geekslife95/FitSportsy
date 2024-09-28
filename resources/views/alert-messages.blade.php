@push('styles')
<link rel="stylesheet" type="text/css" href="{{asset('f-css/iziToast.min.css')}}">
@endpush
@push('scripts')
<script>
    $(document).on('click','.add_to_cart',function(){
        var elem = $(this);
        var url = elem.data('url');
        var elem_html = elem.html();
        elem.html('Processing...').attr('disabled','disabled');
        $.get(url,function(data){
           
            if(data.s==1){
                iziToast.success({
                    title: 'success',
                    message: 'Product add to cart successfully!!!',
                    position:'topRight'
                });
                $(".badge-counter").text(data.total);
            }else{
                iziToast.warning({
                    title: 'warning',
                    message: 'Item out of stock',
                    position:'topRight'
                });
            }
            elem.html(elem_html).removeAttr('disabled');
        })
    });
</script>
<script src="{{asset('f-js/iziToast.min.js')}}"></script>
@if(Session::has('warning'))
    <script>
        iziToast.warning({
            title: 'warning',
            message: '{{Session::get("warning")}}',
            position:'topRight'
        });
    </script>
@endif  

@if(Session::has('success'))
    <script>
        iziToast.success({
            title: 'Success',
            message: '{{Session::get("success")}}',
            position:'topRight'
        });
    </script>
@endif 

@if(Session::has('error'))
<script>
    iziToast.error({
        title: 'error',
        message: '{{Session::get("error")}}',
        position:'topRight'
    });
</script>
@endif 
@endpush