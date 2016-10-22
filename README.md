See [Objective.pdf](//github.com/PLoginoff/test011/blob/master/Objective.pdf)

```bash
$ composer install
$ mysql -uroot -p < dump.sql
$ vim app/config/parameters.yml
$ php5.6 app/check.php
$ php5.6 phpunit.phar -c app/
$ php5.6 app/console server:run
```

And now go to...

You can read messages here: `tail app/logs/fakesendmail.log`

--

Preconditions
You should work on your local machine.
You may use any IDE or editor for developing the application.
You must use the latest PHP5 version compatible with required libraries.
You must use Apache or IIS as the web server.
You must use MySQL as database.
You must use one of these frameworks:
- Laravel
- CodeIgniter
- Yii2
- Symfony2
Failing to follow these rules will invalidate your submission and you will not be evaluated.


