<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        include $this->template();
    }

    public function job()
    {
        include $this->template();

    }

    public function add()
    {
        $this->post();
    }

    public function post()
    {
        include($this->template());
    }


}

?>
