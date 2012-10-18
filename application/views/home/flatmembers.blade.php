@layout('layouts/main')

@section('nav-sidebar')
  <div class="sidebar-nav">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header">Options</li>
      <li><a href="" id="flat_add_member">Add New Member</a></li>
	  <li><a href="" id="flat_add_existing_member">Add Existing Member</a></li>
    </ul>
  </div><!--/.well -->
@endsection

@section('content')
<div class="row-fluid">
<div class="span8">
  <h2>Member list for {{$house_no}}</h2>
<table class="table " id="flat_members_table">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Phone</th>
      <th>Email</th>
      <th>Flat Relation</th>
      <th>Residing</th>
	  <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php $count = 0; ?>
    @foreach (House::find($id)->users()->get() as $user)
    <?php $count++ ?>
	@render('partials.flat-member',array( 'user' => $user, 'count' => $count))
    @endforeach
  </tbody>
</table>	
</div><!-- .span12 -->
</div>
@endsection