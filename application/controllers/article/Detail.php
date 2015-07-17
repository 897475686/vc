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
        $this->load->service('feed_service');   
        $this->load->service('notification_service');            
    }

    /**
     * [article_vote ���µ��޻�ȡ��]
     * @return [type] [description]
     */
    public function article_vote()
    {
        //�������id
        $aid = $this->sc->input('aid');
        $vote_result = $this->article_service->article_vote($aid, $this->user['id']);
        if(!empty($vote_result))
        {
            echo "success";            
            if($vote_result['status'] == 1)
            {
                //�������µ�����
                $this->article_service->update_count($aid,'like',1);             
            }
            else
            {
                //�������µ�����
                $this->article_service->update_count($aid,'like',-1);                
            }
            //�״ε���
            if( $vote_result['type'] == 0)
            {
                //��ӵ��޶�̬                
                $article = $this->article_service->get_article_by_id($aid);
                $feed_result = $this->feed_service->insert_vote_feed($this->user['id'], $article['id'], $article['uid'], $article['title'], $article['subtitle'], $article['content']);
                //��ӵ�����Ϣ
                $content = array('content_id' => $article['id'], 'content_type' => 'article');
                $notification_result = $this->notification_service->insert($this->user['id'],$article['uid'],3,$content);               
            }

        }
        else
        {
            echo "failed";
        }
    }

}