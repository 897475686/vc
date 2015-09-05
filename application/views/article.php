<body>
<div class="main-wrapper">
    <?php echo $top; ?>
    <div class="container">
        <div class="article-list" id="article-list">

<!--            <div class="box">-->
<!--                <img class="image"-->
<!--                     src="http://hanzh.oss-cn-shenzhen.aliyuncs.com/public/upload/20150820/thumb1_14400058514902.jpg"-->
<!--                     alt=""/>-->
<!---->
<!--                <p class="title">标题：我的世界</p>-->
<!---->
<!--                <p class="content">这是一段介绍因为爱爱爱爱爱爱爱爱啊啊这是-->
<!--                    一段介绍因为爱爱爱爱爱爱爱爱啊啊这是一段介绍因为爱爱爱爱爱爱爱爱啊啊-->
<!--                    这是一段介绍因为爱爱爱爱爱爱爱爱啊啊dasfdasfdasfdasfdasfda-->
<!--                    sfdasfssfffffffffffffdsafdasfdasfdasfdasfdasfdasfdasf-->
<!--                </p>-->
<!---->
<!--                <div class="bottom">-->
<!--                    <div class="like">-->
<!--                        <span>199</span>-->
<!--                        <div class="icon like"></div>-->
<!--                    </div>-->
<!--                    <div class="read">-->
<!--                        <span>2000</span>-->
<!--                        <i class="fa fa-eye"></i>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

        </div>
    </div>
    <?=$footer?>
</div>
</body>
<script>

    function readArticle(id) {
        window.location.href = BASE_URL + 'article/' + id;
    }


    $(function () {
        'use strict';

        var $container = $('.article-list');
        var container = document.querySelector('#article-list');
        var page = 0;

        var masonry = new Masonry(container, {
            stamp: '.menu',
            itemSelector: '.box',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });

        $container.imageloader({
            selector: '.image',
            each: function (elm) {
                console.log("load done");
                console.log(elm.width + " " + elm.height);
                $(elm).parent().css({'height': elm.height, 'width': elm.width});
                masonry.layout();
            }
        });

        var count = 0;
        var sum = 0;

                function LoadMore() {
            $.ajax({
                type: 'POST',
                url: GET_ARTICLE_URL,
                async: false,
                data: {
                    page: page,
                    type: 'article'
                },
                dataType: 'json',
                success: function (data) {
                    // var items = eval('(' + data + ')');
                    var items = data;
                    sum = items.length;

                    if (items.error != null || items.length === 0) {
                        console.log('Error');
                        return;
                    }

                    page++;

                    for (var i = 0; i < items.length; i++) {
                        // var items[i].content = items[i].content;

                        var article_id = items[i].content.article_id;
                        var article_title = items[i].content.sort_title;
                        var article_content = items[i].content.article_content;
                        var img = items[i].content.article_image;
                        var like = items[i].like;
                        var read = items[i].read;


                        var box = $('<div class="box">' +
                            '<img class="image"' +
                        'src="'+ img +'"' +
                        'alt=""/>' +

                            '<p class="title">'+article_title+'</p>' +

                        '<p class="content">' + article_content +'</p>' +

                        '<div class="bottom">' +
                            '<div class="like">' +
                            '<span>'+like+'</span>' +
                            '<div class="icon like"></div>' +
                            '</div>' +
                            '<div class="read">' +
                            '<span>'+read+'</span>' +
                            '<i class="fa fa-eye"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>');
                        $container.append(box);
                        masonry.appended(box);

                        $(box).imageloader({
                            each: function (elm) {
                                masonry.layout();
                                console.log(elm.width + " " + elm.height);
                                $(elm).parent().css({'height': elm.height, 'width': elm.width});

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
