<html>
<head>
	<title>Apartment management system</title>
</head>
<body>
	<h1>Welcome to apartment management system</h1>
	<div id="content">
		 <!-- check for login errors flash var -->
		@if (Session::has('login_errors'))
		<span class="error">Username or password incorrect.</span>
		@endif
		<form id="" action="login" method="post">
			<label for="email">Email</label>
            <input type="email" placeholder="Your Email Address" name="email" id="email" />
            <br/>
            <label for="password">Password</label>
            <input type="password" placeholder="Your Password" name="password" id="password" />
            <br />
            <button type="submit">Login</button>			
		</form>
		
	</div>

</body>
</html>
