<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/16
 * Time: 14:59
 */
class Detail extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');        
    }

    /**
     * [article_vote ���µ��޻�ȡ��]
     * @return [type] [description]
     */
    public function article_vote()
    {
        //�������id
        $aid = $this->sc->input('aid');
        $aid = 19;
        $this->user = array();
        $this->user['id'] = 4;        
        $vote_result = $this->article_service->article_vote($aid, $this->user['id']);
        if( ! empty($vote_result))
        {
            
        }
        else
        {
             echo "failed";           
        }
    }

}