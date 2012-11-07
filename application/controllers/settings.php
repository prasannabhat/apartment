<?php

class Settings_Controller extends Controller {
    
    public function action_index()
    {
        $view_params['base_url'] = URL::current();
        return View::make('home.settings',$view_params);
    }

    public function action_change_password()
    {
        return 'change password';
    }

	
}