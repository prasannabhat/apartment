<!DOCTYPE html>
<html lang="en">
<head>
	<title>Apartment management system</title>
    {{ Asset::styles() }}
    {{ Asset::scripts() }}
    {{ Asset::container('bootstrapper')->styles() }}
    {{ Asset::container('bootstrapper')->scripts() }}
</head>
<body>
	 <div class="container">

    <h1>Welcome to apartment management system</h1>
	{{ Form::horizontal_open('login') }}
	@if (Session::has('login_errors'))
	{{Form::control_group(Form::label('email', ''),	Form::xlarge_text('email', null, array('class' => 'focused' , 'placeholder' => 'Email')),'error',Form::block_help('Username or password incorrect'))}}
	@else
	{{Form::control_group(Form::label('email', ''),Form::xlarge_text('email', null, array('class' => 'focused' , 'placeholder' => 'Email')))}}
	@endif
	{{Form::control_group(Form::label('password', ''),Form::xlarge_password('password', array('class' => 'focused', 'placeholder' => 'Password')))}}	
		

	{{Form::actions(array(Bootstrapper\Buttons::primary_submit('Login')));}}
	{{Form::close();}}

    </div> <!-- /container -->
	

</body>
</html>
