<?php


class Article_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 把文章的信息插入到数据库
     */
    public function publish_article($user_id, $article_title, $article_type,$pids,$article_content)
    {
        $data = array(
            'uid'           => $user_id,
            'type'          => $article_type,
            'title'         => $article_title,
            'pids'          => $pids,
            'content'       => $article_content,
            'publish_time'  => date("Y-m-d H:i:s", time()),
            'creat_by'      => $user_id
        );

        $this->db->insert('article', $data);

        if( $this->db->affected_rows() !== 1 )
        {
            return FALSE;
        }

        return $this->db->insert_id();
    }

    public function get_article_by_id($aid)
    {
        return $this->db->where('id', $aid)->get('article')->row_array();
    }

    /**
     * [get_intro 获取简介]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
	public function get_intro_by_uid($uid)
    {
        $query = $this->db->where(array('uid' => $uid,'type' => 3))
                          ->get('article')
                          ->row_array();
        return $query;
    }

    /**
     * [get_article_list 获取文章列表]
     * @param  integer $page  [页数]
     * @param  [type]  $meid  [我的id]
     * @param  [type]  $uid   [用户id]
     * @param  [type]  $type  [文章类型]
     * @param  integer $limit [页面个数限制]
     * @param  string  $order [排序]
     * @return [type]         [description]
     */
    public function get_article_list($page = 0, $meid = NULL, $uid = NULL, $type = NULL, $pid = NULL, $tag = NULL, $limit = 6, $order = "id DESC")
    {
        $query = $this->db
            ->select('article.id, article.uid, article.title, article.content, article.like, article.read')
            ->from('article');

        if( is_numeric($meid))
        {
            $query = $query->select('article_like.status as like_status');
            $query = $query->join('article_like', "article_like.aid = article.id AND article_like.uid = {$meid}", 'left');
        }
        if( ! empty($uid))
        {
            $query = $query->where('article.uid', $uid);
        }
        if( ! empty($type))
        {
            $query = $query->where('article.type', $type);
        }
        if( ! empty($pid))
        {
          $query = $query->like('pids', "|{$pid}|");
        }
        if( ! empty($tag))
        {
            $query = $query->like('tag', "|{$tag}|");
        }
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

    /**
     * 点赞时，文章的 like 加一
     */
    public function argee_article($aid)
    {
    	$table_name = $this->db->protect_identifiers('article', TRUE);
    	$this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` + 1 WHERE {$table_name}.id = {$aid}");
    }

    /**
     * 取消点赞时，文章的 like 减一
     */
    public function disargee_article($aid)
    {
    	$table_name = $this->db->protect_identifiers('article', TRUE);
    	$this->db->query("UPDATE {$table_name} SET {$table_name}.`like` = {$table_name}.`like` - 1 WHERE {$table_name}.id = {$aid} and {$table_name}.`like` > 0");
    }


    public function read_article($aid)
    {
        $table_name = $this->db->protect_identifiers('article', TRUE);
        $this->db->query("UPDATE {$table_name} SET {$table_name}.`read` = {$table_name}.`read` + 1 WHERE {$table_name}.id = {$aid}");
    }

    /**
     * [delete_article 删除文章]
     * @param  [type] $aid [文章id]
     * @param  [type] $uid [用户id]
     * @return [type]      [description]
     */
    public function delete_article($aid, $uid = NULL)
    {
        $where = array();
        $where['id'] = $aid;
        if( ! empty($uid))
        {
            $where['uid'] = $uid;
        }
        $this->db->delete('article',$where);
        return $this->db->affected_rows() === 1;
    }

    public function delete_article_by_uid($uid)
    {
        $this->db->delete('article',array('uid' => $uid));
        return $this->db->affected_rows() > 0;
    }

    /**
     * [update_article 更新文章]
     * @param  [type] $aid [文章id]
     * @param  [type] $uid [用户id]
     * @param  [type] $arr [键值数组]
     * @return [type]      [description]
     */
    public function update_article($aid, $arr, $uid = NULL)
    {
      $arr['modify_time'] = date("Y-m-d H:i:s", time());
      if( ! empty($uid))
      {
        $this->db->where('uid',$uid);
      }
      $this->db->where('id', $aid)
               ->update('article',$arr);
      return $this->db->affected_rows() === 1;
    }




    public function admin_get_article_list($page = 0,$limit = 10,$order = 'id DESC')
    {
      $article = $this->db->select('article.id,article.uid,article.type,article_type.name as type_name,article.title,article.publish_time,article.read,article.like')
                          ->join('article_type','article.type = article_type.id','left')
                          ->order_by($order)
                          ->limit($limit,$page * $limit)
                          ->get('article')
                          ->result_array();
      return $article;
    }

    public function get_article_count()
    {
      return $this->db->count_all('article');
    }
}
