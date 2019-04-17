<?php defined('IN_IA') or exit('Access Denied');?><?php  $this->shopShare()?>

<script language="javascript">
    // 以下代码用来解决文章详情的分享问题，强制加external
    $(function () {
        var a_collections = $('a');
        $.each(a_collections,function (index,val) {
            var that = $(val);
            var href = that.attr('href') ||'';
            var bool = href.indexOf('r=article');
            if (bool>0){
                that.addClass('external');
            }
        });
    });

    window.shareData = <?php  echo json_encode($_W['shopshare'])?>;
    setTimeout(function(){
        $.ajax({
            type: "GET",
            url:'<?php  echo mobileUrl('index.share_url',array(),true);?>',
            data:{url:location.href},
        dataType: "json",
            success: function(data){
            jssdkconfig = data.result || { jsApiList:[] };
            jssdkconfig.debug = false;
            jssdkconfig.jsApiList = ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','showOptionMenu', 'hideMenuItems', 'onMenuShareQZone', 'scanQRCode','openLocation'];
            wx.config(jssdkconfig);
            wx.ready(function () {
                wx.showOptionMenu();

                <?php  if(!empty($_W['shopshare']['hideMenus'])) { ?>
                wx.hideMenuItems({
                    menuList: <?php  echo  json_encode($_W['shopshare']['hideMenus'])?>
            });
                <?php  } ?>

                    window.shareData.success = "<?php  echo $_W['shopshare']['way'];?>";
                    if(window.shareData.success){
                        var success = window.shareData.success;
                        window.shareData.success = function(){
                            eval(success)
                        };
                    }
                    wx.onMenuShareAppMessage(window.shareData);
                    wx.onMenuShareTimeline(window.shareData);
                    wx.onMenuShareQQ(window.shareData);
                    wx.onMenuShareWeibo(window.shareData);
                    wx.onMenuShareQZone(window.shareData);
                });
        },
        error:function(e){
            console.log(JSON.stringify(e));
        }
    });
    },500);

    <?php  if(!empty($_W['shopset']['wap']['open']) && !is_weixin()) { ?>
    //	Share to qq
    require(['//qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js'], function(setShareInfo) {
        setShareInfo({
            title: "<?php  echo $_W['shopshare']['title'];?>",
            summary: "<?php  echo str_replace(array("\r","\n"),'',$_W['shopshare']['desc'])?>",
            pic: "<?php  echo $_W['shopshare']['imgUrl'];?>",
            url: "<?php  echo $_W['shopshare']['link'];?>"
        });
    });
    <?php  } ?>
</script> 