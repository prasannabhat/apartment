@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
	{{-- For new object creation . use POST method($flat_id not set to integer), for updation use PUT method --}}
	<?php $method = isset($name) ? 'PUT' : 'POST' ?>
	@if ($method == 'PUT')
		<h2>Flat relationship for  {{$name}}</h2>
	@else
		<h2>Add existing member</h2>
	@endif

  {{ Form::horizontal_open(URL::current(),$method,array('id' => 'flat_relation_form')) }}

  <input type="hidden" name="action" value= {{ ($method == 'PUT') ? "edit" : "add"}}>
  <input type="hidden" name="member" value="{{isset($member_id) ? $member_id : '' }}">
  
  @if ($method == 'POST')
    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    <label class="control-label" for="name">Member Name</label>
    <div class="controls">
    <input class="focused input-xlarge member_typeahead" placeholder="Existing Member" type="text" name="name" id="name" 
    	>
  @foreach ($errors->get('name') as $message)
    <p  class="help-block">{{ $message }}</p>
  @endforeach
    </div>
  </div>
  @else
  {{-- If existing member relationship is edited, then make the name a hidden field --}}  
  <input type="hidden" name="name" value="{{$name}}">
  @endif

  
  <div class="control-group {{ $errors->has('relation') ? 'error' : '' }}">
    <label class="control-label" for="relation">Flat Relation</label>
    <div class="controls">
      <select name="relation" id="relation">
        @foreach(Apartment\Utilities::get_member_flat_relations() as $key => $value)
          @if (isset($relation) && $relation == $value)
            <option value="{{$value}}" SELECTED>{{$key}}</option>
          @else
            <option value="{{$value}}">{{$key}}</option>
          @endif
        @endforeach 
      </select>
  @foreach ($errors->get('relation') as $message)
    <p  class="help-block">{{ $message }}</p>
  @endforeach
    </div>
  </div>  

  <div class="control-group">
    <label class="control-label" for="residing">Residing?</label>
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="residing" id="residing" value="1" {{ (isset($residing) && $residing == 1) ? 'checked="checked"' : ''}}> User residing in flat?
      </label>          
    </div>
  </div>   
            
  <?php $buttons =  array(Bootstrapper\Buttons::primary_submit('Save'),Form::button('Cancel',array('id' => 'flat_relation_cancel'))); ?>

  @if ($method == 'PUT')
  <?php  array_push($buttons, Form::button('Delete',array('id' => 'flat_relation_delete'))); ?>
  @endif

  {{Form::actions($buttons);}}
  {{Form::close();}}
</div><!-- .span8 -->
</div>
@if ($method == 'POST')
<script>
var source = {{$members_array}};
$(".member_typeahead").typeahead({source: source});
</script>	
@endif
@endsection