@layout('layouts/main')

@section('header-include')
<!-- hi -->
 {{Asset::container('communication')->scripts()}}
@endsection


@section('content')
 <script>
  $(document).ready(function(){
    var Comm = apartment.module("communication");
    var params = {};
    params.base_url = "{{$base_url}}";
    params.flats_array = {{$flats_array}};
    Comm.start(params);
  });
</script> 
<div class="row-fluid">
<div class="span12" id="comm_content">
  
</div><!-- .span8 -->
</div>
@endsection