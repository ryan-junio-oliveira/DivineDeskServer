Aplicação Laravel:

URL: http://localhost:8000
Este URL acessa o serviço webserver, que serve a aplicação Laravel através do Nginx.
phpMyAdmin:

URL: http://localhost:8080
Este URL acessa o serviço phpmyadmin, onde você pode gerenciar o banco de dados MySQL.
MySQL:

Host: localhost
Porta: 3306
Usuário: laravel
Senha: secret
Database: laravel
Note que o MySQL não tem uma interface web, mas você pode acessá-lo através do phpMyAdmin ou de qualquer cliente MySQL.
Memcached e Redis:

Esses serviços não possuem interfaces web padrão. Eles são usados internamente pela aplicação Laravel para cache e armazenamento de dados em memória.
Memcached:
Host: memcached
Porta: 11211
Redis:
Host: redis
Porta: 6379