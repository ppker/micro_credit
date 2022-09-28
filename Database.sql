create table if not exists `credit_card` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `openid` varchar(128) NOT NULL DEFAULT '' COMMENT 'openid',
  `unionid` varchar(128) NOT NULL DEFAULT '' COMMENT 'unionid',
  `bankId` smallint unsigned NOT NULL DEFAULT '0' COMMENT 'bankId',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '姓名',
  `mobile` varchar(64) NOT NULL DEFAULT '' COMMENT '手机号',
  `idCard` varchar(24) NOT NULL DEFAULT '' COMMENT '身份证号',
  `channelSerial` bigint unsigned NOT NULL DEFAULT '0' COMMENT '流水号',
  `applyCompleted` char(3) NOT NULL DEFAULT '' COMMENT '进件标识;P：申请完成 D：申请未完成',
  `applyCompletedData` varchar(24) NOT NULL DEFAULT '' COMMENT '进件时间',
  `applicationStatus` char(3) NOT NULL DEFAULT '' COMMENT '核卡标识;P： 审批通过 D：审批失败',
  `applicationStatusDate` varchar(24) NOT NULL DEFAULT '' COMMENT '核卡时间',
  `isNewUser` tinyint unsigned NOT NULL DEFAULT '2' COMMENT '是否二卡 0否 1 二卡,2 未知',
  `activated` char(3) NOT NULL DEFAULT '' COMMENT '激活标识;P：已激活 D：未激活',
  `activationDate` varchar(24) NOT NULL DEFAULT '' COMMENT '激活时间',
  `firstUsed` char(3) NOT NULL DEFAULT '' COMMENT '首刷标识;P：已首刷 D：未首刷',
  `firstUsedDate` varchar(24) NOT NULL DEFAULT '' COMMENT '首刷时间',
  `mark` varchar(256) NOT NULL DEFAULT '' COMMENT '备注',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `openid` (`openid`),
  KEY `name` (`name`),
  KEY `mobile` (`mobile`),
  KEY `idCard` (`idCard`),
  KEY `channelSerial` (`channelSerial`),
  KEY `update_at` (`update_at`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;