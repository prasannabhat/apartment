@layout('layouts/main')


@section('content')
 <script>
  $(document).ready(function(){
    var Comm = apartment.module("communication");
    Comm.start();
  });
</script> 
<div class="row-fluid">
<div class="span12" id="comm_content">
  
</div><!-- .span8 -->
</div>
@endsection