@layout('layouts/main')

@section('nav-sidebar')
  <div class="sidebar-nav">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header">Options</li>
      <li class="active"><a href="members">View</a></li>
      <li><a href="" id="member_add">Add New Member</a></li>
    </ul>
  </div><!--/.well -->
@endsection

@section('content')
<div class="row-fluid">
<div class="span8">
<table class="table " id="members_table">
  <caption>List of members</caption>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
  	<?php $count = 0; ?>
  	@foreach ($members as $member)
    <?php $count++ ?>
        @render('partials.member',array( 'user' => $member, 'count' => $count))
	@endforeach
  </tbody>
</table>	
</div><!-- .span12 -->
</div>
@endsection