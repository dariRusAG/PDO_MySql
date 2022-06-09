# PDO_MySql
## Добавить в чат взаимодействие с базой данных MySQL с помощью PDO.

### Теоретическая часть:
- [https://getcomposer.org/doc/00-intro.md](https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-20-04-ru)
- https://phoenixnap.com/kb/how-to-create-new-mysql-user-account-grant-privileges
- https://www.php.net/manual/ru/ref.pdo-mysql.php
- https://www.php.net/manual/ru/pdo.connections.php

*Задача* Реализовать простое приложение PHP с использованием шаблонизатора twig и организации работы с базой данных MySQL с помощью PDO.
Порядок выполнения:
* Анализ задачи.
* Исследование источников.
* Сконфигурировать подключение к БД.
* Реализовать функционал добавления записей в БД.
* Реализовать функционал отображения списка добавленных записей.

Форма отчета: репозиторий на GitHub с php-приложением, работоспособное приложение доступное по сети, в котором в качестве шаблонизатора используется twig, а для взаимодействия с БД используется PDO.

### Результат
[Чат](http://143.198.70.213:3333/)

### Изменение logs:
Выделена следующая информация:
* `New message` - новое сообщение. Данные хранят имя пользователя, и его сообщение;
* `Chat was cleared` - очистка истории сообщений;
* `Incorrect password entered` - неверный пароль. Ошибка;
* `This user is not registered` - такой пользователь незарегестрирован. Ошибка.

### Все таблицы с содержанием в MySql:
![Таблицы MySql](https://user-images.githubusercontent.com/91362737/172793791-7c8a912c-c9ea-4fdb-bcd2-eb9066944166.png)

### Для авторизации:
1. dasha - qwerty
2. admin - qwerty
