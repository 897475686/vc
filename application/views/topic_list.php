<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="filter-warp">
            <div class="filter">
                <ul class="fc-target">
                    <li>标签1的类型：</li>
                    <li><a href="javascript:void(0)" onclick="getArticleListBYtag(1)" class="link active">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
            <div class="filter">
                <ul class="fc-target">
                    <li>标签2的类型：</li>
                    <li><a href="" class="link">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
            <div class="filter">
                <ul class="fc-target">
                    <li>标签3的类型：</li>
                    <li><a href="" class="link">小清新</a></li>
                    <li><a href="" class="link">惊喜</a></li>
                    <li><a href="" class="link">乱七八糟</a></li>
                </ul>
            </div>
        </div>
        <div class="article-list" id="article-list">
<!--                <div class="box">-->
<!--                    <img class="image" src="http://img02.liwushuo.com/image/150409/gu40pimlg.jpg-w720" alt=""/>-->
<!--                    <p class="title">标题：我的世界</p>-->
<!--                    <p class="content">-->
<!--                        这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊dasfdasfdasfdasfdasfdasfdasfssfffffffffffffdsafdasfdasfdasfdasfdasfdasfdasf-->
<!--                    </p>-->
<!--                    <div class="bottom clearfix">-->
<!--                        <div class="like" style="float: right;">-->
<!--                            <span>199</span>-->
<!--                            <div class="icon like"></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

        </div>
    </div>
    <?php echo $footer; ?>
</div>
<div class="no-more">没有更多内容了 </div>
</body>
<script>

    function alertNoMore() {
        var $box = $('.no-more');
        $box.addClass('focus');
    }

    function readArticle(id) {
        window.location.href = BASE_URL + 'article/' + id;
    }

    function getArticleListBYtag(tag_id) {
        window.location.href = TOPIC_URL+'?tag=' + tag_id;
    }

    $(function () {
        'use strict';

        var tag = getQueryString('tag');
        var url = '';

        if(tag != null) {
             url = GET_ARTICLE_URL+'?tag=' + tag;
        }
        else {
             url = GET_ARTICLE_URL;
        }

        console.log(url);

        var $container = $('.article-list');
        var container = document.querySelector('.article-list');
        var page = 0;

        var masonry = new Masonry(container, {
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: false
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                console.log("load done");
                console.log(elm.width + " " + elm.height);
//                $(elm).parent().css({'height': elm.height, 'width': elm.width});
                masonry.layout();
            }
        });

        var count = 0;
        var sum = 0;

        function LoadMore() {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    page: page,
                    type: 'topic'
                },
                dataType: 'json',
                success: function (data) {
                    var items = data;
                    sum = items.length;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        alertNoMore();
                        return;
                    }

                    page++;

                    for (var i = 0; i < items.length; i++) {

                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="box" onclick="readArticle('+article_id+')" style="height:360px;">' +
                            '<img class="image" src="'+BASE_URL+'public/img/load.gif" data-src="'+img+'" alt=""/>' +
                            '<p class="title">'+article_title+'</p>' +
                        '<p class="content">'+article_content+'</p>' +
                            '<div class="bottom clearfix">' +
                            '<div class="like" style="float: right;">' +
                            '<span>'+like+'</span>' +
                            '<div class="icon like"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function (elm) {
                                masonry.layout();
                                console.log(elm.width + " " + elm.height);
//                                $(elm).parent().css({'height': elm.height, 'width': elm.width});

                                count++;
                                if (count == sum) {
                                    //Add Event
                                    WindowEvent();
                                    count = 0;
                                }
                            },
                            callback: function (elm) {
                                console.log('loadding');
                                masonry.layout();
                            }
                        });
                        // -------------- End -------------
                    }
                }
            });
        }

        LoadMore();

        $(document).click(function () {
            console.log('click');
            LoadMore();
        });

        WindowEvent();


        function WindowEvent() {
            $(window).scroll(function () {
                // 当滚动到最底部以上100像素时， 加载新内容
                if ($(document).height() - $(this).scrollTop() - $(this).height() < 100) {
                    $(window).unbind('scroll');
                    console.log(page);
                    LoadMore();
                }
            });
        }
    });
</script>
</html>
