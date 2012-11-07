<?php

class Settings_Controller extends Controller {
    
    public function action_index()
    {
        $view_params['base_url'] = URL::current();
        return View::make('home.settings',$view_params);
    }

    public function action_change_password()
    {
        $data = Input::json();
        $params['member_id'] = $data->user_id;
        $rules = IoC::resolve('password_validator',array('params' => $params));
        $validation = Validator::make(get_object_vars($data), $rules);
        if ($validation->fails())
        {
            $errors = $validation->errors;
            $errors->error = 1;
            return Response::json($errors);
            // return $validation->errors;
        }
        else
        {
            $response = new stdClass;
            $response->error = 0;
            $response->message = 'Password changed successfully';
            return Response::json($response);
        }
        return Response::json($validation);
    }

	
}