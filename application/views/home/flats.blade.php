@layout('layouts/main')

@section('nav-sidebar')
  <div class="sidebar-nav">
    <ul class="nav nav-pills nav-stacked">
      <li class="nav-header">Options</li>
      <li class="active"><a href="flats">View</a></li>
      <li><a href="" id="flat_add">Add Flat</a></li>
    </ul>
  </div><!--/.well -->
@endsection

@section('content')
<div class="row-fluid">
<div class="span8">
<table class="table " id="flats_table">
  <caption>Flat list</caption>
  <thead>
    <tr>
      <th>#</th>
      <th>House No</th>
      <th>Floor</th>
      <th>Block</th>
    </tr>
  </thead>
  <tbody>
  	<?php $count = 0; ?>
  	@foreach (House::all() as $house)
  	<?php $count++ ?>
    <tr class="flat_entry" id="{{$house->id}}">
		<td>{{$count}}</td>
		<td>{{$house->house_no}}</td>
    <td>{{$house->floor}}</td>
		<td>{{$house->block}}</td>
    </tr>    
	@endforeach
  </tbody>
</table>	
</div><!-- .span12 -->
</div>
@endsection