<body>

<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top; ?>
    <!-- 轮播 -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($slider as $k => $v): ?>
                <div class="swiper-slide">
                    <img data-src="<?= $v['pic'] ?>" class="swiper-lazy">

                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- 轮播位置 -->
        <div class="swiper-pagination swiper-pagination-white"></div>
    </div>

    <!-- 主体 -->
    <div class="container">
        <!-- 导语 -->
        <div class="vcinfo">
            <div class="icon info"></div>
        </div>
        <!-- 最新专题 -->
        <div class="new-subject">
            <div class="wrapper clearfix">
                <div class="hd clearfix">
                    <div class="title">最新专题</div>
                    <div class="tran"></div>
                </div>
                <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
            </div>
            <div class="list" id="subject-list">
                <?php $i=0; 
                foreach ($topic as $k => $v): ?>
                    <?php 
                        if($i == 0)
                        {
                            $i=1;
                            echo '<div class="item big"><div class="box" style="background:url('.$v['content']['article_bigimage'].');background-size:cover;background-position:50% 50%;">';
                        }
                        else
                        {
                            echo '<div class="item"><div class="box" style="background: url('.$v['content']['article_image'].');background-size:cover;background-position:50% 50%;">';
                        }
                    ?>
                           
                        
                            <div class="info">
                                <p><?=$v['content']['article_content']?></p>
                            </div>
                            <div class="intro">
                                <div class="name">（<font color="#FFFFFF"><?=$v['content']['sort_title']?></font>）</div>
                                <div class="collect"><?=$v['like']?><div class="icon like"></div></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
               
            </div>
        </div>

        <!-- 最新上架 -->
        <div class="new-art">
            <div class="wrapper clearfix">
                <div class="hd clearfix">
                    <div class="title">最新作品</div>
                    <div class="tran"></div>
                </div>
                <div class="more"><a href="<?= base_url() ?>topic" class="link">more</a></div>
            </div>
            <div class="list" id="art-list">
                <?php $i=0; 
                foreach ($production as $k => $v): ?>
                    <?php 
                        if($i == 0)
                        {
                            $i=1;
                            echo '<div class="item big"><div class="box" style="background:url('.$v['bigpic'].');background-size:cover;background-position:50% 50%;">';
                        }
                        else
                        {
                            echo '<div class="item"><div class="box" style="background: url('.$v['pic'].');background-size:cover;background-position:50% 50%;">';
                        }
                    ?>
                            <div class="info">
                                <p><?=$v['intro']?></p>
                            </div>
                            <div class="intro">
                                <div class="name">（<font color="#FFFFFF"><?=$v['name']?></font>）</div>
                                <div class="collect"><?=$v['like']?><div class="icon like"></div></div>
                            </div>
                        </div>
                        <div class="price icon pricebg">￥<?=$v['price']?></div>                        
                    </div>
                <?php endforeach;?>

            </div>
        </div>
        


        
    </div>
    <?php echo $footer; ?>
</div>
<?php echo $sign; ?>
<script type="text/javascript" src="<?= base_url() ?>public/js/swiper.min.js"></script>
</body>
<script>

    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        preloadImages: true,
        lazyLoading: true,
        loop: true,
        autoplay: 5000,
        autoplayDisableOnInteraction: false,
        speed: 500,
        grabCursor: true
    });
    var swiper = new Swiper('.artist-swiper', {
        autoplayDisableOnInteraction: false,
        speed: 500,
        prevButton: '.swiper-button-prev',
        nextButton: '.swiper-button-next',
    });

    $(function () {
        var subject = document.querySelector('#subject-list');
        var art = document.querySelector('#art-list');
        var masonry = new Masonry(subject, {
            itemSelector: '.item',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true
        });
        var masonry = new Masonry(art, {
            itemSelector: '.item',
            columnWidth: 300,
            gutter: 30,
            isFitWidth: true,
            isAnimate: true,
            noSwiping: true
        });
    })

</script>
</html>
