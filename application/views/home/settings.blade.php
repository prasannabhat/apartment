@layout('layouts/main')
@section('header-include')
<!-- hi -->
 {{Asset::container('settings')->scripts()}}
@endsection

@section('nav-sidebar')
  <div class="sidebar-nav">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header">Options</li>
      <li><a href="#password">Change Password</a></li>
    </ul>
  </div><!--/.well -->
@endsection

@section('content')
 <script>
  $(document).ready(function(){
    var Settings = apartment.module("settings");
    var params = {};
    params.base_url = "{{$base_url}}";
    Settings.start(params);
  });
</script> 
<div class="row-fluid">
<div class="span8" id="settings_content">
  
</div><!-- .span8 -->
</div>
@endsection

