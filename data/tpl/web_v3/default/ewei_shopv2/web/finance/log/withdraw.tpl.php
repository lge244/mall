<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">当前位置：<span class="text-primary">提现申请</span></div>
<div class="page-content">
    <form action="./index.php" method="get" class="form-horizontal table-search" role="form" id="form1">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r" value="finance.log.withdraw" />
        <div class="page-toolbar">
              <span class="pull-left">
                    <?php  echo tpl_daterange('time', array('sm'=>true,'placeholder'=>'提现时间'),true);?>
                </span>
            <div class="input-group">
                <span class="input-group-select">
                    <select name="status" class="form-control"   style="width:80px;"  >
                        <option value="" <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>>状态</option>
                        <option value="1" <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>完成</option>
                        <option value="0" <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>申请中</option>
                        <option value="-1" <?php  if($_GPC['status']=='-1') { ?>selected<?php  } ?>>失败</option>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="groupid" class="form-control" style="width:110px;float: right;"  >
                        <option value="">会员分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value="<?php  echo $group['id'];?>" <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="level" class="form-control" style="width:110px;float: right;"  >
                        <option value="">会员等级</option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value="<?php  echo $level['id'];?>" <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </span>
                <span class="input-group-select">
                    <select name="searchfield" class="form-control" style="width:110px;"  >
                        <option value="logno" <?php  if($_GPC['searchfield']=='logno') { ?>selected<?php  } ?>>提现单号</option>
                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
                    </select>
                </span>
                <input type="text" class="form-control input-sm"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词" />
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit"> 搜索</button>
                    <?php if(cv('finance.log.withdraw.export')) { ?>
                    <button type="submit" name="export" value="1" class="btn btn-success">导出</button>
                    <?php  } ?>
                </span>
            </div>
        </div>
    </form>

    <?php  if(empty($list)) { ?>
    <div class="panel panel-default">
        <div class="panel-body empty-data">未查询到相关数据</div>
    </div>
    <?php  } else { ?>

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead class="navbar-inner">
                <tr>
                    <th style='width:180px;'>充值单号</th>
                    <th>粉丝</th>
                    <th>会员信息</th>
                    <th style='width:100px;'>提现金额<br/>应到账金额<br/>手续费金额</th>
                    <th style="width: 80px;">已发送金额 <br/>(微信红包)</th>
                    <th style='width:180px;'>提现方式</th>
                    <th >提现时间</th>
                    <th style='width:100px;'>状态</th>
                    <th style='width:80px;text-align: center;'>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td>
                        <?php  if(!empty($row['logno'])) { ?>
                        <?php  if(strlen($row['logno'])<=22) { ?>
                        <?php  echo $row['logno'];?>
                        <?php  } else { ?>
                        recharge<?php  echo $row['id'];?>
                        <?php  } ?>
                        <?php  } else { ?>
                        recharge<?php  echo $row['id'];?>
                        <?php  } ?>
                    </td>
                    <td>
                        <?php if(cv('member.member.view')) { ?>
                        <a  href="<?php  echo webUrl('member/list/detail',array('id' => $row['mid']));?>" target='_blank'>
                            <img class="radius50" src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc'  onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/> <?php  echo $row['nickname'];?>
                        </a>
                        <?php  } else { ?>
                        <img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc'  class="radius50"  onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/> <?php  echo $row['nickname'];?>
                        <?php  } ?>
                    </td>
                    <td>
                        <?php  echo $row['realname'];?><br /><?php  echo $row['mobile'];?>
                    </td>
                    <td><?php  echo $row['money'];?><br/><?php  echo $row['realmoney'];?><br/><?php  echo $row['deductionmoney'];?></td>
                    <td><?php  if((float)$row['sendmoney'] != 0) { ?><?php  echo $row['sendmoney'];?><?php  } else { ?>-<?php  } ?></td>
                    <td title="<?php  if(empty($row['applytype'])) { ?><?php  echo $row['typestr'];?><?php  } else if($row['applytype']=='2') { ?><?php  echo $row['typestr'];?><?php  } else if($row['applytype']=='3') { ?><?php  echo $row['typestr'];?><?php  } ?><?php  if($row['applytype'] == 2) { ?>
                        姓名:<?php  echo $row['applyrealname'];?>
                        帐号:<?php  echo $row['alipay'];?>
                        <?php  } else if($row['applytype'] == 3) { ?>
                        姓名:<?php  echo $row['applyrealname'];?>
                        银行:<?php  echo $row['bankname'];?>
                        帐号:<?php  echo $row['bankcard'];?>
                        <?php  } ?>">
                        <?php  if(empty($row['applytype'])) { ?>
                        <span><i class="icow icow-weixin text-success"></i><?php  echo $row['typestr'];?></span>
                        <?php  if(strexists($row['openid'],'sns_wa')) { ?>(小程序)<?php  } ?>
                        <?php  } else if($row['applytype']=='2') { ?>
                        <span> <i class="icow icow-zhifubaozhifu text-primary"></i><?php  echo $row['typestr'];?></span>
                        <?php  } else if($row['applytype']=='3') { ?>
                        <span><i class="icow icow-icon text-warning"></i><?php  echo $row['typestr'];?></span>
                        <?php  } ?>

                        <?php  if($row['applytype'] == 2) { ?>
                        <br/>
                        姓名:<?php  echo $row['applyrealname'];?><br/>
                        帐号:<br/><?php  echo $row['alipay'];?>
                        <?php  } else if($row['applytype'] == 3) { ?>
                        <br/>
                        姓名:<?php  echo $row['applyrealname'];?><br/>
                        银行:<?php  echo $row['bankname'];?><br/>
                        帐号:<br/><?php  echo $row['bankcard'];?>
                        <?php  } ?>
                    </td>

                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i',$row['createtime'])?></td>
                    <td>
                        <?php  if($row['status']==0) { ?>
                        <span class='text-default'><?php  if($row['type']==1) { ?>申请中<?php  } else { ?>未充值<?php  } ?></span>
                        <?php  } else if($row['status']==1) { ?>
                        <span class='text-success'>成功</span>
                        <?php  } else if($row['status']==-1) { ?>
                        <span class='text-default'><?php  if($row['type']==1) { ?>拒绝<?php  } else { ?>失败<?php  } ?></span>
                        <?php  } else if($row['status']==3) { ?>
                        <span class='text-danger'><?php  if($row['type']==0) { ?>退款<?php  } ?></span>
                        <?php  } ?>
                    </td>

                    <td  style="overflow:visible;">
                        <?php  if($row['status']<1 && $row['status']!=-1 ) { ?>

                        <?php  if($row['status']==0 || $row['status']==-1) { ?>

                        <?php  if($row['applytype'] < 2) { ?>
                        <?php if(cv('finance.log.wechat')) { ?>
                        <a  class='btn btn-op btn-operation'  data-toggle='ajaxPost' data-confirm="确认微信钱包提现?" href="<?php  echo webUrl('finance/log/wechat',array('id' => $row['id']));?>">
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="微信提现">
                                        <i class="icow icow-weixinfanxian"></i>
                                    </span>
                        </a>
                        <?php  } ?>
                        <?php  } ?>

                        <?php  if($row['applytype'] == '2') { ?>
                        <?php if(cv('finance.log.alipay')) { ?>
                        <a  class='btn btn-op btn-operation' data-toggle='ajaxPost' data-confirm="确认支付宝提现?(提现成功可能需要等待两到三分钟处理完成!)" href="<?php  echo webUrl('finance/log/alipay',array('id' => $row['id']));?>">
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="支付宝提现">
                                        <i class="icow icow-zhifubao"></i>
                                    </span>
                        </a>
                        <?php  } ?>
                        <?php  } ?>

                        <?php if(cv('finance.log.manual')) { ?>
                        <a  class='btn btn-op btn-operation' data-toggle='ajaxPost' data-confirm="确认手动提现完成?" href="<?php  echo webUrl('finance/log/manual',array('id' => $row['id']));?>">
                                    <span data-toggle="tooltip" data-placement="top" title="" data-original-title="手动提现">
                                        <i class="icow icow-tixian"></i>
                                    </span>
                        </a>
                        <?php  } ?>

                        <?php  } ?>

                        <?php  if($row['status']==0) { ?>
                        <?php if(cv('finance.log.refuse')) { ?>
                        <a  class='btn btn-op btn-operation' data-toggle='ajaxPost' data-confirm="确认拒绝提现申请?" href="<?php  echo webUrl('finance/log/refuse',array('id' => $row['id']));?>">
                                <span data-toggle="tooltip" data-placement="top" title="" data-original-title="拒绝">
                                    <i class="icow icow-jujuejieshou"></i>
                                </span>
                        </a>
                        <?php  } ?>
                        <?php  } ?>
                        <?php  } ?>
                    </td>

                </tr>
                <?php  } } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4">
                        <div class="btn-group"></div>
                    </td>
                    <td colspan="5" style="text-align: right">
                        <span class="pull-right" style="line-height: 28px;">(共<?php  echo count($list)?>条记录)</span>
                        <?php  echo $pager;?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <?php  } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>