/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2018/7/28 11:17:48                           */
/*==============================================================*/


drop table if exists newsinfo;

drop table if exists users;

/*==============================================================*/
/* Table: newsinfo                                              */
/*==============================================================*/
create table newsinfo
(
   id                   int not null,
   title                varchar(200) not null,
   description          varchar(300) not null,
   content              text not null,
   source               varchar(100) not null,
   thumbr               varchar(300) not null,
   banner               varchar(300) not null,
   likenum              int(11) not null,
   commentary_num       int(11) not null,
   primary key (id)
);

alter table newsinfo comment '资讯表';

/*==============================================================*/
/* Table: users                                                 */
/*==============================================================*/
create table users
(
   id                   int not null,
   nickname             varchar(200) not null,
   headimg              varchar(300) not null,
   phone                char(12) not null,
   openid               char(32) not null,
   register_time        int(11) not null,
   primary key (id)
);

alter table users comment '用户表';

