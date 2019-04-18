<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">  当前位置：<span class="text-primary"><?php  echo $cover['name'];?>入口设置</span></div>
<div class="page-content">
    <form id="setform"  action="" method="post" class="form-horizontal form-validate" >

        <div class="form-group">
            <label class="col-lg control-label">直接链接</label>
            <div class="col-sm-9 col-xs-12">
                <p class='form-control-static'>
                    <a href='javascript:;' class="js-clip" title='点击复制链接' data-url="<?php  echo $cover['url']?>" ><?php  echo $cover['url']?></a>
                    <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true"
                          data-content="<img src='<?php  echo m('qrcode')->createQrcode($cover['url'])?>' width='130' alt='链接二维码'>" data-placement="auto right">
                            <i class="glyphicon glyphicon-qrcode"></i>
                        </span>
                </p>
            </div>
        </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->