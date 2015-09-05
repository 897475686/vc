<?php


class Article_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function publish_tag($tag_name)
    {
        $data = array(
            'name'  => $tag_name
        );
        $this->db->insert('article_tag', $data);

        if( $this->db->affected_rows() !== 1 )
        {
            return FALSE;
        }

        return $this->db->insert_id();
    }


    /**
     * 获取所有分类
     * $type: 标签类型（1资讯 2专题）
     * @return mixed
     */
    public function get_all_tag($type)
    {
        $query = $this->db->get('article_tag')->where('type', $type)->result_array();
        return $query;
    }
}