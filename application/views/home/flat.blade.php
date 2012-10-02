@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
  <?php $house = ($flat_id != -1) ? House::find($flat_id) : false; ?>
  
  @if ($house)
    <h2>Details for  {{$house->house_no}}</h2>
  @else
    <h2>Add new flat</h2>
  @endif
{{-- For new object creation . use POST method, for updation use PUT method --}}
  <?php $method = ($house) ? 'PUT' : 'POST' ?>

  {{ Form::horizontal_open(URL::current(),$method,array('id' => 'flat_edit_form')) }}

    <div class="control-group">
      <label class="control-label" for="house_no">Flat no</label>
      <div class="controls"><input class="focused input-xlarge" placeholder="Flat number" type="text" name="house_no" id="house_no" value="{{($house) ? $house->house_no : ''}}">
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="floor">Floor</label>
      <div class="controls">
        <input class="focused input-xlarge" placeholder="Floor" type="text" name="floor" id="floor" value="{{($house) ? $house->floor : ''}}">
      </div>
    </div>    

    <div class="control-group">
        <label class="control-label" for="block">Block</label>
        <div class="controls">
          <input class="focused input-xlarge" placeholder="Block(if applicable)" type="text" name="block" id="block" value="{{($house) ? $house->block : ''}}">
        </div>
      </div>        
<!--    {{Form::control_group(Form::label('house_no', 'Flat number'),Form::xlarge_text('house_no', null, array('class' => 'focused' , 'value' => "default house",'placeholder' => 'Flat number')))}}  -->



  <?php $buttons =  array(Bootstrapper\Buttons::primary_submit('Save'),Form::button('Cancel',array('id' => 'flat_cancel'))); ?>
  @if ($house)
  <?php  array_push($buttons, Form::button('Delete',array('id' => 'flat_delete'))); ?>
  @endif
  {{Form::actions($buttons);}}
  {{Form::close();}}

</div><!-- .span8 -->
</div>
@endsection