# https://docs.google.com/document/d/1TfqAVC-R2KMvIp4L71bMyUy9IKA14NcE0JuKAR86ha4/edit

create database if not exists unotify CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci charset utf8mb4;

use unotify;

create table app_user
(
  id int unsigned auto_increment not null comment 'идентификатор пользователя',
  email varchar(255) not null,
  password varchar(32) not null,
  is_enabled bool default 1 null comment 'флаг активности пользователя (активен/неактивен)',
  recv_email bool default 1 null comment 'флаг согласия на получение уведомлений по email (согласен / не согласен)',
  phone varchar(15) null,
  first_name nvarchar(255) not null comment 'имя',
  last_name nvarchar(255) not null comment 'фамилия',
  middle_name nvarchar(255) null comment 'отчество',
  constraint app_user_pk
    primary key (id)
);

create unique index app_user_email_uinx
  on app_user (email);
create unique index app_user_phone_uinx
  on app_user (phone);

create table app_group
(
  id int unsigned auto_increment not null comment 'идентификатор группы',
  caption nvarchar(255) not null comment 'название группы',
  description nvarchar(2000) null comment 'описание группы',
  constraint app_group_pk
    primary key (id)
);

create unique index app_group_caption_uinx
  on app_group (caption);

create table app_user_groups
(
  user_id int unsigned not null,
  group_id int unsigned not null,
  constraint app_user_groups_pk
    primary key (user_id, group_id),
  constraint app_user_groups_group_fk
    foreign key (group_id) references app_group (id)
      on update cascade on delete cascade,
  constraint app_user_groups_user_fk
    foreign key (user_id) references app_user (id)
      on update cascade on delete cascade
);

create table msg
(
  id bigint unsigned not null auto_increment comment 'идентификатор сообщения',
  subject nvarchar(255) comment 'заголовок',
  body nvarchar(2000) not null comment 'текст сообщения',
  created_at datetime not null comment 'дата отправки',
  from_id int unsigned comment 'отправитель',
  to_id int unsigned comment 'получатель',
  is_read bool default 0 comment 'флаг, что сообщение прочитано',
  constraint message_pk
    primary key (id),
  constraint msg_from_fk
    foreign key (from_id) references app_user (id)
      on update cascade on delete cascade,
  constraint msg_to_fk
    foreign key (to_id) references app_user (id)
      on update cascade on delete cascade
);

create table msg_section_color
(
  id int unsigned not null auto_increment comment 'id цвет',
  hex_value varchar(6) not null comment 'шестнадцатеричное значение',
  constraint msg_section_color_pk
    primary key (id)
);
create unique index msg_section_color_hex_uinx
  on msg_section_color (hex_value);

create table msg_section
(
  id bigint unsigned not null auto_increment comment 'идентификатор раздела сообщения',
  caption nvarchar(255) comment 'заголовок',
  created_at datetime not null comment 'дата создания раздела',
  created_by int unsigned comment 'создатель раздела',
  color_id int unsigned null comment 'цвет',
  parent_id bigint unsigned null comment 'родительский раздел',
  constraint msg_section_pk
    primary key (id),
  constraint msg_section_user_fk
    foreign key (created_by) references app_user (id)
      on update cascade on delete cascade,
  constraint msg_section_parent_fk
    foreign key (parent_id) references msg_section (id)
      on update cascade on delete cascade,
  constraint msg_section_color_fk
    foreign key (color_id) references msg_section_color (id)
      on update cascade on delete set null
);

create table msg_section_assoc
(
  msg_id bigint unsigned not null,
  section_id bigint unsigned not null,
  constraint msg_section_assoc_pk
    primary key (msg_id, section_id),
  constraint msg_section_assoc_msg_fk
    foreign key (msg_id) references msg (id)
      on update cascade on delete cascade,
  constraint msg_section_assoc_section_fk
    foreign key (section_id) references msg_section (id)
      on update cascade on delete cascade
);
