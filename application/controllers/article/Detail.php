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
        $this->load->model('article_like_service');
    }

    /**
     * Ϊ���µ���
     */
    public function article_vote()
    {
        //��õ��޵��˵� id ������id
        $aid = $this->sc->input('aid');
        $uid = $this->user['id'];

        $this->article_like_service->article_vote($aid, $uid);
    }
}