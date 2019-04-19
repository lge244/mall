<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function main()
	{
		global $_W;
		$store = pdo_getall('ewei_shop_store', ['uid' => $_W['uid']]);
		$shop_id = [];
		foreach ($store as $v) {
			$shop_id[] = $v['id'];
		}
		$list = pdo_getall('ewei_shop_purchase', ['shop_id in' => $shop_id]);
		$store_list = [];
		foreach ($store as $v) {
			$store_list[$v['id']] = $v['storename'];
		}
		include $this->template();
	}

	public function add()
	{
		$this->goodList();
	}

	public function post()
	{
		global $_W;
		global $_GPC;
		$good_id = $_POST['good_id'];
		$stock = $_POST['stock'];
		$shop_id = intval($_POST['shop_id']);
		if (empty($good_id)) $this->message('至少选择一件商品！', webUrl('purchase/add'));
		if (empty($stock)) $this->message('请选择进货数量！', webUrl('purchase/add'));
		if (empty($shop_id)) $this->message('未选择门店！', webUrl('purchase/add'));
		$good_id = implode(',', $good_id);
		$good_info = pdo_fetchall("SELECT * FROM " . tablename('ewei_shop_goods') . " WHERE id IN ($good_id)");
		foreach ($good_info as &$val) {
			foreach ($stock as $k => $v) {
				if (!is_numeric($v)) $this->message('进货数量必须为数字！', webUrl('purchase/add'));
				if ($k == $val['id'] && $stock[$val['id']] >= $val['total']) {
					$this->message('进货数量不得大于总库存！', webUrl('purchase/add'));
				}
			}
			$val['total'] = 0;
			$val['good_id'] = $val['id'];
			$val['shop_id'] = $shop_id;
			$val['order_status'] = 0;
			$val['number'] = (int) $stock;
			unset($val['id']);
			$res = pdo_insert('ewei_shop_purchase', $val);
		}
		unset($good_info);
		if (!$res) $this->message('进货失败', webUrl('purchase/add'));
		$this->message('进货成功', webUrl('purchase'));
	}

	public function del()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		if (empty($id)) {
			$id = ((is_array($_GPC['ids']) ? implode(',', $_GPC['ids']) : 0));
		}
		if (pdo_delete('ewei_shop_purchase', array('id' => $id))) {
			show_json(1, array('url' => referer()));
		}
	}

	public function goodList($goodsfrom = 'sale')
	{
		global $_W;
		global $_GPC;
		if (empty($_W['shopversion'])) {
			$goodsfrom = strtolower(trim($_GPC['goodsfrom']));
			if (empty($goodsfrom)) {
				header('location: ' . webUrl('goods', array('goodsfrom' => 'sale')));
			}
		} else if (!(empty($_GPC['goodsfrom']))) {
			header('location: ' . webUrl('goods/' . $_GPC['goodsfrom']));
		}
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) {
			$is_openmerch = 1;
		} else {
			$is_openmerch = 0;
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$sqlcondition = $groupcondition = '';
		$condition = ' WHERE g.`uniacid` = :uniacid and g.type<>9';
		$params = array(':uniacid' => $_W['uniacid']);
		if (!(empty($_GPC['keyword']))) {
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$sqlcondition = ' left join ' . tablename('ewei_shop_goods_option') . ' op on g.id = op.goodsid';
			if ($merch_plugin) {
				$sqlcondition .= ' left join ' . tablename('ewei_shop_merch_user') . ' merch on merch.id = g.merchid and merch.uniacid=g.uniacid';
			}
			$groupcondition = ' group by g.`id`';
			$condition .= ' AND (g.`id` = :id or g.`title` LIKE :keyword or g.`keywords` LIKE :keyword or g.`goodssn` LIKE :keyword or g.`productsn` LIKE :keyword or op.`title` LIKE :keyword or op.`goodssn` LIKE :keyword or op.`productsn` LIKE :keyword';
			if ($merch_plugin) {
				$condition .= ' or merch.`merchname` LIKE :keyword';
			}
			$condition .= ' )';
			$params[':keyword'] = '%' . $_GPC['keyword'] . '%';
			$params[':id'] = $_GPC['keyword'];
		}
		if (!(empty($_GPC['cate']))) {
			$_GPC['cate'] = intval($_GPC['cate']);
			$condition .= ' AND FIND_IN_SET(' . $_GPC['cate'] . ',cates)<>0 ';
		}
		if (!(empty($_GPC['attribute']))) {
			if ($_GPC['attribute'] == 'new') {
				$condition .= ' AND `isnew`=1 ';
			} else if ($_GPC['attribute'] == 'hot') {
				$condition .= ' AND `ishot`=1 ';
			} else if ($_GPC['attribute'] == 'recommand') {
				$condition .= ' AND `isrecommand`=1 ';
			} else if ($_GPC['attribute'] == 'discount') {
				$condition .= ' AND `isdiscount`=1 ';
			} else if ($_GPC['attribute'] == 'time') {
				$condition .= ' AND `istime`=1 ';
			} else if ($_GPC['attribute'] == 'sendfree') {
				$condition .= ' AND `issendfree`=1 ';
			} else if ($_GPC['attribute'] == 'nodiscount') {
				$condition .= ' AND `isdiscount`=1 ';
			}
		}
		empty($goodsfrom) && ($_GPC['goodsfrom'] = $goodsfrom = 'sale');
		$_GPC['goodsfrom'] = $goodsfrom;
		if ($goodsfrom == 'sale') {
			$condition .= ' AND g.`status` > 0 and g.`checked`=0 and g.`total`>0 and g.`deleted`=0';
			$status = 1;
		} else if ($goodsfrom == 'out') {
			$condition .= ' AND g.`status` > 0 and g.`total` <= 0 and g.`deleted`=0 and g.type!=30';
			$status = 1;
		} else if ($goodsfrom == 'stock') {
			$status = 0;
			$condition .= ' AND (g.`status` = 0 or g.`checked`=1) and g.`deleted`=0';
		} else if ($goodsfrom == 'cycle') {
			$status = 0;
			$condition .= ' AND g.`deleted`=1';
		} else if ($goodsfrom == 'verify') {
			$status = 0;
			$condition .= ' AND g.`deleted`=0 and merchid>0 and checked=1';
		}
		$sql = 'SELECT g.id FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition;
		$total_all = pdo_fetchall($sql, $params);
		$total = count($total_all);
		unset($total_all);
		if (!(empty($total))) {
			$sql = 'SELECT g.* FROM ' . tablename('ewei_shop_goods') . 'g' . $sqlcondition . $condition . $groupcondition . ' ORDER BY g.`status` DESC, g.`displayorder` DESC,' . "\r\n" . '                g.`id` DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			$list = pdo_fetchall($sql, $params);
			foreach ($list as $key => &$value) {
				$value['allcates'] = explode(',', $value['cates']);
				$value['allcates'] = array_unique($value['allcates']);
				$url = mobileUrl('goods/detail', array('id' => $value['id']), true);
				$value['qrcode'] = m('qrcode')->createQrcode($url);
			}
			$pager = pagination2($total, $pindex, $psize);
			if ($merch_plugin) {
				$merch_user = $merch_plugin->getListUser($list, 'merch_user');
				if (!(empty($list)) && !(empty($merch_user))) {
					foreach ($list as &$row) {
						$row['merchname'] = (($merch_user[$row['merchid']]['merchname'] ? $merch_user[$row['merchid']]['merchname'] : $_W['shopset']['shop']['name']));
					}
				}
			}
		}
		$categorys = m('shop')->getFullCategory(true, true);
		$category = array();
		foreach ($categorys as $cate) {
			$category[$cate['id']] = $cate;
		}
		$goodstotal = intval($_W['shopset']['shop']['goodstotal']);
		$shopset = $_W['shopset']['shop'];
		// 门店列表
		$store_list = pdo_getall('ewei_shop_store', ['uid' => $_W['uid']]);
		include $this->template('purchase/good_list');
	}
}

?>
