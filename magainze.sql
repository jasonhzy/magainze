-- author Jason Hu
-- since: 2014/03/26

-- database: `magainze`
CREATE DATABASE `magainze`;
USE `magainze`;
-- 
-- table: `admin_users`
-- 
CREATE TABLE admin_users (
	user_uid VARCHAR(32) NOT NULL PRIMARY KEY,
	username VARCHAR(32) NOT NULL,
	password CHAR(50) NOT NULL,
	pwd_text CHAR(50) NOT NULL,
	salt VARCHAR(10) DEFAULT '',
	name VARCHAR(50) NOT NULL DEFAULT '',
	sex BIT DEFAULT '0',
	email VARCHAR(30) NOT NULL DEFAULT '',
	phone VARCHAR(20) NOT NULL DEFAULT '',
	fax VARCHAR(20) NOT NULL DEFAULT '',
	join_time INT,
	last_login INT,
	login_num  INT,
	super BIT DEFAULT '0',
	ip varchar(15) NOT NULL DEFAULT ''
);

INSERT INTO admin_users(user_uid, username, password, pwd_text, salt, name, sex, email, phone, fax, join_time, last_login, login_num, super) 
VALUES('00000000000000000000000000000001', 'admin', '32b7ce946763c92e03d8ce9b8148d57e', 'password', '9eh7b4', 'admin', '', '', '', '', 1395804517, 1395804517, 0, '1');

CREATE TABLE magainze_menu (
  menu_id varchar(32) NOT NULL PRIMARY KEY ,
  menu_title VARCHAR(50) NOT NULL,
  menu_url VARCHAR(50) NOT NULL DEFAULT '',
  parent VARCHAR(20) DEFAULT '',
  is_used bit DEFAULT 0,  -- 0 is used 1 no used 
  position INT,
  remark TEXT DEFAULT ''
);
-- home
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_HOME', '首页', 'admin/main/left', '/', 0, 1, '常用操作') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_HOME_WELCOME', '欢迎页面', 'admin/main/right', 'MENU_HOME', 0, 1, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_HOME_MEMBER', '会员列表', 'admin/member/common_member', 'MENU_HOME', 0, 2, '') ;
-- member
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MEMBER', '会员管理', 'admin/main/left', '/', 0, 2, '会员管理') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MEMBER_LIST', '会员列表', 'admin/member/common_member', 'MENU_MEMBER', 0, 1, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MEMBER_ADMIN', '管理员列表', 'admin/member/super_member', 'MENU_MEMBER', 0, 2, '') ;
-- magainze
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MAGAINZE', '杂志管理', 'admin/main/left', '/', 0, 3, '杂志管理') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MAGAINZE_LIST', '杂志管理', 'admin/magainze/index', 'MENU_MAGAINZE', 0, 1, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MAGAINZE_VERIFY', '杂志审核', 'admin/magainze/verify', 'MENU_MAGAINZE', 0, 2, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_MAGAINZE_PUBLISH', '杂志发布', 'admin/magainze/publish', 'MENU_MAGAINZE', 0, 3, '') ;
-- article
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_ARTICLE', '文章管理', 'admin/main/left', '/', 0, 4, '文章管理') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_ARTICLE_LIST', '文章管理', 'admin/article/index', 'MENU_ARTICLE', 0, 1, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_ARTICLE_VERIFY', '文章审核', 'admin/article/verify', 'MENU_ARTICLE', 0, 2, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_ARTICLE_PUBLISH', '文章发布', 'admin/article/publish', 'MENU_ARTICLE', 0, 3, '') ;

-- system
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_SYSTEM', '系统设置', 'admin/main/left', '/', 0, 5, '系统设置') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_SYSTEM_SETTING', '网站设置', 'admin/system/sys_info', 'MENU_SYSTEM', 0, 1, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_SYSTEM_TEMPLATE', '模板编辑', 'admin/system/sys_temp', 'MENU_SYSTEM', 0, 2, '') ;
INSERT INTO magainze_menu(menu_id, menu_title, menu_url, parent, is_used, position, remark) 
VALUES('MENU_SYSTEM_BANNER', '首页Banner', 'admin/system/sys_banner', 'MENU_SYSTEM', 0, 3, '') ;

-- article_category
CREATE TABLE article_category(
   id VARCHAR(32) NOT NULL PRIMARY KEY,
   name VARCHAR(20) NOT NULL,
   position INT DEFAULT 0,
   remark TEXT DEFAULT ''
)

insert into article_category(id, name, position, remark) values('category_contents', '目录', 1, '');
insert into article_category(id, name, position, remark) values('category_teachersay', '师说', 2, '');
insert into article_category(id, name, position, remark) values('category_master', '大师', 3, '');
insert into article_category(id, name, position, remark) values('category_walker', '行者', 4, '');
insert into article_category(id, name, position, remark) values('category_observation', '观察', 5, '');
insert into article_category(id, name, position, remark) values('category_thing', '叙事', 6, '');
insert into article_category(id, name, position, remark) values('category_method', '方法', 7, '');
insert into article_category(id, name, position, remark) values('category_class', '课堂', 8, '');
insert into article_category(id, name, position, remark) values('category_sound', '声音', 9, '');
insert into article_category(id, name, position, remark) values('category_read', '读书', 10, '');


-- magainze
CREATE TABLE magainze(
   id VARCHAR(32) NOT NULL PRIMARY KEY,
   name VARCHAR(50) NOT NULL,
   cover_url VARCHAR(100) NOT NULL,
   is_recommend char(1) DEFAULT 0, -- 0 不推荐 1 推荐
   is_verify char(1) DEFAULT 0,  -- 0 未审核 1 通过 2 未通过
   is_publish char(1) DEFAULT 0,  -- 0 屏蔽 1 发布
   join_time INT,
   position INT DEFAULT 0,
   status BIT DEFAULT '1',
   remark TEXT DEFAULT ''
)
-- magainze_article
CREATE TABLE magainze_article(
   id VARCHAR(32) NOT NULL PRIMARY KEY,
   magainze_id VARCHAR(32) NOT NULL,
   article_id VARCHAR(32) NOT NULL
)

-- article
CREATE TABLE article(
   id VARCHAR(32) NOT NULL PRIMARY KEY,
   name VARCHAR(100) NOT NULL DEFAULT '',
   category VARCHAR(32) NOT NULL DEFAULT '',
   heading VARCHAR(100) NOT NULL DEFAULT '',
   subheading VARCHAR(100) NOT NULL DEFAULT '',
   author VARCHAR(50) NOT NULL DEFAULT '',
   keywords VARCHAR(100) NOT NULL DEFAULT '',
   content text NOT NULL,
   image_url VARCHAR(100) NOT NULL DEFAULT '',
   bg_url VARCHAR(100) NOT NULL DEFAULT '',
   is_recommend char(1) DEFAULT 0, -- 0 不推荐 1 推荐
   is_verify char(1) DEFAULT 0,  -- 0 未审核 1 通过 2 未通过
   is_publish char(1) DEFAULT 0,  -- 0 屏蔽 1 发布
   join_time INT,
   style_type char(1) DEFAULT '1', 
   profile_height INT,
   profile_space VARCHAR(100),
   content_space VARCHAR(100),
   profile text ,
   position INT DEFAULT 0,
   remark TEXT DEFAULT ''
)

-- alter table article add  style_type char(1) DEFAULT '1';
-- alter table article add  profile text;
-- alter table article add  profile_height INT;
-- alter table article add  profile_space VARCHAR(100);
-- alter table article add  content_space VARCHAR(100);
-- alter table article add  bg_url VARCHAR(100) NOT NULL;

-- content
CREATE TABLE content (
  id varchar(32) NOT NULL  PRIMARY KEY,
  type varchar(50) DEFAULT '',
  parent varchar(50) DEFAULT '',
  value varchar(50) DEFAULT '',
  flag varchar(200) DEFAULT '',
  position int DEFAULT ''
)

-- magainze_article
CREATE TABLE magainze_article(
  id VARCHAR(32) NOT NULL PRIMARY KEY,
  article_id VARCHAR(32) NOT NULL,
  magainze_id VARCHAR(32) NOT NULL,
  join_time datetime
)

-- bookmarks
CREATE TABLE bookmarks(
  id VARCHAR(32) NOT NULL PRIMARY KEY,
  article_id VARCHAR(32) NOT NULL,
  user_uid VARCHAR(32) NOT NULL,
  is_love  bit DEFAULT 0, -- 0 not love 1 love
  is_mark  bit DEFAULT 0, -- 0 not bookmark 1 is bookmark
  join_time datetime
)

CREATE TABLE read_history(
  id VARCHAR(32) NOT NULL PRIMARY KEY,
  article_id VARCHAR(32) NOT NULL,
  user_uid VARCHAR(32) NOT NULL,
  read_num int
)

CREATE TABLE banner(
  id VARCHAR(32) NOT NULL PRIMARY KEY,
  title VARCHAR(200) NOT NULL DEFAULT '',
  image_url VARCHAR(100) NOT NULL DEFAULT '',
  sort INT NOT NULL,
  link VARCHAR(50) NOT NULL DEFAULT '',
  create_time INT
)
