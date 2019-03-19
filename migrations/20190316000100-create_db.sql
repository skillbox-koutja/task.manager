# https://docs.google.com/document/d/1TfqAVC-R2KMvIp4L71bMyUy9IKA14NcE0JuKAR86ha4/edit
# drop database unotify;


create database if not exists unotify CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci charset utf8mb4;

use unotify;

create table app_user
(
  id int unsigned auto_increment not null comment 'идентификатор пользователя',
  email varchar(255) not null,
  pw varchar(32) not null,
  is_enabled bool default 1 null comment 'флаг активности пользователя (активен/неактивен)',
  recv_email bool default 1 null comment 'флаг согласия на получение уведомлений по email (согласен / не согласен)',
  phone varchar(15) null,
  first_name nvarchar(255) not null comment 'имя',
  last_name nvarchar(255) not null comment 'фамилия',
  middle_name nvarchar(255) null comment 'отчество',
  constraint app_user_pk
    primary key (id)
);

create unique index user_email_uinx
  on app_user (email);
create unique index user_phone_uinx
  on app_user (phone);

create table app_group
(
  id int unsigned auto_increment not null comment 'идентификатор группы',
  caption nvarchar(255) not null comment 'название группы',
  description nvarchar(2000) null comment 'описание группы',
  constraint app_group_pk
    primary key (id)
);

create unique index group_caption_uinx
  on app_group (caption);

create table group_user
(
  user_id int unsigned not null,
  group_id int unsigned not null,
  constraint group_user_pk
    primary key (user_id, group_id),
  constraint group_user_g_fk
    foreign key (group_id) references app_group (id)
      on update cascade on delete cascade,
  constraint group_user_u_fk
    foreign key (user_id) references app_user (id)
      on update cascade on delete cascade
);

create table color
(
  id int unsigned not null auto_increment comment 'id цвет',
  hex_value varchar(6) not null comment 'шестнадцатеричное значение',
  constraint color_pk
    primary key (id)
);
create unique index color_hex_uinx
  on color (hex_value);

create table section
(
  id int unsigned not null auto_increment comment 'идентификатор раздела сообщения',
  caption nvarchar(255) comment 'заголовок',
  created_at datetime not null comment 'дата создания раздела',
  created_by int unsigned comment 'создатель раздела',
  color_id int unsigned null comment 'цвет',
  parent_id int unsigned null comment 'родительский раздел',
  constraint section_pk
    primary key (id),
  constraint section_user_fk
    foreign key (created_by) references app_user (id)
      on update cascade on delete cascade,
  constraint section_parent_fk
    foreign key (parent_id) references section (id)
      on update cascade on delete cascade,
  constraint section_color_fk
    foreign key (color_id) references color (id)
      on update cascade on delete set null
);

create table msg
(
  id bigint unsigned not null auto_increment comment 'идентификатор сообщения',
  title nvarchar(255) comment 'заголовок',
  body nvarchar(2000) not null comment 'текст сообщения',
  created_at datetime not null comment 'дата отправки',
  from_id int unsigned comment 'отправитель',
  to_id int unsigned comment 'получатель',
  section_id int unsigned comment 'получатель',
  is_read bool default 0 comment 'флаг, что сообщение прочитано',
  constraint message_pk
    primary key (id),
  constraint msg_from_fk
    foreign key (from_id) references app_user (id)
      on update cascade on delete cascade,
  constraint msg_to_fk
    foreign key (to_id) references app_user (id)
      on update cascade on delete cascade,
  constraint msg_section_fk
    foreign key (section_id) references section (id)
      on update cascade on delete cascade
);
