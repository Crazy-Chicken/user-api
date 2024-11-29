## Развертывание

Конфиг докер окружения
<br>
указываем свой ```USER_NAME``` и ip в ```PHP_CLI_XDEBUG_HOST```
```shell
cp .env.default .env
```
```shell
cp evo/.env.dist evo/.env
```

Конфиг nginx
```shell
cp docker/etc/web/conf.d/default.conf.dist docker/etc/web/conf.d/default.conf
```

Устанавливаем зависимости composer
```shell
make install
```

(Возможно понадобится)
```shell
sudo adduser www-data
sudo usermod -a -G www-data www-data
sudo chmod -R 777 .
```

Миграции
```shell
make migrate
```
<br>

## Методы user-api
### логин
```POST http://localhost/api/v1/login```

Request
```
{
    "login": string,
    "password": string
}
```
Response ```200 OK```
```
{
    "token": string,
    "user_id": string
}
```

### Создание аккаунта
```POST http://localhost/api/v1/create-account```

Request
```
{
    "login": string,
    "password": string,
    "name": {
        "first_name": string,
        "second_name": string,
        "last_name": string
    }
}
```
Response ```200 OK```
```
{
    "token": string,
    "user_id": string
}
```

### Получение списка пользователей/пользователя по ID 
```POST http://localhost/api/v1/user/list```

Request
```
{
    "user_id": string,
    "page": int,
    "per_page": int
}
```
Response ```200 OK```
```
{
    "users": [
        {
            "id": string,
            "login": string,
            "name": {
                "first_name": string,
                "second_name": string,
                "last_name": string
            },
            "accesses_nick": string[],
            "update_date": datetime
        }
    ],
    "count": int
}
```

### Обновление данных пользователя
```POST http://localhost/api/v1/user/update```

Request
```
{
    "user_id": string,
    "name": {
        "first_name": string,
        "second_name": string,
        "last_name": string
    },
    "accesses_nick": string[]
}
```
Response ```200 OK```
```
{}
```

### Удаление пользователя
```POST http://localhost/api/v1/user/delete```

Request
```
{
    "user_id": string
}
```
Response ```200 OK```
```
{}
```

### Error response
```
{
    "error": {
        "code": int,
        "message": string
    }
}
```

> P.s.: пользователь по умолчанию `{ "login": "admin", "password": "admin" }`. 
> У него присутствуют все права, а так же возможность выдачи прав.