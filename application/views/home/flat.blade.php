@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
  @if ($flat_id != -1)
    <h2>Details for  {{House::find($flat_id)->house_no}}</h2>
  @else
    <h2>Add new flat</h2>
  @endif
{{-- For new object creation . use POST method($flat_id not set to integer), for updation use PUT method --}}
  <?php $method = ($flat_id == -1) ? 'POST' : 'PUT' ?>

  {{ Form::horizontal_open(URL::current(),$method,array('id' => 'flat_edit_form')) }}

	<div class="control-group {{ $errors->has('house_no') ? 'error' : '' }}">
		<label class="control-label" for="house_no">Flat no</label>
		<div class="controls">
			<input class="focused input-xlarge" placeholder="Flat number" type="text" name="house_no" id="house_no" value="{{$house_no}}">
	@foreach ($errors->get('house_no') as $message)
		<p  class="help-block">{{ $message }}</p>
	@endforeach
		</div>
	</div> 	  	

    <div class="control-group {{ $errors->has('floor') ? 'error' : '' }}">
      <label class="control-label" for="floor">Floor</label>
      <div class="controls">
        <select name="floor" id="floor" class="focused input-xlarge">
        @foreach(Config::get('apartment.floors') as $single_floor)
          @if (isset($floor) && $floor == $single_floor)
            <option value="{{$single_floor}}" SELECTED>{{$single_floor}}</option>
          @else
            <option value="{{$single_floor}}">{{$single_floor}}</option>
          @endif
        @endforeach 
      </select>
	@foreach ($errors->get('floor') as $message)
		<p  class="help-block">{{ $message }}</p>
	@endforeach		
      </div>
    </div>    

    @if (Config::get('apartment.blocks'))
        <div class="control-group {{ $errors->has('block') ? 'error' : '' }}">
        <label class="control-label" for="block">Block</label>
        <div class="controls">
          <select name="block" id="block" class="focused input-xlarge">
          @foreach(Config::get('apartment.blocks') as $single_block)
            @if (isset($block) && $block == $single_block)
              <option value="{{$single_block}}" SELECTED>{{$single_block}}</option>
            @else
              <option value="{{$single_block}}">{{$single_block}}</option>
            @endif
          @endforeach 
        </select>
        @foreach ($errors->get('block') as $message)
            <p  class="help-block">{{ $message }}</p>
          @endforeach             
        </div>
      </div>
    @endif
  
    <div class="control-group">
        <label class="control-label" for="notes">Notes</label>
        <div class="controls">
          <textarea rows="3" placeholder="Any additional information" name="notes" id="notes">{{isset($notes) ? $notes : ''}}</textarea>
        </div>
      </div>              
	  
<!-- {{Form::control_group(Form::label('house_no', 'Flat number'),Form::xlarge_text('house_no', null, array('class' => 'focused' , 'value' => "default house",'placeholder' => 'Flat number')),'warning',Form::block_help('Something went wrong'))}} -->
      



  <?php $buttons =  array(Bootstrapper\Buttons::primary_submit('Save'),Form::button('Cancel',array('id' => 'flat_cancel'))); ?>
  @if ($flat_id != -1)
  <?php  array_push($buttons, Form::button('Delete',array('id' => 'flat_delete'))); ?>
  @endif
  {{Form::actions($buttons);}}
  {{Form::close();}}
  

</div><!-- .span8 -->
</div>
@endsection