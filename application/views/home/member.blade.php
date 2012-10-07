@layout('layouts/main')

@section('content')
<div class="row-fluid">
<div class="span8">
  @if ($member_id != -1)
    <h2>Details for  {{User::find($member_id)->name}}</h2>
  @else
    <h2>Add new member {{ $house_no ? "for " . $house_no : ""}}</h2>
  @endif
{{-- For new object creation . use POST method($flat_id not set to integer), for updation use PUT method --}}
  <?php $method = ($member_id == -1) ? 'POST' : 'PUT' ?>

  {{ Form::horizontal_open(URL::current(),$method,array('id' => 'member_edit_form')) }}

  <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
    <label class="control-label" for="name">Name</label>
    <div class="controls">
      <input class="focused input-xlarge" placeholder="Name" type="text" name="name" id="name" value="{{$name}}">
  @foreach ($errors->get('name') as $message)
    <p  class="help-block">{{ $message }}</p>
  @endforeach
    </div>
  </div>      

  <div class="control-group {{ $errors->has('phone_no') ? 'error' : '' }}">
    <label class="control-label" for="phone_no">Phone No</label>
    <div class="controls">
      <input class="focused input-xlarge" placeholder="Phone No" type="text" name="phone_no" id="phone_no" value="{{$phone_no}}">
  @foreach ($errors->get('phone_no') as $message)
    <p  class="help-block">{{ $message }}</p>
  @endforeach
    </div>
  </div>  

  <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
    <label class="control-label" for="email">Email</label>
    <div class="controls">
      <input class="focused input-xlarge" placeholder="Email" type="text" name="email" id="email" value="{{$email}}">
  @foreach ($errors->get('email') as $message)
    <p  class="help-block">{{ $message }}</p>
  @endforeach
    </div>
  </div>  

  <div class="control-group {{ $errors->has('relation') ? 'error' : '' }}">
    <label class="control-label" for="relation">Flat Relation</label>
    <div class="controls">
      <select name="relation" id="relation">
        @foreach(Apartment\Utilities::get_member_flat_relations() as $key => $value)
        <option value="{{$value}}">{{$key}}</option>
        @endforeach 
        <!-- <option value="1" SELECTED>1</option> -->
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
        <input type="checkbox" name="residing" id="residing" value="1"> User residing in flat?
      </label>          
    </div>
  </div>   
            
  <?php $buttons =  array(Bootstrapper\Buttons::primary_submit('Save'),Form::button('Cancel',array('id' => 'member_cancel'))); ?>
  @if ($member_id != -1)
  <?php  array_push($buttons, Form::button('Delete',array('id' => 'member_delete'))); ?>
  @endif
  {{Form::actions($buttons);}}
  {{Form::close();}}


  

</div><!-- .span8 -->
</div>
@endsection