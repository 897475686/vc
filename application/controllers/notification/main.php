<?php 

class Main extends MY_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->service('notification_service');
	}

	/**
	 * [index 显示消息列表]
	 * @return [type] [description]
	 */
	public function index($type = 'all')
	{
		if( !is_string($type) ) {
			show_404();
		}

		$data = array();

		if(strcmp($type, 'all') == 0) 
		{
			$data['css'] = array(
				'common.css',
				'message.css',
				'message_center.css'
			);

			$data['javascript'] = array(
				'jquery.js'
			);

			$this->load->view('common/head', $data);
			$this->load->view('notification_list');
		}
		elseif(strcmp($type, 'conversation'))
		{
			$data['css'] = array(
				'common.css',
				'message.css',
				'message_center.css'
			);

			$data['javascript'] = array(
				'jquery.js'
			);

			$this->load->view('common/head', $data);
			$this->load->view('conversation_list');			
		}
	}

	/**
	 * [get_notification_list 获取消息列表]
	 * @return [type] [description]
	 */
	public function get_notification_list()
	{
		$page = $this->sc->input('page');
		//消息类型
		$type = $this->sc->input('type');
		$type = ! empty($type) ? $type : 'all';

		$notification = $this->notification_service->get_notification_list($page,$this->user['id'],$type);

		echo json_encode($notification);
	}

	/**
	 * [read 阅读消息]
	 * @return [type] [description]
	 */
	public function read()
	{
		$nid = $this->sc->input('nid');
		$result = $this->notification_service->update($this->user['id'],$nid,array('read_flag' => 1));
		if(!empty($result))
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}

	/**
	 * [delete 删除消息]
	 * @return [type] [description]
	 */
	public function delete()
	{
		$nid = $this->sc->input('nid');
		$result = $this->notification_service->delete($this->user['id'],$nid);
		if(!empty($result))
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
	}

	public function test_conversation()
	{
		$sender_id = '2';  //$this->user['id']
		$reciver_id= '4';
		$conversation_id = 1;
		$content = array('conversation_content' => '第一条私信','conversation_id' => $conversation_id);
		$this->notification_service->insert($sender_id,$reciver_id,1,$content);
	}

	public function test_comment()
	{
		$sender_id = '2';  //$this->user['id']
		$reciver_id= '4';
		$content   = array('content_id' => '内容id', 'content_type' => 'article','comment_content' => '第一条评论');
		$this->notification_service->insert($sender_id,$reciver_id,2,$content);					
	}
	
	public function test_like()
	{
		$sender_id = '2';  //$this->user['id']
		$reciver_id= '4';
		$content   = array('content_id' => '内容id', 'content_type' => 'article');
		$this->notification_service->insert($sender_id,$reciver_id,3,$content);				
	}

	public function test_follow()
	{
		$sender_id = '2';  //$this->user['id']
		$reciver_id= '4';
		$this->notification_service->insert($sender_id,$reciver_id,4,array());

	}	

}