DROP DATABASE IF EXISTS blogs;
CREATE DATABASE blogs;
USE blogs;

-- ---用户表---
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users
(
  uid           VARCHAR(36) NOT NULL comment 'UID',
  cnickname     VARCHAR(128) NOT NULL comment '昵称',
  cpassword     VARCHAR(32) NOT NULL comment '密码',
  cmobile       VARCHAR(11)  NOT NULL default ''  comment '手机号',
  cemail        VARCHAR(128) NOT NULL default '' COMMENT '邮箱',
  irole         INT(11) NOT NULL default 0  comment '角色',
  inoty         int(11) NOT NULL default 0 comment '接收消息数',
  iban          tinyint not null default 0 comment '是否封禁',
  ilast_login_time  INT(11) NOT NULL default 0 comment '上次登录时间',
  clast_login_ip   VARCHAR(15) NOT NULL default '' comment '上次登录IP',
  itime         INT(11) NOT NULL default 0,
  update_time timestamp not null default current_timestamp on update current_timestamp,
  primary key(uid)
)engine=innodb, default charset=utf8mb4;
ALTER TABLE users ADD  INDEX users_cnickname(cnickname);
ALTER TABLE users add cprovince varchar(64) not null default '' after cemail;
alter table users add ccity varchar(64) not null default '' after cprovince;
alter table users add caddress varchar(128) not null default '' comment '详细地址' after ccity;
alter table users add gender tinyint not null default 1 comment '性别：1：男，2：女' after cpassword ;

-- --博客文章表--
-- 状态：0：草稿，1：待发布，2：已发布
DROP TABLE IF EXISTS articles;
CREATE TABLE IF NOT EXISTS articles
(
  aid       varchar(36) not null comment 'ID',
  uid       varchar(36) not null comment '所属UID',

  ichannel  int(11) not null default 0 comment '频道',
  itype     int(11) not null default 0 comment '类别',

  ctitle    varchar(128) not null comment '标题',
  csubtitle varchar(128) not null default '' comment '副标题',
  cauthor   varchar(64)  not null default '' comment '作者',
  cabstract varchar(255) not null default '' comment '摘要',
  clogo     varchar(128) not null default '' comment '封面图',
  ccontent  text not null comment '内容',
  icollect  int(11) not null default 0 comment '收藏数',
  icomment  int(11) not null default 0 comment '评论数',
  idigs     int(11) not null default 0 comment '点赞数',
  ishow     tinyint not null default 0 comment '是否公开',
  istatus   int(11) not null default 0 comment '状态',
  itime     int not null default 0 comment '添加时间',
  update_time timestamp  not null default current_timestamp on update current_timestamp,
  primary key(aid)
)engine=innodb, default charset=utf8mb4;
alter table articles add index articles_ctitle(ctitle);
alter table articles add index articles_channel_type(ichannel, itype);
alter table articles add index articles_time(itime DESC);

-- ---标签---
DROP TABLE IF EXISTS tags;
CREATE TABLE IF NOT EXISTS tags
(
  id        int not null auto_increment,
  ctag_name varchar(64) not null comment '标签名称',
  itime     int not null default 0 comment '添加时间',
  update_time timestamp not null default current_timestamp on update current_timestamp,
  primary key(id)
)engine=innodb, default charset=utf8mb4;
alter table tags add unique index tags_name(ctag_name);
alter table tags add index tags_time(itime DESC);

DROP TABLE IF EXISTS article_tag;
CREATE TABLE IF NOT EXISTS article_tag
(
  aid       varchar(36) not null comment 'aid',
  tid       int not null comment '标签ID',
  ctag_name varchar(64) not null comment '标签名[冗余]',
  primary key(aid, tid)
)engine=innodb,default charset=utf8mb4;
alter table article_tag add index article_tag_name(ctag_name);