# API
API básica desenvolvida em LARAVEL

- PHP -> 7.2
- MySQL
- LARAVEL -> 6.2
- Para execução da API, seguir os seguintes comandos

# Install & run (Windows)
 
 - composer install

 - php artisan make:db_create

 - editar arquivo .env.example (criar novo de preferencia) com db_api para DB e usuário e senha do MYSQL

 - php artisan migrate:install 
 
 - php artisan migrate

 - php artisan key:generate
 
 - php artisan storage:link

 - php artisan serve

# Tests

 - vendor/bin/phpunit


# Routes
 - GET | cidadao 
 - GET | cidadao/:cpf 
 - POST | cidadao
 - POST | cidadao/:cpf 
 - DELETE | cidadao/:cpf 

 