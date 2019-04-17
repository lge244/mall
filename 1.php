<?php
$shopmenu = array(
    "admins" => array(
        "title" => "管理",
        "subtitle" => "管理员管理",
        "icon" => "store",
        "items" => array(
            array(
                "title" => "管理员",
                "extend" => "admins.list",
                "perm" => "amdins.main",
                "desc" => "管理员管理"
            ),
            array(
                "title" => "权限",
                "route" => "job",
                "desc" => "权限管理"
            )
        )
    ),

    "member" => array(
        "title" => "会员",
        "subtitle" => "会员管理",
        "icon" => "member",
        "items" => array(
            array(
                "title" => "会员列表",
                "route" => "list",
                "route_in" => true
            ),
            array(
                "title" => "会员等级",
                "route" => "level"
            ),
            array(
                "title" => "标签组",
                "route" => "group"
            )
        )),
    "order" => array(
        "title" => "订单",
        "subtitle" => "订单管理",
        "icon" => "order",
        "items" => array(
            array(
                "title" => "待发货",
                "route" => "list.status1",
                "desc" => "待发货订单管理"
            ),
            array(
                "title" => "待收货",
                "route" => "list.status2",
                "desc" => "待收货订单管理"
            ),
            array(
                "title" => "待付款",
                "route" => "list.status0",
                "desc" => "待付款订单管理"
            ),
            array(
                "title" => "已完成",
                "route" => "list.status3",
                "desc" => "已完成订单管理"
            ),
            array(
                "title" => "已关闭",
                "route" => "list.status_1",
                "desc" => "已关闭订单管理"
            ),
            array(
                "title" => "全部订单",
                "route" => "list",
                "desc" => "全部订单列表",
                "permmust" => "order.list.main"
            ),
            array(
                "title" => "维权",
                "route" => "list",
                "items" => array(
                    array(
                        "title" => "维权申请",
                        "route" => "status4",
                        "desc" => "维权申请管理"
                    ),
                    array(
                        "title" => "维权完成",
                        "route" => "status5",
                        "desc" => "维权完成管理"
                    )
                )
            ),
            array(
                "title" => "工具",
                "items" => array(
                    array(
                        "title" => "自定义导出",
                        "route" => "export",
                        "desc" => "订单自定义导出"
                    ),
                    array(
                        "title" => "批量发货",
                        "route" => "batchsend",
                        "desc" => "订单批量发货"
                    )
                )
            )
        )
    ),
    "store" => array(
        "title" => "门店",
        "subtitle" => "门店",
        "icon" => "mendianguanli",
        "items" => array(
            array(
                "title" => "门店管理",
                "items" => array(
                    array(
                        "title" => "门店管理",
                        "route" => "",
                        "extends" => array(
                            "store.diypage.settings",
                            "store.diypage.page",
                            "store.goods",
                            "store.goods.goodsoption"
                        )
                    ),
                    array(
                        "title" => "店员管理",
                        "route" => "saler"
                    ),
                    array(
                        "title" => "关键词设置",
                        "route" => "set"
                    )
                )
            ),
            array(
                "title" => "门店商品管理",
                "items" => array(
                    array(
                        "title" => "记次时商品管理",
                        "route" => "verifygoods",
                        "extends" => array(
                            "store.verifygoods.detail",
                            "store.verifygoods.verifygoodslog"
                        )
                    )
                )
            ),
            array(
                "title" => "记次时商品统计",
                "route" => "verify.log"
            ),
            array(
                "title" => "核销订单记录",
                "route" => "verifyorder.log"
            )
        )
    ),
    "statistics" => array(
        "title" => "数据",
        "subtitle" => "数据统计",
        "icon" => "statistics",
        "items" => array(
            array(
                "title" => "销售统计",
                "items" => array(
                    array(
                        "title" => "销售统计",
                        "route" => "sale"
                    ),
                    array(
                        "title" => "销售指标",
                        "route" => "sale_analysis"
                    ),
                    array(
                        "title" => "订单统计",
                        "route" => "order"
                    )
                )
            ),
            array(
                "title" => "商品统计",
                "items" => array(
                    array(
                        "title" => "销售明细",
                        "route" => "goods"
                    ),
                    array(
                        "title" => "销售排行",
                        "route" => "goods_rank"
                    ),
                    array(
                        "title" => "销售转化率",
                        "route" => "goods_trans"
                    )
                )
            ),
        )
    )
);

$shopmenu = array(

    "order" => array(
        "title" => "订单",
        "subtitle" => "订单管理",
        "icon" => "order",
        "items" => array(
            array(
                "title" => "订单",
                "route" => "list",
                "items" => array(
                    array(
                        "title" => "待付款",
                        "route" => "status4",
                        "desc" => "待付款订单管理"
                    ),
                    array(
                        "title" => "待发货",
                        "route" => "status5",
                        "desc" => "待发货订单管理"
                    ),
                    array(
                        "title" => "已完成",
                        "route" => "list.status3",
                        "desc" => "已完成订单管理"
                    )
                )
            ),
        ),
        "items" => array(
            array(
                "title" => "订单",
                "route" => "list",
                "items" => array(
                    array(
                        "title" => "待付款",
                        "route" => "status4",
                        "desc" => "待付款订单管理"
                    ),
                    array(
                        "title" => "待发货",
                        "route" => "status5",
                        "desc" => "待发货订单管理"
                    ),
                    array(
                        "title" => "已完成",
                        "route" => "list.status3",
                        "desc" => "已完成订单管理"
                    )
                )
            ),
        )
    )
);
<<<<<<< HEAD


$shopmenu = array(


    "store" => array(
        "title" => "门店",
        "subtitle" => "门店",
        "icon" => "mendianguanli",
        "items" => array(
            array(
                "title" => "门店管理",
                "items" => array(
                    array(
                        "title" => "门店管理",
                        "route" => "",
                        "extends" => array(
                            "store.diypage.settings",
                            "store.diypage.page",
                            "store.goods",
                            "store.goods.goodsoption"
                        )
                    ),
                    array(
                        "title" => "店员管理",
                        "route" => "saler"
                    ),
                    array(
                        "title" => "关键词设置",
                        "route" => "set"
                    )
                )
            ),
            array(
                "title" => "门店商品管理",
                "items" => array(
                    array(
                        "title" => "记次时商品管理",
                        "route" => "verifygoods",
                        "extends" => array(
                            "store.verifygoods.detail",
                            "store.verifygoods.verifygoodslog"
                        )
                    )
                )
            ),
            array(
                "title" => "记次时商品统计",
                "route" => "verify.log"
            ),
            array(
                "title" => "核销订单记录",
                "route" => "verifyorder.log"
            )
        )
    ),

);
=======
>>>>>>> 93d454d5ca66cd2cb2fa88d4e78fc4e49be8b7a3
