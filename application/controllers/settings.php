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
			$user = User::find($data->user_id)->first();
			$user->password = $data->new;
			$user->save();
            $response->message = 'Password changed successfully';
            return Response::json($response);
        }
        return Response::json($validation);
    }

    private function validate_gateway($gateway,$data)
    {
        $response = new stdClass;
        $response->error = 0;

        $gateway->name = $data->name;
        $gateway->user = $data->user;
        $gateway->code = $data->code;
        // Set the foreign key directly
        $gateway->user_id = Auth::user()->id;

        $valid = $gateway->validate();
        if ($valid->fails())
        {
            $response->error = 1;
            $response->errors = $valid->errors;
        }

        // Proceed only if there are no errors
        // User ID should be validated only when creating new gateway
        if(($response->error == 0) && (isset($data->user_id)))
        {
            foreach (Auth::user()->gateways as $item)
            {
                if($item->name == $gateway->name)
                {
                    $response->error = 1;
                    $messages = new \Laravel\Messages;
                    $messages->add('name','You already have this gateway configured');
                    $response->errors = $messages;
                }
            }            
        }

        return $response;        

    }
    public function action_create_gateway()
    {
        $data = Input::json();

        $gateway = new SmsGateway();

        // This indicates that user ID needs to be validated
        $data->user_id = TRUE;

        $response = $this->validate_gateway($gateway,$data);

        // Proceed only if there are no errors
        if($response->error == 0)
        {
            $gateway->save();
            // return eloquent_to_json($gateway);
            return Response::eloquent($gateway);
        }
        else
        {
            return Response::json($response,406);
        }

    }

    public function action_modify_gateway($id)
    {
        $data = Input::json();
        $gateway = SmsGateway::find($id);

        $response = $this->validate_gateway($gateway,$data);

        // Proceed only if there are no errors
        if($response->error == 0)
        {
            $gateway->save();
            // return eloquent_to_json($gateway);
            return Response::eloquent($gateway);
        }
        else
        {
            return Response::json($response,406);
        }        
    }    

    public function action_gateways()
    {
        return Response::eloquent(Auth::user()->gateways);
    }

    public function action_delete_gateway($id)
    {
        $response = new stdClass;
        SmsGateway::find($id)->delete();
        $response->error = 0;
        $response->id = $id;
        return Response::json($response);
        return $id;

    }

	
}