<?php
class MY_Controller extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		//�û�Ȩ�޼��
		$auth_result = $this->auth_service->check_user_auth();
		if( ! $auth_result)
		{
			exit('no_auth');
		}
	}

}