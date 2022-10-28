<?php

return [
    'wx' => [
        'mp' => [
            'app_id' => '',
            'secret' => '',
            'token' => '',
            'encodingAESKey' => '',
            'safeMode' => 0
        ],


        # 微信支付
        'payment'=>[
            'mch_id'        =>  '', # 商户ID
            'key'           =>  '', # 商户KEY
            'notify_url'    =>  '', # 支付通知地址
            'cert_path'     => '', # 证书
            'key_path'      => '', # 证书
        ],

        # web 授权
        'oauth' => [
            'scopes'   => 'snsapi_userinfo', # 授权范围
            'callback' => '', # 授权回调
        ],

    ],
    'bank_params' => [
        'aes_key' => '',
        'channelCode' => '',
    ],

    // 前端bank_id 后端bank_id 映射关系
    'api_server_bankid' => [
        '1' => '1',
        '2' => '1',
        '3' => '40',
        '4' => '40',
        '5' => '2',
        '6' => '54',
        '7' => '52',
        '8' => '52',
        '9' => '10',
        '10' => '11',
        '11' => '20',
        '12' => '19',
        '13' => '19',
        '14' => '52',
        '15' => '22',
        '16' => '25',
        '17' => '21',
        '18' => '35',
        '19' => '38',
        '20' => '18',
        '21' => '39',
    ],



    // 客户端展示bank_list
    'show_bank_list' => [
        0 => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行首刷版",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。<br>
            此行分两次发放首刷佣金<br>
            ①自申请之日起15天内完成首刷的，奖励260元；<br>②自申请之日起16天-30天内完成首刷的，奖励为120元；<br>③申请之日起超过30天未首刷的，不结算奖励。<br>【注】<br> **自申请之日起30天内未首刷视为订单未完成，不予发放奖励。<br>
                **首刷金额需大于10元  否则会影响结算<br>首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_feature' => '易审批高额度',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '首刷',
            'money_one' => 260,
            'money_two' => 0,
            'money_late' => 120,
            'over_sk_days' => 16, // 刷卡期限16天
            'api_bank_id' => "1",
            'show_money' => "260",
            'poster_url' => 'poster_bank_pinganyh.png',
        ],
        1 => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安核卡+首刷",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，并完成一笔消费算成功办理此业务。<br>资料审批通过收到短信通知后，结算奖励130元；<br>此行分两次发放首刷佣金<br>①自申请之日起15天内完成首刷的，奖励100元；<br>②自申请之日起16天-30天内完成首刷的，奖励为50元；<br>③申请之日起超过30天未首刷的，不结算首刷奖励.。<br>【注】<br>**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。<br>**首刷金额需大于10元   否则会影响结算<br>首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户核卡+首刷实时结算',
            'bank_feature' => '易审批高额度',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '新户核卡+首刷',
            'money_one' => 130,
            'money_two' => 100,
            'money_late' => 50,
            'over_sk_days' => 16, // 刷卡期限16天
            'api_bank_id' => "2",
            'show_money' => '130+100',
            'poster_url' => 'poster_bank_pinganyh.png',
        ],

        2 => [
            'icon_name' => 'bank_gdyh',
            'bankName' => "光大银行首刷版",
            'settlement_rule' => '新户首次申请光大银行信用卡，资料审批通过后前往网点面签激活卡片并完成一笔首刷，算成功办理此业务。<br>新户初审通过当天更新状态，首刷后3个工作日内更新结算。<br>【重要提醒】<br>1、申请时预留的手机号 必须完成实名认证，否则无法统计到业绩，将无法结算！<br>2、填写信息时务必检查信息填写正确且前后对应，三要素不匹配的订单将会转入【极客模式】（业务经理上门面签），转入【极客模式】的订单将不予结算<br>【光大长表单申请流程】：<br>1、进件：提交申卡信息<br>2、初审：系统审批，银行会向客户发送初审通过短信<br>3、面签：携带本人身份证前往任意网点完成面签（无客户经理上门面签）<br>4、终审：终审通过，银行将邮寄卡片<br>5、首刷：收到卡片后，在阳光惠生活APP或线下进行刷卡使用<br>【注】<br>新户初审通过当天更新状态，首刷后3个工作日内更新结算<br>**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_feature' => '实时结算',
            'bank_card' => 'bank_card_gdyh.jpeg',
            'credit_card_name' => '光大阳光UP无界信用卡',
            'settle_type' => '首刷',
            'money_one' => 240,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "3",
            'show_money' => '240',
            'poster_url' => 'poster_bank_guangdayh.png',
        ],

        3 => [
            'icon_name' => 'bank_gdyh',
            'bankName' => '光大初审+首刷',
            'settlement_rule' => '新户首次申请光大银行信用卡，初审通过后，携带身份证前往网点 进行激活卡片并完成一笔首刷算成功办理此业务。<br>【重要提醒】<br>1、申请时预留的手机号 必须完成实名认证，否则无法统计到业绩，将无法结算！<br>2、填写信息时务必检查信息填写正确且前后对应，三要素不匹配的订单将会转入【极客模式】（业务经理上门面签），转入【极客模式】的订单将不予结算<br>【光大长表单申请流程】：<br>1、进件：提交申卡信息<br>2、初审：系统审批，银行会向客户发送初审通过短信<br>3、面签：携带本人身份证前往任意网点完成面签（无客户经理上门面签）<br>4、终审：终审通过，银行将邮寄卡片<br>5、首刷：收到卡片后，在阳光惠生活APP或线下进行刷卡使用<br>【注】<br>新户初审通过当天更新状态，首刷后3天内更新<br>**自申请之日起30天内未首刷将视为订单未完成，不予结算首刷奖励',
            'settlement_cycle' => '新户初审+首刷实时结算',
            'bank_feature' => '长表模式',
            'bank_card' => 'bank_card_gdyh.jpeg',
            'credit_card_name' => '光大阳光UP无界信用卡',
            'settle_type' => '新户核卡+首刷',
            'money_one' => 80,
            'money_two' => 160,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "4",
            'show_money' => '80+160',
            'poster_url' => 'poster_bank_guangdayh.png',
        ],

        4 => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信核卡",
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。<br> 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！<br>***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '首刷送好礼',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中信银行京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "5",
            'show_money' => '110',
            'poster_url' => 'poster_bank_zhongxinyh.png',
        ],

        5 => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏核卡",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效<br>*华夏状态部分订单会转入二次审核<br>审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_feature' => '金卡待遇',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '核卡',
            'money_one' => 200,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "6",
            'show_money' => '200',
            'poster_url' => 'poster_bank_huaxiayh.png',
        ],

        6 => [
            'icon_name' => 'bank_msyh',
            'bankName' => "民生核卡",
            'settlement_rule' => '新户首次申请民生银行信用卡，资料审批通过收到核卡短信后算成功办理此业务。<br>**自申请之日起，30天内注销卡将扣除佣金',
            'settlement_cycle' => '新户核卡T+2结算',
            'bank_feature' => '首年免年费',
            'bank_card' => 'bank_card_msyh.jpeg',
            'credit_card_name' => '民生裕福白金卡',
            'settle_type' => '核卡',
            'money_one' => 80,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "7",
            'show_money' => '80',
            'poster_url' => 'poster_bank_huaxiayh.png', // 假数据
        ],

        7 => [
            'icon_name' => 'bank_nbyh',
            'bankName' => "宁波京东核卡",
            'settlement_rule' => '新户首次申请宁波银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【可申请区域】<br>上海、杭州、南京、深圳、苏州、北京、无锡、温州、金华、\n绍兴、台州、嘉兴、丽水、湖州、衢州、舟山、宁波',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '周周减宁波版',
            'bank_card' => 'bank_card_nbyh.png',
            'credit_card_name' => '宁波京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "8",
            'show_money' => '110',
            'poster_url' => 'poster_bank_huaxiayh.png', // 假数据
        ],

        8 => [
            'icon_name' => 'bank_njyh',
            'bankName' => "南京核卡",
            'settlement_rule' => '新户首次申请南京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放地区】：整个江苏省、杭州、北京、上海',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '秒批秒用',
            'bank_card' => 'bank_card_njyh.jpg',
            'credit_card_name' => '南京银行N Card 樊登读书',
            'settle_type' => '核卡',
            'money_one' => 100,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "9",
            'show_money' => '100',
            'poster_url' => 'poster_bank_nanjingyh.png',
        ],

        9 => [
            'icon_name' => 'bank_cayh',
            'bankName' => "长安银行核卡版",
            'settlement_rule' => '新户首次申请长安银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放地区】：陕西省',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '最高10万元额度',
            'bank_card' => 'bank_card_cayh.png',
            'credit_card_name' => '长安银行无界卡-嘹咋咧',
            'settle_type' => '核卡',
            'money_one' => 70,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "10",
            'show_money' => '70',
            'poster_url' => 'poster_bank_changanyh.png',
        ],

        10 => [
            'icon_name' => 'bank_hkyh',
            'bankName' => "汉口核卡",
            'settlement_rule' => '新户首次申请汉口银行信用卡，资料审批通过后收到下卡短信算成功办理此业务。',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '最高10万元额度',
            'bank_card' => 'bank_card_hkyh.jpeg',
            'credit_card_name' => '汉口京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "11",
            'show_money' => '110',
            'poster_url' => 'poster_bank_hankouyh.png',
        ],

        11 => [
            'icon_name' => 'bank_yzyh',
            'bankName' => "邮政核卡",
            'settlement_rule' => '新户首次申请邮政银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放地区】仅限上海地区办理',
            'settlement_cycle' => '新户核卡每周三结算',
            'bank_feature' => '卡种多  权益多',
            'bank_card' => 'bank_card_yzyh.jpeg',
            'credit_card_name' => '邮政银行信用卡',
            'settle_type' => '核卡',
            'money_one' => 40,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "12",
            'show_money' => '40',
            'poster_url' => 'poster_bank_youzhengyh.png',
        ],

        12 => [
            'icon_name' => 'bank_hfyh',
            'bankName' => "恒丰核卡",
            'settlement_rule' => '新户首次申请恒丰银行信用卡，资料审批通过收到核卡短信成功办理此业务。',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '额度最高100万',
            'bank_card' => 'bank_card_hfyh.png',
            'credit_card_name' => '恒丰京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "13",
            'show_money' => '110',
            'poster_url' => 'poster_bank_hengfengyh.png',
        ],

        13 => [
            'icon_name' => 'bank_msyh',
            'bankName' => "民生银行激活版",
            'settlement_rule' => '新户首次申请民生银行信用卡，资料审批通过收到核卡短信后到银行网点面签激活卡片算成功办理此业务。<br>【注】**自申请之日起超30天未激活视为订单未完成，不予结算激活佣金',
            'settlement_cycle' => '新户激活T+2结算',
            'bank_feature' => '首年免年费',
            'bank_card' => 'bank_card_msyh.jpeg',
            'credit_card_name' => '民生裕福白金卡',
            'settle_type' => '激活',
            'money_one' => 120,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "14",
            'show_money' => '120',
            'poster_url' => 'poster_bank_huaxiayh.png', // 假数据
        ],

        14 => [
            'icon_name' => 'bank_bhyh',
            'bankName' => "渤海银行激活版",
            'settlement_rule' => '新户首次申请渤海银行信用卡，资料审批通过收到核卡短信后激活卡片算成功办理此业务。<br>【注】<br>**自申请之日起30天内未激活视为订单未完成，不予发放奖励。<br>**自申请之日起90天内注销卡将扣除佣金。',
            'settlement_cycle' => '新户激活每周一结算',
            'bank_feature' => '终身免年费',
            'bank_card' => 'bank_card_bhyh.png',
            'credit_card_name' => '渤海银行51信用卡',
            'settle_type' => '激活',
            'money_one' => 220,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "15",
            'show_money' => '220',
            'poster_url' => 'poster_bank_bohaiyh.png',
        ],

        15 => [
            'icon_name' => 'bank_sjyh',
            'bankName' => "盛京核卡",
            'settlement_rule' => '新户首次申请盛京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放地区】：上海， 北京，吉林，天津，长春市，辽宁省沈阳，大连，鞍山，抚顺，本溪，丹东，锦州，葫芦岛，营口，盘锦，阜新，辽阳，朝阳，铁岭<br>【注】<br>**自申请之日起30天内注销卡将扣除佣金',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '14:1超值累积比例',
            'bank_card' => 'bank_card_sjyh.png',
            'credit_card_name' => '盛京海航联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "16",
            'show_money' => '110',
            'poster_url' => 'poster_bank_shengjingyh.png',
        ],

        16 => [
            'icon_name' => 'bank_bbwyh',
            'bankName' => "北部湾核卡",
            'settlement_rule' => '新户首次申请北部湾银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放地区】：广西全省<br>【特别注意】<br>来宾市无网点，请勿开展北行卡发卡业务<br>禁止办卡代送POS机<br>必须为客户本人申请',
            'settlement_cycle' => '新户核卡T+3结算',
            'bank_feature' => '新户送支付红包',
            'bank_card' => 'bank_card_bbwyh.jpeg',
            'credit_card_name' => '北部湾基础金卡',
            'settle_type' => '核卡',
            'money_one' => 80,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "17",
            'show_money' => '80',
            'poster_url' => 'poster_bank_beibuwaiyh.png',
        ],

        17 => [
            'icon_name' => 'bank_jinsyh',
            'bankName' => "晋商银行核卡版",
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_feature' => '首刷有礼，高颜值',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '晋商京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "18",
            'show_money' => '110',
            'poster_url' => 'poster_bank_jinshangyh.png',
        ],

        18 => [
            'icon_name' => 'bank_jxyh',
            'bankName' => "江西银行核卡版",
            'settlement_rule' => '新户首次申请江西银行信用卡，资料审批通过后收到核卡短信算成功办理此业务。',
            'settlement_cycle' => '新户核卡每周二结算',
            'bank_feature' => '热门IP',
            'bank_card' => 'bank_card_jxyh.png',
            'credit_card_name' => '江西云闪付联名卡',
            'settle_type' => '核卡',
            'money_one' => 60,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "19",
            'show_money' => '60',
            'poster_url' => 'poster_bank_jiangxiyh.png',
        ],

        19 => [
            'icon_name' => 'bank_csyh',
            'bankName' => "长沙核卡",
            'settlement_rule' => '新户首次申请长沙农商银行信用卡，资料审批通过后，算成功办理此业务',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '极速审批',
            'bank_card' => 'bank_card_csyh.png',
            'credit_card_name' => '长沙京东联名卡',
            'settle_type' => '核卡',
            'money_one' => 110,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "20",
            'show_money' => '110',
            'poster_url' => 'poster_bank_changshayh.png',
        ],

        20 => [
            'icon_name' => 'bank_jsyh',
            'bankName' => "建设核卡",
            'settlement_rule' => '新户首次申请建设银行信用卡，资料审批通过收到核卡短信算成功办理此业务。<br>【特别注意】<br>禁止假冒银行工作人员<br>禁止在客户不知情的情况下代客户填写申卡信息<br>禁止承诺礼品不兑现引发投诉<br>禁止搭售pos机',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_feature' => '购票获赠优惠券',
            'bank_card' => 'bank_card_jsyh.png',
            'credit_card_name' => '建设银行春秋龙卡',
            'settle_type' => '核卡',
            'money_one' => 40,
            'money_two' => 0,
            'money_late' => 0,
            'over_sk_days' => 0, // 刷卡期限16天
            'api_bank_id' => "21",
            'show_money' => '40',
            'poster_url' => 'poster_bank_jiansheyh.png',
        ],

    ],


    'bank_icon' => [
        '1' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。<br>
            此行分两次发放首刷佣金<br>
            ①自申请之日起15天内完成首刷的，奖励260元；<br>②自申请之日起16天-30天内完成首刷的，奖励为120元；<br>③申请之日起超过30天未首刷的，不结算奖励。<br>【注】<br> **自申请之日起30天内未首刷视为订单未完成，不予发放奖励。<br>
                **首刷金额需大于10元  否则会影响结算<br>首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '首刷',
            'money_one' => 260,
            'money_two' => 0,
            'money_late' => 120,
            'over_sk_days' => 16, // 刷卡期限16天

        ],
        '2' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信银行",
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中信银行京东联名卡',
            'settle_type' => '核卡+激活+首刷',
        ],
        '4' => [
            'icon_name' => 'bank_gdyh',
            'bankName' => "光大银行",
            'settlement_rule' => '新户首次申请光大银行信用卡，资料审批通过后前往网点面签激活卡片并完成一笔首刷，算成功办理此业务。\n新户初审通过当天更新状态，首刷后3个工作日内更新结算。\n【重要提醒】\n1、申请时预留的手机号 必须完成实名认证，否则无法统计到业绩，将无法结算！\n2、填写信息时务必检查信息填写正确且前后对应，三要素不匹配的订单将会转入【极客模式】（业务经理上门面签），转入【极客模式】的订单将不予结算\n\n【光大长表单申请流程】：\n1、进件：提交申卡信息\n2、初审：系统审批，银行会向客户发送初审通过短信\n3、面签：携带本人身份证前往任意网点完成面签（无客户经理上门面签）\n4、终审：终审通过，银行将邮寄卡片\n5、首刷：收到卡片后，在阳光惠生活APP或线下进行刷卡使用\n\n\n【注】\n新户初审通过当天更新状态，首刷后3个工作日内更新结算\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_gdyh.jpeg',
            'credit_card_name' => '光大阳光UP无界信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '5' => [
            'icon_name' => 'bank_pahk',
            'bankName' => "平安核卡",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，并完成一笔消费算成功办理此业务。\n资料审批通过收到短信通知后，结算奖励130元；\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励100元；\n②自申请之日起16天-30天内完成首刷的，奖励为50元；\n③申请之日起超过30天未首刷的，不结算首刷奖励.。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户核卡+首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '6' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安首刷",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '首刷',
        ],
        '8' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '首刷',
        ],
        '10' => [
            'icon_name' => 'bank_njyh',
            'bankName' => "南京银行",
            'settlement_rule' => '新户首次申请南京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：整个江苏省、杭州、北京、上海\n',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_njyh.jpg',
            'credit_card_name' => '南京银行N Card 樊登读书',
            'settle_type' => '首刷',
        ],
        '11' => [
            'icon_name' => 'bank_cayh',
            'bankName' => "长安银行",
            'settlement_rule' => '新户首次申请长安银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：陕西省',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_cayh.png',
            'credit_card_name' => '长安银行无界卡-嘹咋咧',
            'settle_type' => '核卡',
        ],
        '12' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '核卡',
        ],
        '13' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "中原银行全卡", // 假数据
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '中原银行信用卡',
            'settle_type' => '核卡',
        ],
        '14' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信首刷",
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中信银行京东联名卡',
            'settle_type' => '核卡',
        ],
        '15' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '核卡',
        ],
        '17' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "广发银行激活版", // 假数据
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '广发银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '18' => [
            'icon_name' => 'bank_csyh',
            'bankName' => "长沙银行",
            'settlement_rule' => '新户首次申请长沙农商银行信用卡，资料审批通过后，算成功办理此业务',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_csyh.png',
            'credit_card_name' => '长沙京东联名卡',
            'settle_type' => '核卡+首刷',
        ],
        '19' => [
            'icon_name' => 'bank_yzyh',
            'bankName' => "邮政银行",
            'settlement_rule' => '新户首次申请邮政银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【有效投放地区】仅限上海地区办理',
            'settlement_cycle' => '新户核卡每周三结算',
            'bank_card' => 'bank_card_yzyh.jpeg',
            'credit_card_name' => '邮政银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '20' => [
            'icon_name' => 'bank_hkyh',
            'bankName' => "汉口银行",
            'settlement_rule' => '新户首次申请汉口银行信用卡，资料审批通过后收到下卡短信算成功办理此业务。',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_hkyh.jpeg',
            'credit_card_name' => '汉口京东联名卡',
            'settle_type' => '核卡+首刷',
        ],
        '21' => [
            'icon_name' => 'bank_bbwyh',
            'bankName' => "北部湾银行",
            'settlement_rule' => '新户首次申请北部湾银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：广西全省\n\n【特别注意】\n来宾市无网点，请勿开展北行卡发卡业务\n禁止办卡代送POS机\n必须为客户本人申请\n\n',
            'settlement_cycle' => '新户核卡T+3结算',
            'bank_card' => 'bank_card_bbwyh.jpeg',
            'credit_card_name' => '北部湾基础金卡',
            'settle_type' => '核卡+首刷',
        ],
        '22' => [
            'icon_name' => 'bank_bhyh',
            'bankName' => "渤海激活",
            'settlement_rule' => '新户首次申请渤海银行信用卡，资料审批通过收到核卡短信后激活卡片算成功办理此业务。\n\n【注】\n**自申请之日起30天内未激活视为订单未完成，不予发放奖励。\n**自申请之日起90天内注销卡将扣除佣金。',
            'settlement_cycle' => '新户激活每周一结算',
            'bank_card' => 'bank_card_bhyh.png',
            'credit_card_name' => '渤海银行51信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '23' => [
            'icon_name' => 'bank_gzyh',
            'bankName' => "广州银行",
            'settlement_rule' => '新户首次申请广州银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【有效投放地区】：广州、深圳、东莞、佛山、清远、珠海、肇庆、江门、惠州、中山、汕头，韶关',
            'settlement_cycle' => '新户核卡每周五结算',
            'bank_card' => 'bank_card_gzyh.png',
            'credit_card_name' => '广银银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '24' => [
            'icon_name' => 'bank_tjyh',
            'bankName' => "天津银行",
            'settlement_rule' => '新户首次申请天津银行信用卡，资料审批通过收到核卡短信算成功办理此业务。',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_tjyh.png',
            'credit_card_name' => '天津京东PLUS联名信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '25' => [
            'icon_name' => 'bank_sjyh',
            'bankName' => "盛京银行",
            'settlement_rule' => '新户首次申请盛京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：上海， 北京，吉林，天津，长春市，辽宁省沈阳，大连，鞍山，抚顺，本溪，丹东，锦州，葫芦岛，营口，盘锦，阜新，辽阳，朝阳，铁岭\n\n【注】\n**自申请之日起30天内注销卡将扣除佣金',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_sjyh.png',
            'credit_card_name' => '盛京海航联名卡',
            'settle_type' => '核卡+首刷',
        ],
        '26' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "兴业激活", // 假数据
            'settlement_rule' => '新户首次申请盛京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：上海， 北京，吉林，天津，长春市，辽宁省沈阳，大连，鞍山，抚顺，本溪，丹东，锦州，葫芦岛，营口，盘锦，阜新，辽阳，朝阳，铁岭\n\n【注】\n**自申请之日起30天内注销卡将扣除佣金',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_sjyh.png',
            'credit_card_name' => '兴业银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '27' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "兴业首刷", // 假数据
            'settlement_rule' => '新户首次申请盛京银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放地区】：上海， 北京，吉林，天津，长春市，辽宁省沈阳，大连，鞍山，抚顺，本溪，丹东，锦州，葫芦岛，营口，盘锦，阜新，辽阳，朝阳，铁岭\n\n【注】\n**自申请之日起30天内注销卡将扣除佣金',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_sjyh.png',
            'credit_card_name' => '兴业银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '28' => [
            'icon_name' => 'bank_shyh',
            'bankName' => "上海核卡+首刷",
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '上海银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '29' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "深圳农商", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '深圳农商银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '30' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "锦州银行", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '锦州银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '31' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "郑州银行", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '郑州银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        '32' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "杭州银行", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '杭州银行信用卡',
            'settle_type' => '核卡+首刷',
        ],
        
        '33' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "山西农信", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '山西农信银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '34' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "甘肃银行", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '甘肃银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '31' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "郑州银行", // 假数据
            'settlement_rule' => '新户首次申请上海银行信用卡，审核通过后，收到核卡短信通知，激活卡片后完成一笔首刷消费，算成功办理此业务。\n【有效投放地区】上海、南京、苏州、无锡、常州、南通、杭州、宁波、绍兴、天津、成都、深圳、温州',
            'settlement_cycle' => '新户首刷每周二结算',
            'bank_card' => 'bank_card_shyh.jpeg',
            'credit_card_name' => '郑州银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '35' => [
            'icon_name' => 'bank_jinsyh',
            'bankName' => "晋商银行",
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市\n',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '晋商京东联名卡',
            'settle_type' => '核卡+首刷',
        ],

        '36' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "黄河农商", // 假数据
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市\n',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '黄河农商银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '37' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "齐鲁激活", // 假数据
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市\n',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '齐鲁银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '38' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "江西银行", // 假数据
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市\n',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '江西银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '39' => [
            'icon_name' => 'bank_jsyh',
            'bankName' => "建设银行", // 假数据
            'settlement_rule' => '新户首次申请晋商银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n\n【有效投放区域】太原市/大同市/阳泉市/长治市/晋城市/晋中市/运城市/临汾市/吕梁市/忻州市/朔州市\n',
            'settlement_cycle' => '新户核卡每T+1结算',
            'bank_card' => 'bank_card_jinsyh.png',
            'credit_card_name' => '建设银行春秋龙卡',
            'settle_type' => '核卡+首刷',
        ],

        '40' => [
            'icon_name' => 'bank_gdyh',
            'bankName' => "光大银行",
            'settlement_rule' => '新户首次申请光大银行信用卡，资料审批通过后前往网点面签激活卡片并完成一笔首刷，算成功办理此业务。\n新户初审通过当天更新状态，首刷后3个工作日内更新结算。\n【重要提醒】\n1、申请时预留的手机号 必须完成实名认证，否则无法统计到业绩，将无法结算！\n2、填写信息时务必检查信息填写正确且前后对应，三要素不匹配的订单将会转入【极客模式】（业务经理上门面签），转入【极客模式】的订单将不予结算\n\n【光大长表单申请流程】：\n1、进件：提交申卡信息\n2、初审：系统审批，银行会向客户发送初审通过短信\n3、面签：携带本人身份证前往任意网点完成面签（无客户经理上门面签）\n4、终审：终审通过，银行将邮寄卡片\n5、首刷：收到卡片后，在阳光惠生活APP或线下进行刷卡使用\n\n\n【注】\n新户初审通过当天更新状态，首刷后3个工作日内更新结算\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_gdyh.jpeg',
            'credit_card_name' => '光大阳光UP无界信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '41' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信核卡",
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中信银行京东联名卡',
            'settle_type' => '核卡+首刷',
        ],

        '42' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏银行",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '43' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => "华夏海航联名信用卡",
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏海航联名信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '44' => [
            'icon_name' => 'bank_jsyh',
            'bankName' => "建设银行", // 假数据
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '建设银行春秋龙卡',
            'settle_type' => '核卡+首刷',
        ],

        '45' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "浦发银行", // 假数据
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '浦发银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '46' => [
            'icon_name' => 'bank_zxyh',
            'bankName' => "中信首刷",
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中信银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '48' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "中原京东", // 假数据
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '中原京东联名卡',
            'settle_type' => '核卡+首刷',
        ],

        '49' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '50' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '51' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "平安银行",
            'settlement_rule' => '新户首次申请平安银行信用卡，资料审批通过收到核卡短信后激活卡片，完成一笔消费算成功办理此业务。\n此行分两次发放首刷佣金\n①自申请之日起15天内完成首刷的，奖励260元；\n②自申请之日起16天-30天内完成首刷的，奖励为120元；\n③申请之日起超过30天未首刷的，不结算奖励。\n\n【注】\n**自申请之日起30天内未首刷视为订单未完成，不予发放奖励。\n**首刷金额需大于10元   否则会影响结算\n首刷数据1-3个工作日内返回',
            'settlement_cycle' => '新户首刷实时结算',
            'bank_card' => 'bank_card_zgpa.jpeg',
            'credit_card_name' => '平安银行信用卡',
            'settle_type' => '核卡+首刷',
        ],

        '52' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "民生核卡", // 假数据
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '民生裕福白金卡',
            'settle_type' => '核卡+首刷',
        ],

        '53' => [
            'icon_name' => 'bank_zgpa',
            'bankName' => "民生激活", // 假数据
            'settlement_rule' => '新户首次首次申请中信信用卡，资料审批通过后收到核卡短信算成功办理此业务。\n 银行严厉禁止客户经理换卡，换卡后无法结算！请注意引导客户，避免造成不必要的损失！\n***60天内注销卡片奖励佣金收回',
            'settlement_cycle' => '新户核卡T+1结算',
            'bank_card' => 'bank_card_zxyh.png',
            'credit_card_name' => '民生裕福白金卡',
            'settle_type' => '核卡+首刷',
        ],

        '54' => [
            'icon_name' => 'bank_hxyh',
            'bankName' => '华夏银行',
            'settlement_rule' => '新户首次申请华夏银行信用卡，资料审批通过收到核卡短信算成功办理此业务。\n【注意】*为避免影响结算，在填写信息过程中请勿退出页面，退出后重新填写将导致订单信息失效\n*华夏状态部分订单会转入二次审核\n审核数据 三天左右返回，状态会自动更新（非工作日自动顺延）',
            'settlement_cycle' => '新户核卡实时结算',
            'bank_card' => 'bank_card_hxyh.jpeg',
            'credit_card_name' => '华夏银行信用卡',
            'settle_type' => '核卡+首刷',
        ]
    ]


];