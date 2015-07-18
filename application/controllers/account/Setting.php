<?php

class Setting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index($type = '')
	{
		if( ! empty($type) && is_string($type) )
		{
			if(strcmp($type, 'pwd'))
			{
				//进入修改密码界面
			}
			else if(strcmp($type, 'account'))
			{
				//进入个人信息的界面
			}
		}
	}

	public function change_password()
	{
		$old_pwd = $this->sc->input('old_pwd');
		$new_pwd = $this->sc->input('new_pwd');

		$this->user_service->change_password($this->user['id'], $old_pwd, $new_pwd);
	}


	public function update_account()
	{
		$arr = array('name', 'alias', 'sex', 'birthday', 'area', 'email', 'phone');
		$data = $this->sc->input($arr);

		$this->user_service->update_account($this->user['id'], $data);
	}
}