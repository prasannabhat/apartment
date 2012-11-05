<?php

class Mail_Task {


	private static function get_params($args)
	{
		// Form the parameter array key value pairs
		$params = array();
		foreach ($args as $key => $value) {
			$result = preg_split('/=/',$value);
			if(count($result)  == 2)
			{
				$params[$result[0]] = $result[1];
			}
		}
		return $params;		
	}
	
	public function run(){
		// command line arguments
		$args  = func_get_arg(0);
		$params = self::get_params($args);
		

		// If you do not want to auto-load the bundle, you can use this
		Bundle::start('swiftmailer');

		// Get the Swift Mailer instance
		$mailer = IoC::resolve('mailer');

		// Construct the message
		$message = Swift_Message::newInstance('Message From Website')
		    ->setFrom(array('prasanna.yoga@gmail.com'=>'Prasanna Bhat'))
		    ->setTo(array('prasanna.yoga@gmail.com'=>'Prasanna Bhat'))
		    ->addPart('My Plain Text Message','text/plain')
		    ->setBody('My HTML Message','text/html');

		// Send the email
		$result = $mailer->send($message);
		print "$result\n";
		
		print "Run with some methods please!!";
	}


}