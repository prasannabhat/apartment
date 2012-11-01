<?php

namespace Sms;

   /*************************************************************
	*		Alfasms API for fullonsms							*
	*		Author		  : Alfred francis						*
	*		Email         : alfredputhurh@gmail.com				*
	*		API homepage  : www.alfredfrancis.in/alfasms-api	*	
	*		Feel free to edit,share and publish					*
	*************************************************************/


class FullOnSms
{
	var $username;
	var $password;
	var $number;
	var $msg;
	var $curl;
	var $login;
	var $post_data;
	var $content;
	var $url;
	var $ref;
	
	public function __construct()
	{
		$this->loginok=false;
		$this->curl=new AlfacURL();
	}

	public function login($username,$password)
	{
	$post_data = "MobileNoLogin=$username&LoginPassword=$password&x=44&y=9&red=";
	$url = "http://sms.fullonsms.com/login.php";
	$ref="http://sms.fullonsms.com/login.php";
	$content=($this->curl->post($url,$post_data,$ref));
	
			if(!stristr($content,"http://sms.fullonsms.com/action_main.php"))
			{
				$this->login=false;
				return false;							
			}
			else
			{
				$this->login=true;
				return true;
			}
	
	}
	
	public function send($number,$msg)
	{
		if($this->login)
		{

			$msg=urlencode($msg);
			$post_data = "ActionScript=%2Fhome.php&CancelScript=%2Fhome.php&HtmlTemplate=%2Fvar%2Fwww%2Fhtml%2Ffullonsms%2FStaticSpamWarning.html&MessageLength=140&MobileNos=$number&Message=$msg&Gender=0&FriendName=Your+Friend+Name&ETemplatesId=&TabValue=contacts";
			$url = "http://sms.fullonsms.com/home.php";
			$ref="http://sms.fullonsms.com/home.php?show=contacts";
			$this->curl->post($url,$post_data,$ref);
			return true;

		}
		else
		{
			echo "<h2>Please login first before sending SMS</h2>";
		}
	}
	
	public function logout()
	{
		$post_data ="1=1";
		$url = "http://sms.fullonsms.com/logout.php?LogOut=1";
		$content=($this->curl->post($url,$post_data));
		return true;


	}
	
}

?>