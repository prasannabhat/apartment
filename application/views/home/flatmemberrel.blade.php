@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
  <h2>Flat relationship for  {{$name}}</h2>

{{-- For new object creation . use POST method($flat_id not set to integer), for updation use PUT method --}}
  <?php $method = 'PUT' ?>

  {{ Form::horizontal_open(URL::current(),$method,array('id' => 'flat_relation_form')) }}

  <input type="hidden" name="action" value="edit">
  <input type="hidden" name="member" value="{{$member_id}}">
  <div class="control-group {{ $errors->has('relation') ? 'error' : '' }}">
    <label class="control-label" for="relation">Flat Relation</label>
    <div class="controls">
      <select name="relation" id="relation">
        @foreach(Apartment\Utilities::get_member_flat_relations() as $key => $value)
          @if ($relation == $value)
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
        <input type="checkbox" name="residing" id="residing" value="1" {{ $residing ? 'checked="checked"' : ''}}> User residing in flat?
      </label>          
    </div>
  </div>   
            
  <?php $buttons =  array(Bootstrapper\Buttons::primary_submit('Save'),Form::button('Cancel',array('id' => 'flat_relation_cancel'))); ?>

  <?php  array_push($buttons, Form::button('Delete',array('id' => 'flat_relation_delete'))); ?>

  {{Form::actions($buttons);}}
  {{Form::close();}}


  

</div><!-- .span8 -->
</div>
@endsection