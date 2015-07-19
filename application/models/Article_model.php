<?php


class Article_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function publish_article($user_id, $article_title, $article_subtitle, $article_type, $article_content)
    {
        $data = array(
            'uid'           => $user_id,
            'type'          => $article_type,
            'title'         => $article_title,
            'subtitle'      => $article_subtitle,
            'content'       => $article_content,
            'publish_time'  => date("Y-m-d H:i:s", time())
        );

        $this->db->insert('article', $data);

        if( $this->db->affected_rows() !== 1 )
        {
            return FALSE;
        }

        $data['id'] = $this->db->insert_id();

        return $data;
    }

    public function get_article_by_id($aid)
    {
        return $this->db->where('id', $aid)->get('article')->row_array();
    }


    public function get_article_list($page = 0, $uid = -1, $type, $limit = 6, $order = "publish_time desc")
    {
        $query = $this->db
            ->select('article.id, article.uid, article.title, article.content, article.like')
            ->from('article');

        if( is_numeric($uid))
        {
            $query = $query->select('article_like.status');
            $query = $query->join('article_like', "article_like.aid = article.id AND article_like.uid = {$uid}", 'left');
        }
        // else
        // {
        //     //$query = $query->join('article_like', 'article_like.aid = article.id', 'left');
        // }

        $query =$query->order_by($order)->limit($limit, $page*$limit)->get()->result_array();

        return $query;
    }


    public function update_count($aid,$field = array()){
        $where = array('id' => $aid);
        $query = $this->db->select($field['name'])
                          ->from('article')
                          ->where($where)
                          ->get()
                          ->row_array();
                          
        if(!empty($query)){
            $query[$field['name']]=(int)$query[$field['name']]+(int)$field['amount'];     
            $this->db->where($where)->update('article',$query);
            return $this->db->affected_rows() === 1;
        }
        else{
            return FALSE;
        }
    }

    public function get_uid_by_aid($aid)
    {
        $query = $this->select('uid')->where('id', $aid)->get('article')->result_array();
        return count($query) === 1 ? $query[0] : NULL;
    }


    public function get_article_vote($aid, $order = 'id')
    {
      $query = $this->db->where(array('aid' => $aid,'status' => 1))
                        ->select('uid')
                        ->order_by($order)
                        ->get('article_like')
                        ->result_array();
      return $query;
    }    
}