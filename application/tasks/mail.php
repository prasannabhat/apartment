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

		Config::set('messages::config.transports.smtp.host', 'smtp.gmail.com');
		Config::set('messages::config.transports.smtp.port', 465);
		Config::set('messages::config.transports.smtp.username', 'greenorchard76@gmail.com');
		Config::set('messages::config.transports.smtp.password', 'bangalore76$');
		Config::set('messages::config.transports.smtp.encryption', 'ssl');

		Bundle::start('messages');

		Message::to('prasanna.yoga@gmail.com')
    ->from('prasanna.yoga@gmail.com', 'Prasanna Bhat')
    ->subject('Hello!')
    ->body('Well hello Someone, how is it going?')
    ->send();

		
	}


}