<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('passwordhash');
		$this->passwordhash->setPasswordHash(8, FALSE);
	}


	/**
	 * [register_action description]
	 * @param  [array] $register_type [array('phone' => xxx), array('email'	=> xxx)]
	 * @param  [string] $pwd           [description]
	 * @return [bool]                [description]
	 */
	public function register_action ($name, $register_type, $pwd) 
	{
		if(! ( isset($register_type['email']) || isset($register_type['phone']) ) )
		{
			return NULL;
		}

		$register_type['pwd'] = $this->passwordhash->HashPassword($pwd);
		$register_type['name']= $name;
        $register_type['register_time'] = date("Y-m-d H:i:s", time());

		$this->db->insert('user', $register_type);
        $uid = $this->db->last_insert_id();

		//注册成功
		if($this->db->affected_rows() === 1) {
            //插入 user_online 表
            $this->_insert_user_online($uid);

            return $this->get_user_by_id(uid);
		}
		else {
			return NULL;
		}
	}


	/**
	 * [login_action description]
	 * @param  [array] $login_type [array('phone' => xxx), array('email'	=> xxx)]
	 * @param  [string] $pwd          [description]
	 * @return [type]               [description]
	 */
	public function login_action ($login_type, $pwd)
	{
		$query = $this->db->select('*');

		if ( isset ($login_type['phone']) )
		{
			$query = $query->where('phone', $login_type['phone']);
		}
		else if( isset( $login_type['email'] ) )
		{
			$query = $query->where('email', $login_type['email']);
		}
		//调用错误
		else
		{
			return NULL;
		}

		$data = $query->get('user')->result_array();

		//验证密码
		if( count($data) === 1 )
		{
			$data = $data[0];

			if( $this->passwordhash->CheckPassword($pwd, $data['pwd']) )
			{
				// 删除 pwd 字段
				unset($data['pwd']);

				// 返回用户数据
				return $data;
			}
		}

		return NULL;
	}


    /**
     * 当用户登录的时候，刷新 user_online 表
     * @param $uid
     * @return mixed
     */
    public function get_login_msg_by_id($uid)
    {
        $this->_update_user_online_by_id($uid);
        return $this->get_user_by_id($uid);
    }

	public function check_email ($email)
	{
		return $this->db->where('email', $email)->from('user')->count_all_results() === 0 ? true : false;
	}

	public function check_phone ($phone)
	{
		return $this->db->where('phone', $phone)->from('user')->count_all_results() === 0 ? true : false;
	}

    public function get_user_by_id($uid)
    {
        $query = $this->db->where('id', $uid)->get('user')->result_array();
        return isset($query) ? $query[0] : NULL;
    }


    private function _update_user_online_by_id($uid)
    {
        $data = array(
            'last_active'   => date("Y-m-d H:i:s", time()),
            'ip'            => Common::getIP()
        );
        $this->db->where('uid',$uid)->update('user_online', $data);
    }

    private function _insert_user_online($uid)
    {
        $data = array(
            'uid'           => $uid,
            'last_active'   => date("Y-m-d H:i:s", time()),
            'ip'            => Common::getIP()
        );
        $this->db->insert('user_online', $data);
    }
}