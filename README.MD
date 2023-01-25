# A simple application with Symfony PHP framwork


## This just an example with MVC Architecture which is made Symfony 4

### You can read and edit any articles 
### You can authenticate you with the simple registration form
### You can add articles without authentication
### You can add a comments but you must be connected

# requirements  
git <br> 
php 7.1.^ <br> 
composer 2.2

# Installations 

```
git clone https://github.com/toof06/demo-symfony4.git
```

```
composer install
```

```
edit the file .env with your database informations 
```

```
php bin/console doctrine:database:create 
```

```
php bin/console doctrine:schema:create
```
```
php bin/console doctrine:fixtures:load
```

```
php bin/console server:run 
```


