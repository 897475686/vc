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
        $this->load->service('user_service');
        $this->load->service('article_like_service');
    }

    
    public function index($aid)
    {
        if(! is_numeric($aid))
        {
            show_404();
        }

        //获取文章信息
        $article = $this->article_service->get_article_by_id($aid);
        
        if($article == FALSE) 
        {
        	show_404();
        }

        //获取文章评论
        $comment = $this->article_service->get_comment_by_aid($aid);

        $data['like_people'] = $this->article_like_service->get_vote_person_by_aid($aid);
         $data['article'] = $article;
        $data['comment'] = $comment;
        
//         echo json_encode($data);
        $this->load->view('article_detail', $data);
    }
    
    public function vote_article()
    {
    	$aid = $this->sc->input('aid');
    	$uid = $this->user['id'];
    	
    	$this->article_service->vote_article($aid, $uid);
    }
}