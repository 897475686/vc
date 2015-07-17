<?php

/**
 * Created by PhpStorm.
 * User: Rache
 * Date: 2015/7/15
 * Time: 21:56
 */
class Article_like_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * [article_vote 文章点赞或取消]
     * @param  [type] $aid [文章id]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
    public function article_vote($aid, $uid)
    {
        $query = $this->get_article_vote_by_both($aid, $uid);
        //首次点赞
        if( empty($query) ) {
            $data = array(
                'aid'           => $aid,
                'uid'           => $uid,
                'status'        => 1,
                'update_time'   => date("Y-m-d H:i:s", time())
            );
            $this->db->insert('article_like', $data);
            return $this->db->affected_rows() === 1 ? array('status' => 1,'type' => 0) : FALSE;
        }
        else{
            $status = ! $query['status'];
            $this->db->where('aid', $aid)
                     ->where('uid', $uid)
                     ->update('article_like', array('status' => $status, 'update_time' => date("Y-m-d H:i:s", time())));
            
            return $this->db->affected_rows() === 1 ? array('status' => $status,'type' => 1) : FALSE;
        }
        return FALSE;
    }

    /**
     * [get_article_vote_by_both 获取用户对文章的点赞信息]
     * @param  [type] $aid [description]
     * @param  [type] $uid [description]
     * @return [type]      [description]
     */
    public function get_article_vote_by_both($aid, $uid)
    {
        return $this->db->where(array('aid' => $aid,'uid' => $uid))->get('article_like')->row_array();
    }
}