mysql -uroot -p < dump.sql
vim app/config/parameters.yml
php5.6 app/check.php
php5.6 phpunit.phar -c app/
php5.6 app/console server:run

And now go to...

You can read messages here:
tail app/logs/fakesendmail.log
