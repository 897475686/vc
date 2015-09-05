<?php


class Main extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->service('article_service');
    }

    /**
     * [get_article_list 获取文章列表]
     * @param $[type] [文章类型]
     * @return [type] [description]
     */
    public function get_article_list()
    {
        //获得页数
        $page = $this->sc->input('page');
        // $page = 0;

        $tag = $this->sc->input('tag', 'get');

        $uid  = isset($this->user['id']) ? $this->user['id'] : NULL;
        //文章类型
        $type= $this->sc->input('type');
        $article = $this->article_service->get_article_list($page, $uid, $type, $tag);
        echo json_encode($article);
    }

    /**
     * [index 显示文章列表]
     * @param  string $type [文章类型(article 文章 topic 专题)]
     * @return [type]       [description]
     */
    public function index($type = 'article')
    {
        $data['css'] = array(
            'base.css',
            'font-awesome/css/font-awesome.min.css'
        );
        $data['javascript'] = array(
            'jquery.js',
            'masonry.pkgd.min.js',
            'jquery.imageloader.js',
            'jquery.pageslide.min.js'
        );

        $user['user'] = $this->user;

        $top = $this->load->view('common/top', $user, TRUE);
        $data['title']        = "资讯";
        $body['top']          = $top;
        $body['user']         = $this->user;
        $body['footer'] = $this->load->view('common/footer', '', TRUE);
        //文章类型
        $body['article_type'] = $type;
        $this->load->view('common/head', $data);
        if($type == 'article')
        {
            $this->load->view('article', $body);
        }
        else if($type == 'topic')
        {
             $this->load->view('topic_list', $body);
        }

    }
}
