use unotify;

insert into app_user (email, password, is_enabled, recv_email, phone, first_name, last_name, middle_name)
values ('login1@mail.ru', '123456', 1, 1, '+79103331101', 'Иван', 'Иванов', 'Иванович'),
('login2@mail.ru', 'qwerty', 1, 1, '+79103331102', 'Герасим', 'Сергеев', 'Джавскирпитович'),
('login3@mail.ru', 'qwe123', 1, 1, '+79103331103', 'Митрофан', 'Витальев', 'Реквайрхедорович'),
('login4@mail.ru', 'password', 1, 1, '+79103331104', 'Волк', 'Михайлов', 'Респонсович'),
('login5@mail.ru', '111111', 1, 1, '+79103331105', 'Бессон', 'Ильин', 'Инлюдфутерович');

insert into app_group (caption, description)
VALUES ('registered', 'Зарегистрированный пользователь'),
('access_write_message', 'Пользователь имеющий право писать сообщения');

insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login1@mail.ru') user_id,
(select id from app_group where caption = 'registered')  group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login2@mail.ru') user_id,
(select id from app_group where caption = 'registered')  group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login3@mail.ru') user_id,
(select id from app_group where caption = 'registered')  group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login4@mail.ru') user_id,
(select id from app_group where caption = 'registered')  group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login5@mail.ru') user_id,
(select id from app_group where caption = 'registered')  group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login1@mail.ru')          user_id,
(select id from app_group where caption = 'access_write_message') group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login2@mail.ru')          user_id,
(select id from app_group where caption = 'access_write_message') group_id;
insert into app_user_groups (user_id, group_id)
select (select id from app_user where email = 'login3@mail.ru')          user_id,
(select id from app_group where caption = 'access_write_message') group_id;

insert into msg_section_color (hex_value)
values ('00ffff') /*aqua*/,
('808080') /*gray*/,
('000080') /*navy*/,
('c0c0c0') /*silver*/,
('000000') /*black*/,
('008000') /*green*/,
('808000') /*olive*/,
('008080') /*teal*/,
('0000ff') /*blue*/,
('00ff00') /*lime*/,
('800080') /*purple*/,
('ffffff') /*white*/,
('ff00ff') /*fuchsia*/,
('maroon') /*maroon*/,
('ff0000') /*red*/,
('ffff00') /*yellow*/;

insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'Основные', '2019-03-17 00:14:30', (select id from app_user where email = 'login1@mail.ru'),
(select id from msg_section_color where hex_value = '00ff00'), null;
insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'по работе', '2019-03-17 00:14:31', (select id from app_user where email = 'login1@mail.ru'),
(select id from msg_section_color where hex_value = '000080'),
(select id from msg_section where caption = 'Основные');
insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'личные', '2019-03-17 00:14:32', (select id from app_user where email = 'login1@mail.ru'),
(select id from msg_section_color where hex_value = '00ffff'),
(select id from msg_section where caption = 'Основные');

insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'Оповещения', '2019-03-17 00:15:30', (select id from app_user where email = 'login2@mail.ru'),
(select id from msg_section_color where hex_value = 'ff0000'), null;

insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'форумы', '2019-03-17 00:15:31', (select id from app_user where email = 'login2@mail.ru'),
(select id from msg_section_color where hex_value = 'ff00ff'),
(select id from msg_section where caption = 'Оповещения');
insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'магазины', '2019-03-17 00:15:32', (select id from app_user where email = 'login2@mail.ru'),
(select id from msg_section_color where hex_value = 'ffff00'),
(select id from msg_section where caption = 'Оповещения');
insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'подписки', '2019-03-17 00:15:33', (select id from app_user where email = 'login2@mail.ru'),
(select id from msg_section_color where hex_value = '800080'),
(select id from msg_section where caption = 'Оповещения');

insert into msg_section (caption, created_at, created_by, color_id, parent_id)
select 'Спам', '2019-03-17 00:16:30', (select id from app_user where email = 'login3@mail.ru'),
(select id from msg_section_color where hex_value = 'ff0000'), null;