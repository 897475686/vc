
var BASE_URL = document.getElementById('BASE_URL').value;
var GET_ARTICLE_URL = BASE_URL + "article/main/get_article_list";
var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
var VOTE_URL = BASE_URL + 'article/detail/get_vote_list';
var ARGEE_URL = BASE_URL + 'article/detail/vote_article';
var DELETE_URL = BASE_URL + 'article/detail/delete_article';
var LOGIN_URL = BASE_URL + 'login';
var PHONE_LOGIN_URL = BASE_URL + "account/main/login_by_phone";
var EMAIL_LOGIN_URL = BASE_URL + "account/main/login_by_email";
var EMAIL_SIGNUP_URL = BASE_URL + "account/main/register_by_email";
var PHONE_SIGNUP_URL = BASE_URL + "account/main/register_by_phone";
var CHECK_PHONE_URL = BASE_URL + "account/main/check_phone";
var CHECK_EMAIL_URL = BASE_URL + "account/main/check_email";   