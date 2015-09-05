<body>
<input type="hidden" name="aid" value="<?= $article['id'] ?>" id="aid">

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <div class="container">
        <div class="content">
            <div class="adv">AD</div>
            <div class="article">
                <h1 class="title"><?= $article['title'] ?></h1>

                <div class="info">阅读<?=$article['read']?> 喜欢<?=$article['like']?></div>
                <div class="share clearfix"><!-- JiaThis Button BEGIN -->
                    <div id="ckepop" class="jiathis_share">
                        <span class="jiathis_txt">分享到：</span>
                        <a class="jiathis_button_tsina" title="分享到新浪微博"></a>
                        <a class="jiathis_button_weixin" title="分享到微信"></a>
                        <a class="jiathis_button_qzone" title="分享到QQ空间"></a>
                        <a class="jiathis_button_fb" title="分享到Facebook"></a>
                        <a class="jiathis_button_douban" title="分享到豆瓣"></a>
                        <a class="jiathis_button_evernote" title="分享到EverNote"></a>
                        <a class="jiathis_button_ydnote" title="分享到有道云笔记"></a>
                        <a href="http://www.jiathis.com/share?uid=1745061"
                           class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1"
                                charset="utf-8"></script>
                    </div>
                    <!-- JiaThis Button END -->
                </div>

                <!-- 文章内容 -->
                <div class="detail"><?= $article['content'] ?></div>

                <!-- END 文章内容-->
                <div class="share clearfix">
                    <div class="likebtn <?php if($like_status) echo 'focus'; ?>" id="vote">
                        <div class="support" id="mark-like"></div>
                        <div class="num" id="seeLike"><?=$article['like']?></div>
                    </div>

                    <!-- 分享按钮-->
                    <!-- JiaThis Button BEGIN -->
                    <div class="jiathis_style_24x24 jiathis_share" style="float: right; margin-top: 7px; height: 40px;">
                        <span class="jiathis_txt" style="font-size: 16px; height: 40px; line-height: 40px;">分享到：</span>
                        <a class="jiathis_button_tsina" title="分享到新浪微博"></a>
                        <a class="jiathis_button_weixin" title="分享到微信"></a>
                        <a class="jiathis_button_qzone" title="分享到QQ空间"></a>
                        <a class="jiathis_button_fb" title="分享到Facebook"></a>
                        <a class="jiathis_button_douban" title="分享到豆瓣"></a>
                        <a class="jiathis_button_evernote" title="分享到EverNote"></a>
                        <a class="jiathis_button_ydnote" title="分享到有道云笔记"></a>
                        <a href="http://www.jiathis.com/share"
                           class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
                        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js?uid=1"
                                charset="utf-8"></script>
                    </div>
                    <!-- JiaThis Button END -->
                </div>

                <!-- 评论部分 -->
                <div class="stream">
                    <?php
                    function find_subcomment($comment, $i)
                    {
                        $len = count($comment);

                        for ($j = 0; $j < $len; $j++) {
                            if ($comment[$j]['pid'] == $comment[$i]['id']) {
                                ?>
                                <div class="sub_comment" data-id="<?= $comment[$j]['id'] ?>">
                                    <div class="avatar"><img src="<?= $comment[$j]['user']['pic'] ?>"></div>
                                    <div class="time"><?= $comment[$j]['publish_time'] ?></div>
                                    <span class="name"><?= $comment[$j]['user']['name'] ?></span>
                                    <span class="location">回复了<?= $comment[$i]['user']['name'] ?></span>

                                    <p><?= $comment[$j]['content'] ?></p>

                                    <div class="options clearfix">
                                        <div class="reply">回复</div>
                                    </div>
                                    <div class="ft-comment clearfix" style="display: none;">
                                        <div class="clearfix">
                                            <textarea placeholder="post a comment..." style="float: right"></textarea>
                                        </div>
                                        <div class="btn write">回复</div>
                                        <div class="btn cancel">取消</div>
                                    </div>
                                </div>
                                <?php
                                find_subcomment($comment, $j);
                                return;
                            }
                        }
                    }

                    $len = count($comment);
                    for ($i = 0; $i < $len; $i++) if ($comment[$i]['pid'] == 0) { ?>
                        <div class="comment" data-id="<?= $comment[$i]['id'] ?>">
                            <div class="avatar"><img src="<?= $comment[$i]['user']['pic'] ?>"></div>
                            <div class="time"><?= $comment[$i]['publish_time'] ?></div>
                            <span class="name"><?= $comment[$i]['user']['name'] ?></span>
                            <span class="location">评论了该文章</span>

                            <p><?= $comment[$i]['content'] ?></p>

                            <div class="options clearfix">
                                <div class="reply">回复</div>
                            </div>
                            <div class="ft-comment clearfix" style="display: none;">
                                <div class="clearfix">
                                    <textarea placeholder="post a comment..."></textarea>
                                </div>
                                <div class="btn write">回复</div>
                                <div class="btn cancel">取消</div>
                            </div>
                        </div>
                        <?php
                        find_subcomment($comment, $i);
                    } ?>
                    <div class="answer clearfix">
                        <div class="btn send" id="wcomment">评论</div>
                        <textarea name="" id="" tabindex="0" rows='1' placeholder="写下你的评论"></textarea>
                    </div>
                </div>
                <!-- END 评论部分 -->
            </div>
        </div>
    </div>
    <?php echo $footer; ?>
</div>
</body>
<script>
    $(function () {
        var aid = $('#aid').val();
        $("#vote").click(function () {
            console.log(ARGEE_URL);

            $.ajax({
                type: 'POST',
                url: ARGEE_URL,
                async: false,
                data: {
                    aid: aid
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    var status = data;
                    if (status.success == 0) {
                        if ($('#vote').hasClass('focus')) {
                            $('#vote').attr('class', 'likebtn blur');
                            $('#seeLike').html(parseInt($('#seeLike').html()) - 1);
                        }
                        else {
                            $('#vote').attr('class', 'likebtn focus');
                            $('#seeLike').html(parseInt($('#seeLike').html()) + 1);
                        }
                    }
                    else if (status.error != null) {
                        ERROR_OUTPUT(data);
                        return false;
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
        // END vote click event

        //评论的点击事件，显示评论框
        $(".reply").click(function () {
            var self = $(this);
            self.parent().hide(100, function () {
                self.parent().next().slideDown(200)
            });

        });

        //评论中的取消事件
        $('.cancel').click(function () {
            var self = $(this).parent();
            self.slideUp(200, function () {
                self.prev().fadeIn(100);
            });
        });

        //发评论
        $('#wcomment').click(function () {
            var str = $(this).next().val();
            var pid = 0;

            send_comment(str, pid);
        });

        $('.write').click(function () {
            var str = $(this).prev().children('textarea').val();
            var pid = $(this).parent().parent().attr('data-id');
            console.log(str + " " + pid);

            send_comment(str, pid);
        });

        //发送评论的ajax
        function send_comment(str, pid) {
            str = trim(str);
            if (str.length == 0) {
                swal("评论不能为空");
                return false;
            }

            $.ajax({
                type: 'post',
                url: COMMENT_URL,
                data: {
                    aid: aid,
                    comment: str,
                    parent_id: pid
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == 0) {
                        //成功的操作
                        swal("Good job!", "You clicked the button!", "success")
                    }
                    else if (data.error != null) {
                        ERROR_OUTPUT(data);
                        return false;
                    }
                }
            });
        }

        autosize($('textarea'));
        var ta = document.querySelector('textarea');
        ta.addEventListener('focus', function () {
            autosize(ta);
        });
    });
</script>
</html>
