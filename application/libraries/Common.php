<?php
class Common{
	/**
	 * 获取真实的IP地址
	 * @return [type] [description]
	 */
	static function getIP() {

	    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
	        $ip = getenv("HTTP_CLIENT_IP");
	    else
	        if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
	            $ip = getenv("HTTP_X_FORWARDED_FOR");
	        else
	            if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
	                $ip = getenv("REMOTE_ADDR");
	            else
	                if (isset ($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
	                    $ip = $_SERVER['REMOTE_ADDR'];
	                else
	                    $ip = "unknown";
	    return ($ip);
	}


	/**
	 * [get_route 获取路由]
	 * @return [type] [description]
	 */
	static function get_route()
	{
		$CI = &get_instance();
		$class = $CI->router->fetch_class();
		$dir   = $CI->router->fetch_directory();
		$method= $CI->router->fetch_method();
		$route = "{$dir}{$class}/{$method}";
		return $route;
	}


    /**
     * [extract_article 格式化文章至列表]
     * @param  [type] $article_id      [文章id]
     * @param  [type] $article_title   [文章标题]
     * @param  [type] $article_content [文章内容]
     * @return [type]                  [description]
     */
    static function extract_article($article_id, $article_title, $article_content)
    {
        $content = array(
            'article_id'        => $article_id,
            'article_title'     => $article_title,
            'article_content'   => Common::extract_content($article_content),
            'article_image'     => Common::extract_first_img($article_content)
        );
        return $content;
    }

    /**
     * 删除文章的格式，空格
     * @param $article_content
     * @return string
     */
    static function extract_content($article_content)
    {
        //去掉 HTML 的开标签
        $article_content = preg_replace("/(<([\w]+)[^>]*>)/i", "", $article_content);

        //去掉 HTML 的闭标签
        $article_content = preg_replace("/(<\/([\w]+)[^>]*>)/i", "", $article_content);

        //去掉空格
        $article_content = preg_replace("/\s/", "", $article_content);

		if(mb_strlen($article_content) > 70)
		{
       		$article_content = mb_substr($article_content, 0, 70);
       		$article_content.="...";
		}

        return $article_content;
    }


    /**
     * 获取文章中的第一张图片
     * @param $article_content
     * @return string
     */
    static function extract_first_img($article_content)
    {
        $match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $article_content, $match);
        $result = isset( $match[1][0] ) ? $match[1][0] : '';
    	if(isset($match[1][0]))
    	{
    		$path = $match[1][0];
    		$path = explode('/', $path);
    		$count= count($path);
            if(strstr($path[$count-1],'thumb2_'))
            {
                $path[$count-1] = str_replace('thumb2_','',$path[$count-1]);
            }
            
    		$filename = "thumb1_".$path[$count-1];
    		$path[$count-1] = $filename;
    		$path = implode('/',$path);
    		return $path;
    	}
    	else
    	{
    		$default_img = base_url().'public/img/defaultBG.jpg';
    		return $default_img;
    	}
    }

    static function get_thumb_url($pic,$pre = "thumb1_")
    {
        $arr   = explode('/',$pic);
        if( ! empty($arr))
        {
            $arr[count($arr)-1] = $pre.$arr[count($arr)-1];
            $pic = implode('/', $arr);
            return $pic;
        }
        return "";
    }

    /**
     * [has_first_img 是否有图片]
     * @return boolean [description]
     */
    static function has_first_img($content)
    {
 		$match = array();
        preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg]))[\'|\"].*?[\/]?>/", $content, $match);
        return isset( $match[1][0] ) ? $match[1][0] : '';
    }

    static function arr_sort($array,$key,$order="asc")
    {//asc是升序 desc是降序

		$arr_nums=$arr=array();

		foreach($array as $k=>$v)
		{
			$arr_nums[$k]=$v[$key];
		}

		if($order=='asc')
		{
			asort($arr_nums);
		}
		else
		{
			arsort($arr_nums);
		}

		foreach($arr_nums as $k=>$v){
			array_push($arr, $array[$k]);

		}

		return $arr;

	}


    static function replace_face_url($str){
        $face_url = base_url().'public/img/face/';
        $str = str_replace(">",'<；',$str);
        $str = str_replace(">",'>；',$str);
        $str = str_replace("\n",'<br/>',$str);
        $str = preg_replace("[\[em_([0-9]*)\]]","<img src=\"{$face_url}$1.gif\" />",$str);
        return $str;
    }

    static function is_ajax()
    {
	    if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest")
		{
			return TRUE;
		}
		return FALSE;
    }

}
