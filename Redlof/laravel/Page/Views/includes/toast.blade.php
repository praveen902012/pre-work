<script>
  @if(\Session::has('notification'))
    var type = "{{ \Session::get('notification.alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ \Session::get('notification.message') }}");
            break;

        case 'warning':
            toastr.warning("{{ \Session::get('notification.message') }}");
            break;
        case 'success':
            toastr.success("{{ \Session::get('notification.message') }}");
            break;
        case 'error':
            toastr.error("{{ \Session::get('notification.message') }}");
            break;
    }
  @endif
</script>
<?php \Session::forget('notification');?>