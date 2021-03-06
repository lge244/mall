<?php
//新\9睿z\社\d区/j修\/复/\自定义表单
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Category_EweiShopV2Page extends PluginWebPage
{
	public function main()
	{
		global $_W;
		global $_GPC;

		if (!empty($_GPC['catname'])) {
			ca('diyform.job.edit');

			foreach ($_GPC['catname'] as $id => $catname) {
				$catname = trim($catname);

				if (empty($catname)) {
					continue;
				}

				if ($id == 'new') {
					pdo_insert('ewei_shop_diyform_category', array('name' => $catname, 'uniacid' => $_W['uniacid']));
					$insert_id = pdo_insertid();
					plog('diyform.job.add', '添加自定义表单分类 ID: ' . $insert_id);
				}
				else {
					pdo_update('ewei_shop_diyform_category', array('name' => $catname), array('id' => $id));
					plog('diyform.job.edit', '修改自定义表单分类 ID: ' . $id);
				}
			}

			plog('diyform.job.edit', '批量修改分类');
			show_json(1, array('url' => webUrl('diyform/job')));
		}

		$list = pdo_fetchall('SELECT * FROM ' . tablename('ewei_shop_diyform_category') . (' WHERE uniacid = \'' . $_W['uniacid'] . '\' ORDER BY id DESC'));
		include $this->template();
	}

	public function delete()
	{
		global $_W;
		global $_GPC;
		$id = intval($_GPC['id']);
		$item = pdo_fetch('SELECT id,name FROM ' . tablename('ewei_shop_diyform_category') . (' WHERE id = \'' . $id . '\' AND uniacid=') . $_W['uniacid'] . '');

		if (empty($item)) {
			$this->message('抱歉，分类不存在或是已经被删除！', webUrl('diyform/job', array('op' => 'display')), 'error');
		}

		pdo_delete('ewei_shop_diyform_category', array('id' => $id));
		plog('diyform.job.delete', '删除分类 ID: ' . $id . ' 标题: ' . $item['name'] . ' ');
		show_json(1, array('url' => webUrl('diyform/job', array('op' => 'display'))));
	}
}

?>
