<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="fui-page">
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/mobile/default/static/css/storedetail.css?v=2.0.0">

<link rel="stylesheet" href="http://at.alicdn.com/t/font_pn66xvaxw2ymn29.css">
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title">门店详情</div>
	</div>
	
	<div class="fui-content navbar">
		<div class="fui-list-group" style="margin-top:0">  
		   <div class="fui-list merchant">
	    		<div class="fui-list-media">
	    			<img src="<?php  echo $item['logo'];?>" class="round">
	    		</div>
	    		<div class="fui-list-inner" style="font-weight:bold">
					<?php  echo $item['storename'];?>
					<?php  if($item['hastag']==1  ) { ?>
					<?php  if(is_array($item['taglist'])) { foreach($item['taglist'] as $tag) { ?>
					<span class="shop-label shop-label-danger"><?php  echo $tag;?></span>
					<?php  } } ?>
					<?php  } ?>
	    		</div>
	    	</div>
	    	<div class="fui-list-group fui-list-group-o merchant">  
	    	   <div class="fui-list">
	    		  	<div class="fui-list-inner">
	    		  	    <div class="subtitle">营业时间：<?php  echo $item['saletime'];?></div>
	    		  	</div>
	    		</div>
	    		<div class="fui-list">
	    		  	<div class="fui-list-inner">
	    		  	    <div class="subtitle">门店简介：<?php  echo $item['desc'];?></div>
	    		  	</div>
	    		</div>
				<?php  if($item['haslabel']==1  ) { ?>
					<div class="fui-list fui-list-b">
						<?php  if(is_array($item['labellist'])) { foreach($item['labellist'] as $label) { ?>
							<div class="btn btn-sm btn-danger-o" ><?php  echo $label;?><div/>
						<?php  } } ?>
					</div>
				<?php  } ?>
	        </div>
	    </div>
		<div class="fui-cell-group fui-cell-click merchant">
			 <a class="fui-cell" href="tel:<?php  echo $item['tel'];?>">
				<div class="fui-cell-icon"><i class="icon icon-dianhua"></i></div>
				<div class="fui-cell-text"><p><?php  echo $item['tel'];?></p></div>
				<div class="fui-cell-remark"></div>
		 	 </a>
			 <a class="fui-cell external"  href="<?php  echo mobileUrl('store/map',array('id'=>$item['id']))?>">
				<div class="fui-cell-icon"><i class="icon icon-dingwei "></i></div>
				<div class="fui-cell-text"><?php  echo $item['address'];?></div>
				<div class="fui-cell-remark"></div>
			</a>
		 </div>
	</div>

<script>
	$('.fui-tab').click(function(e){
        var e = e||window.event;
        var a = $(this).find("a");
        for(var i = 0; i<a.length;i++){
            $(a[i]).removeClass("active")
        }
        $(e.target).addClass('active');
    })
</script>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
