Yetinder
========================

 
Requirements
------------

  * PHP 8.1.0 or higher;
  * MYSQL PHP extension enabled;
  * and the [usual Symfony application requirements][2].

Installation
------------

Download from repository and run

```bash
# ...or you can clone the code repository and install its dependencies
$ git clone https://github.com/petavojtisek/yetinder.git my_project
$ cd my_project/
$ composer install
$ npm install
$ npm run build

$ ./bin/console cache:pool:clear --all

create dtb wjs

$ ./bin/console doctrine:schema:update 
$ ./bin/console doctrine:fixtures:load 
```
 

Usage
-----

There's no need to configure anything before running the application. There are
2 different ways of running this application depending on your needs:

**Option 1.** [Download Symfony CLI][4] and run this command:

```bash
$ cd my_project/
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

**Option 2.** Use a web server like Nginx or Apache to run the application
(read the documentation about [configuring a web server for Symfony][3]).

On your local machine, you can run this command to use the built-in PHP web server:

```bash
$ cd my_project/
$ php -S localhost:8000 -t public/
```



Description
------------
Hlavní stránka
- Seznam top příspěvků - automaticky refresh 5sec
- Yetinder navrhované příspěvky s řazením 
	dle pohlaví - přednost opačného pohlaví uživatele
	dle preferovane country zjitěne pres 'HTTP_ACCEPT_LANGUAGE' / z localizace webu
	
