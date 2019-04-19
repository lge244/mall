<?php
class Purchase_EweiShopV2Model{
	public function getList($args = array(), $shop_id = null)
	{
		global $_W;
		$openid = $_W['openid'];
		$page = ((!(empty($args['page'])) ? intval($args['page']) : 1));
		$pagesize = ((!(empty($args['pagesize'])) ? intval($args['pagesize']) : 10));
		$random = ((!(empty($args['random'])) ? $args['random'] : false));
		$order = ((!(empty($args['order'])) ? $args['order'] : ' displayorder desc,createtime desc'));
		$orderby = ((empty($args['order']) ? '' : ((!(empty($args['by'])) ? $args['by'] : ''))));
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch'])
		{
			$is_openmerch = 1;
		}
		else
		{
			$is_openmerch = 0;
		}
		$condition = ' and `uniacid` = :uniacid and `shop_id` = :shop_id AND `deleted` = 0 and status=1';
		$params = array(':uniacid' => $_W['uniacid'],':shop_id' => $shop_id);
		$merchid = ((!(empty($args['merchid'])) ? trim($args['merchid']) : ''));
		if (!(empty($merchid)))
		{
			$condition .= ' and merchid=:merchid and checked=0';
			$params[':merchid'] = $merchid;
		}
		else if ($is_openmerch == 0)
		{
			$condition .= ' and `merchid` = 0';
		}
		else
		{
			$condition .= ' and `checked` = 0';
		}
		$priceMin = ((!(empty($args['priceMin'])) ? trim($args['priceMin']) : ''));
		$priceMax = ((!(empty($args['priceMax'])) ? trim($args['priceMax']) : ''));
		if (!(empty($priceMin)))
		{
			$condition .= ' and minprice > \'' . $priceMin . '\'';
		}
		if (!(empty($priceMax)))
		{
			$condition .= ' and maxprice < \'' . $priceMax . '\'';
		}
		if (empty($args['type']))
		{
			$condition .= ' and type !=10 ';
		}
		$ids = ((!(empty($args['ids'])) ? trim($args['ids']) : ''));
		if (!(empty($ids)))
		{
			$condition .= ' and id in ( ' . $ids . ')';
		}
		$isnew = ((!(empty($args['isnew'])) ? 1 : 0));
		if (!(empty($isnew)))
		{
			$condition .= ' and isnew=1';
		}
		$ishot = ((!(empty($args['ishot'])) ? 1 : 0));
		if (!(empty($ishot)))
		{
			$condition .= ' and ishot=1';
		}
		$isrecommand = ((!(empty($args['isrecommand'])) ? 1 : 0));
		if (!(empty($isrecommand)))
		{
			$condition .= ' and isrecommand=1';
		}
		$isdiscount = ((!(empty($args['isdiscount'])) ? 1 : 0));
		if (!(empty($isdiscount)))
		{
			$condition .= ' and isdiscount=1';
		}
		$issendfree = ((!(empty($args['issendfree'])) ? 1 : 0));
		if (!(empty($issendfree)))
		{
			$condition .= ' and issendfree=1';
		}
		$istime = ((!(empty($args['istime'])) ? 1 : 0));
		if (!(empty($istime)))
		{
			$condition .= ' and istime=1 ';
		}
		if (isset($args['nocommission']))
		{
			$condition .= ' AND `nocommission`=' . intval($args['nocommission']);
		}
		$keywords = ((!(empty($args['keywords'])) ? $args['keywords'] : ''));
		if (!(empty($keywords)))
		{
			$condition .= ' AND (`title` LIKE :keywords OR `keywords` LIKE :keywords)';
			$params[':keywords'] = '%' . trim($keywords) . '%';
		}
		if (!(empty($args['cate'])))
		{
			$category = m('shop')->getAllCategory();
			$catearr = array($args['cate']);
			foreach ($category as $index => $row )
			{
				if ($row['parentid'] == $args['cate'])
				{
					$catearr[] = $row['id'];
					foreach ($category as $ind => $ro )
					{
						if ($ro['parentid'] == $row['id'])
						{
							$catearr[] = $ro['id'];
						}
					}
				}
			}
			$catearr = array_unique($catearr);
			$condition .= ' AND ( ';
			foreach ($catearr as $key => $value )
			{
				if ($key == 0)
				{
					$condition .= 'FIND_IN_SET(' . $value . ',cates)';
				}
				else
				{
					$condition .= ' || FIND_IN_SET(' . $value . ',cates)';
				}
			}
			$condition .= ' <>0 )';
		}
		$member = m('member')->getMember($openid);
		if (!(empty($member)))
		{
			$levelid = intval($member['level']);
			$groupid = intval($member['groupid']);
			$condition .= ' and ( ifnull(showlevels,\'\')=\'\' or FIND_IN_SET( ' . $levelid . ',showlevels)<>0 ) ';
			$condition .= ' and ( ifnull(showgroups,\'\')=\'\' or FIND_IN_SET( ' . $groupid . ',showgroups)<>0 ) ';
		}
		else
		{
			$condition .= ' and ifnull(showlevels,\'\')=\'\' ';
			$condition .= ' and ifnull(showgroups,\'\')=\'\' ';
		}
		$total = '';
		if (!($random))
		{
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_purchase') . ' where 1 ' . $condition . ' ORDER BY ' . $order . ' ' . $orderby . ' LIMIT ' . (($page - 1) * $pagesize) . ',' . $pagesize;
			$total = pdo_fetchcolumn('select count(*) from ' . tablename('ewei_shop_purchase') . ' where 1 ' . $condition . ' ', $params);
		}
		else
		{
			$sql = 'SELECT * FROM ' . tablename('ewei_shop_purchase')  . ' where 1 ' . $condition . ' ORDER BY rand() LIMIT ' . $pagesize;
			$total = $pagesize;
		}
		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'thumb');
		return array("list" => $list, 'total' => $total);
	}
}