<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('diyform.temp')) {
			header('location: ' . webUrl('diyform/temp'));
		}
		else if (cv('diyform.job')) {
			header('location: ' . webUrl('diyform/job'));
		}
		else if (cv('diyform.set')) {
			header('location: ' . webUrl('diyform/set'));
		}
		else {
			header('location: ' . webUrl());
		}
	}
}

?>
