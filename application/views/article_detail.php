<body>
<?=$sidebar ?>
<input id="aid" type="hidden" value="<?=$article['id']?>">
<div id="vi_container" class="container">
  <div id="shade"></div>
  <div class="content article-detial">
    <div id="likeList" class="like-list">
      <div id="close" class="close"> <i class="fa fa-close fa-2x"></i>
      </div>
      <div id="people" class="people">
        <h1>喜欢的人</h1>
        <div id="list" class="list"></div>
      </div>
    </div>
    <div class="author">
      <div class="head">
        <img src="<?=base_url().'public/img/mm1.jpg'?>"></div>
      <a class="link" href="<?=$article['author']['alias']?>">
        <span class="name">
          <?=$article['author']['name']?>
        </span>
      </a>
      <p class="author-info"><?=$article['author']['intro']?></p>
    </div>
    <h1 class="article-title">
      <?=$article['title']?></h1>
    <h2 class="article-subtitle">
      <?=$article['subtitle']?></h2>
    <div class="article-info"> 
      <i class="fa fa-eye"></i>
      <span><?=$article['read']?></span>
      </div>
    <div class="article-content">
      <?=$article['content']?></div>
    


    <?php if(isset($status) && $status == '1') { ?>
      <div class="likebtn1 focus">
      <?php } else { ?>
      <div class="likebtn1">
      <?php } ?>
        <div class="support" id="mark-like"></div>

        <div class="num" id="seeLike">
            <?=$article['like']?>
        </div>
      </div>



      <hr class="line">

      <?php if(count($comment) == 0) { ?>
      <div class="no-comment">暂时还没有评论</div>
      <?php } else { ?>
      <div class="playground">
        <div class="box buddycloud">  
          <div class="stream">
            <article class="topic">
              <?php
          $len = count($comment) < 5 ? count($comment) : 5;
          for($i = 0; $i < $len; $i++) {
          ?>
              <section class="opener">
                <div class="avatar">
                  <img src="<?=$comment[$i]['user']['pic']?>"></div>
                <div class="postmeta">
                  <span class="time">
                      <time class="timeago" title="<?=$comment[$i]['publish_time']?>" datetime="<?=$comment[$i]['publish_time']?>+08:00">                       
                      </time>
                  </span>
                </div>
                <span class="name">
                  <?=$comment[$i]['user']['name']?></span>
                <p>
                  <?=$comment[$i]['content']?></p>
              </section>
              <?php } ?>
              <div class="hidden">
                <?php $len = count($comment);
            for($i = 5; $i < $len; $i ++) {
            ?>
                <section class="opener">
                  <div class="avatar">
                    <img src="<?=$comment[$i]['user']['pic']?>"></div>
                  <div class="postmeta">
                    <span class="time">
                      <time class="timeago" title="<?=$comment[$i]['publish_time']?>" datetime="<?=$comment[$i]['publish_time']?>+08:00">                       
                      </time>
                    </span>
                  </div>
                  <span class="name">
                    <?=$comment[$i]['user']['name']?></span>
                  <p>
                    <?=$comment[$i]['content']?></p>
                </section>
                <?php } ?></div>
              <!-- /hidden -->
              <?php if($len >
              5){ ?>
              <section class="seeMore">
                <span>查看全部评论</span>
              </section>
              <?php } ?></article>
          </div>
        </div>
      </div>
      <?php } ?>
      <article class="topic">
        <div class="answer clearfix" style="position:relative;">
          <div id="emotion" class="emotion"></div>
          <div class="msg">
            <textarea id="msg"  placeholder="想说写什么..."></textarea>
          </div>
          <div id="submit" class="send btn">发送</div>
        </div>
      </article>
      <?=$footer?>
    </div>
  </div>

</div>
<script src="<?=base_url().'/public/js/paperfold/paperfold.js'?>"></script>
<script>
  function get_data(url)
  {
    var aid = $('#aid').val();
    var ret = '';

    $.ajax({
      type: 'POST',
      url: url,
      async: false,
      data: {
        aid: aid
      },
     success:function(data){
            ret = data;
        }
    });
    return ret;
  }
  $(function (){
    var BASE_URL = $('#BASE_URL').val();
    var COMMENT_URL = BASE_URL + 'article/detail/write_comment';
    var VOTE_URL = BASE_URL + 'article/detail/get_vote_list';
    var ARGEE_URL = BASE_URL + 'article/detail/vote_article';

    //点赞按钮动画
    $(".likebtn1 .support").click(function(){
      if($(this).parent().hasClass('focus')){
        $(this).parent().attr('class','likebtn1 blur');
      }else{
        $(this).parent().attr('class','likebtn1 focus');
      }
    });
    //获取文章的id
    var aid = window.location.href.split("/");
    aid = aid[aid.length-1];
    var firstTime = true;


    $('#msg').flexText();
    $('#emotion').qqFace({ 
        assign: 'msg',                          //给输入框赋值 
        path: BASE_URL + "public/img/face/"     //表情图片存放的路径 
    });

    $('#submit').click(function(){
      var str = $('#msg').val();
      $.ajax({
          type: "POST",
          url: COMMENT_URL,
          data: {
              aid: aid,
              comment: str
          },
          success: function(data) {
              var obj = eval("(" + data + ")");
              if(obj.error != null)
              {
                ERROR_OUTPUT(obj);
                return false;
              }
              else 
              {
                 if(obj.script != null)
                 {
                   eval(obj.script);
                 }
              }
          }
      });
    });


    $("#seeLike").click(function(){
      $("body").addClass("hide-y");
      $('#likeList').removeClass('fadeOut');
      $("#likeList").addClass('fadeIn');
      $('#list').empty();

      var list = get_data(VOTE_URL);
      list = eval('(' + list + ')');
      for(i in list) {
        var item = list[i];
        $("#list").append('<div class="item clearfix"><div class="head"><img src="' + item.user.pic + '"></div><a class="link" href="'+item.user.alias+'"><div class="username">'+item.user.name+'</div></a><div class="time">'+item.update_time+'</div></div>');
      }
    });

    $("#close").click(function(){
      $('body').removeClass('hide-y');
      $('#likeList').removeClass('fadeIn');
      $("#likeList").addClass('fadeOut');
    });

    $("#mark-like").click(function(){
      $.ajax({
        type: 'POST',
        url: ARGEE_URL,
        async: false,
        data: {
          aid: aid
        },
        success:function(data){
          var status = eval('(' + data + ')');
          if(status.success == 0) {
            if($('#mark-like').parent().hasClass('focus')) {
              $('#seeLike').html(parseInt($('#seeLike').html())+1);
            }
            else {
              $('#seeLike').html(parseInt($('#seeLike').html())-1);
            }
          }
          else if(status.error != null)
          {
             ERROR_OUTPUT(status);
             return false;
          }
        }
      });
    });
    
    $(".timeago").timeago();
  });
</script>
</body>
</html>