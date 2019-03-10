This is just a simple application with the MVC architecture.
In the file .dev  give your parameters of connection 
change this : DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
or just modify doctrine.yml and give your parameters of connection.

this application require php 7.1.22
and for artciles information we had requiered fzaninotto/faker. 

1)- 
$ composer install

2)-

$ php bin/console server:run 

2)- 
$ php bin/console doctrine:database:create

3)- 
$ php bin/console doctrine:schema:create 

4)-
$ php bin/console doctrine:fixtures:load 

5)-
$ php bin/console server:run 

