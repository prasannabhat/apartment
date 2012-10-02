@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
<table class="table ">
  <caption>Flat list</caption>
  <thead>
    <tr>
      <th>#</th>
      <th>House No</th>
      <th>Block</th>
    </tr>
  </thead>
  <tbody>
  	<?php $count = 0; ?>
  	@foreach (House::all() as $house)
  	<?php $count++ ?>
    <tr>
		<td>{{$count}}</td>
		<td>{{$house->house_no}}</td>
		<td>{{$house->block}}</td>
    </tr>    
	@endforeach
  </tbody>
</table>	
</div><!-- .span12 -->
</div>
@endsection