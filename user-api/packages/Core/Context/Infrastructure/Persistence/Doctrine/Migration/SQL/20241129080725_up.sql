insert into users(id, login, password, name_first, name_second, update_date)
values ('1', 'admin', '$2y$10$LjqdswlQ4qAM3fIslzREf.fX/XtOo6nCw9HCLvsx4wmnzyKP1xsTy', 'admin', 'admin', '2024.01.01 01:00:00');

insert into accesses(id, nick, name)
values ('1', 'UPDATE_USERS', 'Обновить пользователей'),
       ('2', 'DELETE_USERS', 'Удалить пользователей'),
       ('3', 'GET_USERS', 'Просматривать пользователей'),
       ('4', 'GIVE_ACCESS', 'Дать доступы пользователю');

insert into a_users_accesses(user_id, access_id)
select (select id from users where login LIKE 'admin'), id
from accesses;
