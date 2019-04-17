<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/sign/static/css/sign.css?v=2.0.0">

<?php  if(!empty($set['maincolor']) && $set['maincolor']!='#24b2f4') { ?>
<style>
    .member-page .headinfo,
    .advaward .body .award-body .item .iconn.candraw,
    .btn.btn-warning.btn-know {background: <?php  echo $set['maincolor'];?>;}
    .calendar .title,
    .select-date,
    .advaward .body .award-body .item .days.candraw,
    .advaward .body .award-body .item .text.candraw,
    .calendar .body .week .day .signed {color: <?php  echo $set['maincolor'];?>;}
    .calendar .body .week .day.today:before,
    .advaward .body .award-body .item .text.candraw {border-color: <?php  echo $set['maincolor'];?>;}
</style>
<?php  } ?>

<div class='fui-page fui-page-current'>
    <div class="fui-header">
        <?php  if(!$_SESSION['sign_xcx_isminiprogram']) { ?>
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <?php  } ?>
        <div class="title"><?php  echo $set['textcredit'];?><?php  echo $set['textsign'];?></div>
        <div class="fui-header-right">
            <?php  if(!$_SESSION['sign_xcx_isminiprogram']) { ?>
            <a href="<?php  echo mobileUrl()?>" class="external">
                <i class="icon icon-home"></i>
            </a>
            <?php  } ?>
        </div>
    </div>

    <div class='fui-content member-page navbar'>

        <div class="headinfo">
            <a class="setbtn record" href="<?php  echo mobileUrl('sign/records')?>" data-nocache='true'>详细记录</a>
            <div class="child">
                <div class="title">连续<?php  echo $set['textsign'];?></div>
                <div class="num"><span id="signorder"><?php  echo $signinfo['orderday'];?></span>天</div>
            </div>
            <div class="child userinfo">
                <div class="face">
                    <img src="<?php  echo $member['avatar'];?>"/>
                </div>
                <div class="name"><?php  echo $member['nickname'];?></div>
                <div class="name">我的<?php  echo $set['textcredit'];?>:<span id="credit"><?php  echo intval($member['credit1'])?></span><?php  echo $set['textcredit'];?></div>
                <div class="level" style="padding-top: 0.2rem">
                    <div class="btn sign" id="btn-sign"><?php  if(!empty($signinfo['signed'])) { ?>今日<?php  echo $set['textsigned'];?><?php  } else { ?>点击<?php  echo $set['textsign'];?><?php  } ?></div>
                </div>
            </div>
            <div class="child">
                <div class="title">总<?php  echo $set['textsign'];?></div>
                <div class="num"><span id="signsum"><?php  echo $signinfo['sum'];?></span>天</div>
            </div>
        </div>

        <div class="calendar">
            <div class="title">
                <span class="date">
                    <i class="icon icon-calendar1"></i>
                    <select  id="date" class="select-date" name="date">
                        <?php  if(is_array($month)) { foreach($month as $item) { ?>
                        <option value="<?php  echo $item['year'];?>-<?php  echo $item['month'];?>" <?php  if($item['year']==$json_arr['year'] && $item['month']==$json_arr['month']) { ?>selected<?php  } ?>><?php  echo $item['year'];?>年<?php  echo $item['month'];?>月</option>
                        <?php  } } ?>
                    </select>
                </span>
                <?php  if(!empty($set['sign_rule'])) { ?>
                <span class="rule" id="signrule"><?php  echo $set['textsign'];?>规则</span>
                <?php  } ?>
            </div>
            <div class="body" id="calendar">
                <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sign/calendar', TEMPLATE_INCLUDEPATH)) : (include template('sign/calendar', TEMPLATE_INCLUDEPATH));?>
            </div>
            <?php  if(!empty($set['signold'])) { ?>
            <div class="fui-title" style="background: #fff; margin: 0; padding-bottom: 0.5rem">提示：点击<?php  echo $set['textsignforget'];?>日期可<?php  echo $set['textsignold'];?>哦~</div>
            <?php  } ?>
        </div>
        <div id="advaward">
            <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('sign/advaward', TEMPLATE_INCLUDEPATH)) : (include template('sign/advaward', TEMPLATE_INCLUDEPATH));?>
        </div>

        <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>

    </div>


    <div class="pop-rule-hidden" style="display: none;">
        <div class="verify-pop pop">
            <div class="close"><i class="icon icon-roundclose"></i></div>
            <div class="qrcode">
                <div class="inner">
                    <div class="title"><?php  echo $set['textsign'];?>规则</div>
                    <div class="text"><?php  echo $set['sign_rule'];?></div>
                </div>
                <div class="inner-btn" style="padding: 0.5rem">
                    <div class="btn btn-warning btn-know">我知道了</div>
                </div>
            </div>
        </div>
    </div>
    <?php  if(p('lottery')) { ?>
    <div id="changesmodel" style="display: none;width: 90%">
        <div id="changescontent" onclick="" class="task-model" style="background: url('../addons/ewei_shopv2/plugin/lottery/static/images/changes.png');background-size: cover; width: 90%; height: 16rem;  background-size: cover;position: relative;margin: 0 auto; margin-bottom: 55%;">
            <span class="changes-btn-close" style="border: 1px solid dodgerblue; color: dodgerblue; border-radius: 50%; position: absolute;right: 5px; padding: 0.2rem 0.4rem;top: 5px;z-index: 10"><i class="icon icon-close"></i><span>
        </div>
    </div>
    <?php  } ?>
    <script language='javascript'>
        require(['../addons/ewei_shopv2/plugin/sign/static/js/index.js'],function(modal){modal.init(<?php  echo $json;?>);});
    </script>
</div>
<?php  $this->footerMenus(null, false, $texts)?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->