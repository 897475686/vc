<?php

class Setting extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->service('user_service');
	}

	public function index($type = "user") {
		$head['css'] = array(
				'common.css',
			);
		$head['javascript'] = array(
				'jquery.js',
				'vchome.js'
			);
		$this->load->view('common/head', $head);

		$user['user'] 	= $this->user;
        $data['sidebar']= $this->load->view('common/sidebar', $user, TRUE);

		if($type == 'pwd')
		{
			//修改密码
		}
		//修改个人信息的页面
		else if($type == 'user')
		{
			$this->load->view('setting', $data);			
		}
	}

	/**
	 * [change_password 修改密码]
	 * @return [type] [description]
	 */
	public function change_password()
	{
		$old_pwd = $this->sc->input('old_pwd');
		$new_pwd = $this->sc->input('new_pwd');

		$result = $this->user_service->change_password($this->user['id'], $old_pwd, $new_pwd);
		if($result)
		{
			echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => ''));		
		}
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}

	/**
	 * [update_account 更新个人资料]
	 * @return [type] [description]
	 */
	public function update_account()
	{
		$arr 	= array('name', 'alias', 'sex', 'area', 'email', 'phone');
		$year 	= $this->sc->input('year');
		$mouth	= $this->sc->input('mouth');
		$day  	= $this->sc->input('day');

		$mouth 	= strlen($mouth) < 2 ? '0'.$mouth : $mouth;
		$day 	= strlen($day) < 2 ? '0'.$day : $day;

		$data = $this->sc->input($arr);

		$data['birthday'] = $year.'-'.$mouth.'-'.$day;

		$result = $this->user_service->update_account($this->user['id'], $data);
		
		if($result)
		{
			echo json_encode(array('success' => 0, 'note' => lang('OPERATE_SUCCESS'), 'script' => ''));	
		}	
		else
		{
			$this->error->output('INVALID_REQUEST');
		}
	}
	
	public function get_msg()
	{
		$uid = $this->user['id'];

		$data = $this->user_service->get_user_by_id($uid);

		echo json_encode($data);
	}
}