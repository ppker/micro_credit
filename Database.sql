CREATE TABLE if not exists `credit_card` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL DEFAULT '' COMMENT 'openid',
  `unionid` varchar(128) NOT NULL DEFAULT '' COMMENT 'unionid',
  `userid` int unsigned NOT NULL COMMENT 'userid',
  `bankId` smallint unsigned NOT NULL DEFAULT '0' COMMENT 'bankId',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(64) NOT NULL DEFAULT '' COMMENT '手机号',
  `idCard` varchar(24) NOT NULL DEFAULT '' COMMENT '身份证号',
  `channelSerial` char(21) NOT NULL DEFAULT '' COMMENT '流水号',
  `applyCompleted` char(6) NOT NULL DEFAULT '' COMMENT '进件标识;P：申请完成 D：申请未完成',
  `applyCompletedData` varchar(24) NOT NULL DEFAULT '' COMMENT '进件时间',
  `applicationStatus` char(6) NOT NULL DEFAULT '' COMMENT '核卡标识;P： 审批通过 D：审批失败',
  `applicationStatusDate` varchar(24) NOT NULL DEFAULT '' COMMENT '核卡时间',
  `isNewUser` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '是否二卡 0否 1 二卡,2 未知',
  `activated` char(6) NOT NULL DEFAULT '' COMMENT '激活标识;P：已激活 D：未激活',
  `activationDate` varchar(24) NOT NULL DEFAULT '' COMMENT '激活时间',
  `firstUsed` char(6) NOT NULL DEFAULT '' COMMENT '首刷标识;P：已首刷 D：未首刷',
  `firstUsedDate` varchar(24) NOT NULL DEFAULT '' COMMENT '首刷时间',
  `payment` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '0 => 未支付, 1 => 已支付',
  `mark` varchar(256) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `userid` (`userid`),
  KEY `name` (`name`),
  KEY `mobile` (`mobile`),
  KEY `idCard` (`idCard`),
  KEY `channelSerial` (`channelSerial`),
  KEY `update_at` (`update_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;





CREATE TABLE if not exists `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'openid',
  `nickname` varchar(24) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `sex` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '1 => 男, 2 => 女, 0 => 未知',
  `province` varchar(24) NOT NULL DEFAULT '' COMMENT '微信资料省份',
  `city` varchar(24) NOT NULL DEFAULT '' COMMENT '微信资料城市',
  `country` varchar(24) NOT NULL DEFAULT '' COMMENT '微信资料国家',
  `headimgurl` varchar(256) NOT NULL DEFAULT '' COMMENT '微信资料头像',
  `unionid` varchar(64) NOT NULL DEFAULT '' COMMENT '微信unionid',
  `top_invite_code` varchar(16) NOT NULL DEFAULT '' COMMENT '上线的邀请code',
  `invite_code` varchar(16) NOT NULL DEFAULT '' COMMENT '我的邀请code',
  `top_userid` int unsigned NOT NULL COMMENT '我的上线',
  `phone` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `real_name` varchar(16) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `idcard` char(18) NOT NULL DEFAULT '' COMMENT '身份证号',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT 'email',
  `status` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '0 => 正常, 1 => 禁封, 2 => 删除',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `real_name` (`real_name`),
  KEY `top_invite_code` (`top_invite_code`),
  KEY `invite_code` (`invite_code`),
  KEY `top_userid` (`top_userid`),
  KEY `update_at` (`update_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

create table if not exists `bank_bag` (
  `id` int unsigned not null auto_increment,
  `openid` varchar(64) not null default '' comment 'openid',
  `name` varchar(16) NOT NULL DEFAULT '' COMMENT '持卡人姓名',
  `card_num` varchar(24) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `bank_name` varchar(24) NOT NULL DEFAULT '' COMMENT '所属银行',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '银行卡预留手机号',
  `user_id` int unsigned not null COMMENT '用户id',
  `status` tinyint unsigned NOT NULL DEFAULT '0' COMMENT '0 => 正常, 1 => 禁封, 2 => 删除',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

### 订单价格表 暂时不用
create table if not exists `order_credit_price` (
  `id` bigint unsigned not null auto_increment,
  `channelSerial` char(21) NOT NULL DEFAULT '' COMMENT '流水号',
  `settle_type` varchar(24) NOT NULL DEFAULT '' COMMENT '结算标准，首刷，核卡，新户核卡+首刷',
  `money_one` decimal(8,0) unsigned not null default 0 comment '第一部分金额',
  `money_two` decimal(8,0) unsigned not null default 0 comment '第二部分金额',
  `money_late` decimal(8,0) unsigned not null default 0 comment '勉强完成最低金额',
  `over_sk_days` smallint unsigned NOT NULL DEFAULT '0' COMMENT '首刷最短天数',
  `mark` varchar(64) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `channelSerial` (`channelSerial`),
  KEY `update_at` (`update_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;


### 收入记录表
create table if not exists `user_earning` (
  `id` bigint unsigned not null auto_increment,
  `user_id` int unsigned NOT NULL default '0',
  `openid` varchar(64) not null default '' comment 'openid',
  `channelSerial` char(21) NOT NULL DEFAULT '' COMMENT '流水号',
  `settle_type` varchar(24) NOT NULL DEFAULT '' COMMENT '结算标准，首刷，核卡, 或者是其他奖励',
  `money_one` decimal(10,2) unsigned not null default "0.00" comment '佣金',
  `mark` varchar(64) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `channelSerial` (`channelSerial`),
  KEY `user_id` (`user_id`),
  KEY `update_at` (`update_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;


