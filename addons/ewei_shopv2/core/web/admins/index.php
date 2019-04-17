<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $admins = pdo_fetchall('SELECT uid,username,jobid,truename FROM ' . tablename('users'));
        $admins_list = [];
        foreach ($admins as $k => $v) {
            if ($v['uid'] != 1) {
                $admins_list[$k] = $v;
                $item = pdo_fetch('SELECT jobtitle FROM ' . tablename('ewei_shopv2_job') . (' WHERE id = \'' . $v['jobid'] . '\' limit 1'));
                $admins_list[$k]['jobtitle'] = $item['jobtitle'];
            }
        }

        include $this->template();
    }

    public function add()
    {
        $this->post();
    }

    public function post()
    {
        global $_W;
        global $_GPC;
        $uid = intval($_GPC['uid']);
        $item = pdo_fetch('SELECT * FROM ' . tablename('users') . (' WHERE uid = \'' . $uid . '\' limit 1'));

        $category = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shopv2_job'));
        include($this->template());
    }

    public function doadd()
    {
        $data = $_POST;
        @$uid = $data['uid'];
        if ($uid==null){
            if ($data['username'] == '' || $data['password'] == '') {
                exit(json_encode(array('code' => 1, 'msg' => '管理员名称或密码不能为空！')));
            }
            $item = pdo_fetch('SELECT * FROM ' . tablename('users') . (' WHERE username = \'' . $data['username'] . '\' limit 1'));
            if ($item == true) {
                exit(json_encode(array('code' => 1, 'msg' => '该管理员已经存在！')));
            }
            $data['joindate'] = time();
            $data['joinip'] = $_SERVER['SERVER_ADDR'];
            $data['salt'] = $this->str_rand();
            $data['password'] = user_hash($data['password'], $data['salt']);
            $res = pdo_insert('users', $data);
            $id = pdo_insertid();
            $admin = ['uniacid' => 2, 'uid' => $id, 'role' => 'owner'];
            $job = pdo_insert('uni_account_users', $admin);
            if ($res && $job) {
                exit(json_encode(array('code' => 0, 'msg' => '管理员添加成功！')));
            }
            exit(json_encode(array('code' => 1, 'msg' => '网络错误请检查网络！')));
        }
        $data['joinip'] = $_SERVER['SERVER_ADDR'];
        $data['salt'] = $this->str_rand();
        $data['password'] = user_hash($data['password'], $data['salt']);
        $res = pdo_update('users', $data,array('uid'=>$uid));
        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '管理员添加成功！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误请检查网络！')));

    }

    public function str_rand($length = 8, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            return false;
        }

        $string = '';
        for ($i = $length; $i > 0; $i--) {
            $string .= $char[mt_rand(0, strlen($char) - 1)];
        }

        return $string;
    }

    public function delete()
    {
        global $_W;
        global $_GPC;
        $id = intval($_GPC['id']);
        if (empty($id)) {
            $id = ((is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0));
        }
        if (pdo_delete('users', array('uid' => $id))) {
            show_json(1, array('url' => referer()));
        }

    }
}

?>
