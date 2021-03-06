<body>
<div class="main-wrapper">
    <!-- 顶部 -->
    <?php echo $top;?>
    <div class="container">
        <div class="content edit">
            <form class="list" method="post" action="<?=base_url()?>production/publish/update_production">
                <input type="hidden" name="pid" value="<?=$production['id']?>">
                <div class="item">
                    <label>艺术品的展示图：</label>
                    <div class="headpic">
                        <input type="hidden" id="img"  name="pic" value="<?=$production['pic']?>"/>
                        <div class="box" style="background-image: url(<?=$production['pic']?>) ;background-position: 50% 50%; -moz-background-size:100% 100%; background-size:100% 100%;">
                            <div id="camera_warp" class="camera_warp">
                                <input type="file" name="upfile" id="upfile" onchange="file_upload()">
                                <i class="fa fa-camera fa-5x"></i>
                            </div>
                            <img id="image" src="" width="100%" height="100%">
                        </div>
                    </div>
                </div>
                <div class="item">
                    <label for="name">艺术品的标题：</label>
                    <input id="name" name="production_name" type="text" value="<?=$production['name']?>">
                </div>
                <div class="item">
                    <label for="intro">艺术品的介绍：</label>
                    <div class="text">
                        <textarea id="intro" name="production_intro" rows="5" ><?=$production['intro']?></textarea>
                    </div>
                </div>
                <div class="item">
                    <label for="aid">作者：</label>
                    <input type="text" name="aid" id="aid">
                </div>
                <div class="item">
                    <label for="">类型：</label>
                    <input type="text" name="type" value="<?=$production['type']?>">
                </div>
                <div class="item">
                    <label for="">材质：</label>
                    <input type="text" name="marterial" value="<?=$production['marterial']?>">
                </div>
                <div class="item size">
                    <label for="">长：</label><input type="text" name="l" value="<?=$production['l']?>">
                    <label for="">宽：</label><input type="text" name="w" value="<?=$production['w']?>">
                    <label for="">高：</label><input type="text" name="h" value="<?=$production['h']?>">
                    CM（厘米）
                </div>
                <div class="item">
                    <label for="">价格：</label>
                    <input type="text" name="price" value="<?=$production['price']?>">
                </div>
                <div class="item">
                    <label for="creat_time">创作日期：</label>
                    <input id="creat_time" type="text" name="creat_time" value="<?=$production['creat_time']?>">
                </div>
                <div class="options">
                    <div class="btn cancel" onclick="">取消</div>
                    <div id="save" class="btn save">保存</div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script>
    function file_upload()
    {
        var BASE_URL  = $("#BASE_URL").val();
        var UPLOAD_URL= BASE_URL+'publish/image/upload_production';
        $.ajaxFileUpload({
            url: UPLOAD_URL,
            fileElementId: 'upfile',
            dataType: 'JSON',
            type:'post',
            success: function (data) {
                // alert(data);
                console.log(data);
                $("#error_div").html("");
                if(data.error != null)
                {
                    $("#error_div").html(data.error);
                }
                else
                {
                    var path = data.pic;
                    var thumb= data.thumb;
                    img_src  = path;
                    $("#image").attr('src',thumb);
                    $('#img').attr('value',path);
                    $('#image').show();
                    $("#camera_warp").hide();
                }

            },
            error: function (data) {
                alert('error');
            }
        });
    }

    $(function(){
        autosize($('textarea'));

        var img_src = "";
        $("#image").hide();
        //取消
        $("#cancel").click(function()
        {
            //重定向
        });

        $("#save").click(function(){
            $('form').submit();
        });


    });
</script>
</script>
</html>
