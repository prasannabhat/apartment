<?php
namespace Sms;

   /*************************************************************
	*		Alfasms API 4.0 for way2sms							*
	*		Author		  : Alfred francis						*
	*		Email         : alfredputhurh@gmail.com				*
	*		API homepage  : www.alfredfrancis.in/alfasms-api	*	
	*		Feel free to edit,share and publish					*
	*************************************************************/


class SixByTwo
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
	$post_data = "username=".$username."&password=".$password."&button=Login";
	$url = "http://www.160by2.com/re-login";
	$ref="http://www.160by2.com/index.html";
	$content=($this->curl->post($url,$post_data,$ref));
	
		
			if(stristr($content,"Unauthorized Login"))
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
	
			$post_data = "hid_exists=no&action1=sa65sdf656fdfd&mobile1=".trim($number)."&msg1=".$msg."&btnsendsms=Send Now";
			
			$url = "http://www.160by2.com/SendSMSAction";
			$ref="http://www.160by2.com/SendSMS.action";
			$content=($this->curl->post($url,$post_data,$ref));
			
				if(stristr($content,"Invalid Mobile number"))
				{
					return false;	
				}
				else
				{
					return true;
				}
		}
		else
		{
			echo "<h2>Please login first before sending SMS</h2>";
		}
	}
	
	public function logout()
	{
		$post_data ="1=1";
		$url = "http://160by2.com/Logout";
		$content=($this->curl->post($url,$post_data));
		
		
			if(stristr($content,"successfully"))
			{
				return true;
			}
			else
			{
				return false;
			}
			
	}
	
}

?>