<?php

class Base_Controller extends Controller {

	public function __construct(){
		Asset::add('apartment', 'js/apartment.js');
		Asset::add('style', 'css/apartment.css');

		//Filters
        $class = get_called_class();
        switch($class) {
            case 'Members_Controller':
            	$this->filter('before', 'auth');
                break;
            
            default:
                $this->filter('before', 'auth');
                break;
        }
	}
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
	
}