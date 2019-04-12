<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		if (cv('qa.question')) {
			header('location: ' . webUrl('qa/question'));
		}
		else if (cv('qa.job')) {
			header('location: ' . webUrl('qa/job'));
		}
		else if (cv('qa.set')) {
			header('location: ' . webUrl('qa/set'));
		}
		else {
			header('location: ' . webUrl());
		}

		exit();
	}
}

?>
