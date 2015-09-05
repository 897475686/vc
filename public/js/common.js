
var BASE_URL = document.getElementById('BASE_URL').value;
var GET_ARTICLE_URL = BASE_URL + "article/main/get_article_list";
var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
var VOTE_URL = BASE_URL + 'article/detail/get_vote_list';
var ARGEE_URL = BASE_URL + 'article/detail/vote_article';
var DELETE_URL = BASE_URL + 'article/detail/delete_article';

//艺术家列表
var GET_ARTIST_LIST = BASE_URL + 'artist/main/get_artist_list';

//登录
var LOGIN_URL = BASE_URL + 'login';


var PHONE_LOGIN_URL = BASE_URL + "account/main/login_by_phone";
var EMAIL_LOGIN_URL = BASE_URL + "account/main/login_by_email";
var EMAIL_SIGNUP_URL = BASE_URL + "account/main/register_by_email";
var PHONE_SIGNUP_URL = BASE_URL + "account/main/register_by_phone";
var CHECK_PHONE_URL = BASE_URL + "account/main/check_phone";
var CHECK_EMAIL_URL = BASE_URL + "account/main/check_email";

//艺术品列表
var GET_PRODUCTION_URL = BASE_URL + 'production/main/get_production_list';

//提交文章
var POST_ARTICLE_URL = BASE_URL + 'article/publish/publish_article';

//获取文章
var GET_ARTICLE_BY_ID = BASE_URL + 'topic/publish/get_article/';

//更新文章
var UPDATE_ARTICLE = BASE_URL + 'article/publish/update_article';

//艺术作品
var GET_ARTIST_ARTS = BASE_URL + 'artist/detail/get_artist_production';

//购物车列表
var GET_CART_GOODS = BASE_URL + 'cart/main/get_good_list';

//艺术品点赞
var VOTE_PRODUCTION = BASE_URL + 'production/detail/like_production';

//专题页面
var TOPIC_URL = BASE_URL + 'topic';

/**
 * [trim 去掉字符串前后两端的空格]
 */
function trim(str)
{
    return str.replace(/(^\s*)|(\s*$)/g, "");
}

/**
 * 获取url上get的参数
 * @param name
 * @returns {null}
 */
function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
        return r[2];
    return null;
}
