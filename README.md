# Installation
- clone the repository
- open your console and go to the project directory :
    ```
   composer install
   composer dump-env prod
    ```
- go to /p6/.env.local.php
    - Update DATABASE_URL with your environement : 
        ```
        'DATABASE_URL' => 'mysql://db_user:db_password@127.0.0.1:3306/db_name',
        ```
        
### Create the database and load fixtures
- in your console :
   ```
   ./bin/console doctrine:database:create
   ./bin/console make:migration
   ./bin/console doctrine:migrations:migrate
   ./bin/console doctrine:fixtures:load
   ```
   
        
### Setup your email adress
   - go to /p6/config/packages/swiftmailer.yaml
     ```bash
     port: your port
     host: ssl0.yourhost.net
     username: your@email.com
     password: your-password
     ```
     
### Start the server in local
 - in your console :
     ```
     ./bin/console server:run
     ```
 Open your browser and go to localhost:8000
 
 Enjoy :)
 

     
[![Maintainability](https://api.codeclimate.com/v1/badges/9fa126d185c0ed0238fc/maintainability)](https://codeclimate.com/github/tcheuD/p6/maintainability)
