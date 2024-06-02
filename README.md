MySQL
=====

* [explicit_defaults_for_timestamp](https://dev.mysql.com/doc/refman/5.7/en/server-system-variables.html#sysvar_explicit_defaults_for_timestamp)
* [default_authentication_plugin](https://dev.mysql.com/doc/refman/8.0/en/server-system-variables.html#sysvar_default_authentication_plugin)

Common
======

* Имена полей в таблицах базы данных camelCase
* Имена директорий в camelCase
* Имена переменных в camelCase
* Реляции получают суффикс Relation ( getCreatedByRelation )
* Наименования модулей как и имена таблиц в ***единственном*** числе!
* Не использовать before* и after* методы \yii\base\Model

Копируем файл настройки окружения:

```
cp .env.dist .env
```

Редактируем файл .env

Основные параметры:

```
MYSQL_HOST=localhost
MYSQL_USER=root
MYSQL_PORT=3306
MYSQL_PASSWORD=pass
MYSQL_DATABASE=test_yii
MYSQL_TABLE_PREFIX=tbl_

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

YII_HOST_INFO=http://test.loc

YII_DEBUG=true
YII_ENV=dev

VALIDATE_KEY=app-alex
```
Установка

```
composer install - утсновка проекта
composer update - обновление проекта

./yii migrate - применение миграций

./yii role - применение RBAC

./yii user - создание админа (логин/пароль => admin/admin)
```
