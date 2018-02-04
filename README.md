# mg-test
## requirement
https://laravel.com/docs/5.5/installation#server-requirements
- PHP >= 7.1
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MongoDB
- Composer

## instalation
run the following commands:

1. `composer install`
1. `cp .env.example .env`
1. `php artisan key:generate`
1. `php artisan storage:link`
1. edit `.env` file:
    1. `APP_URL` enter your host name (eg: `http://localhost`)
    1. change `DB_CONNECTION`to `mongodb` and modify `DB_*` for your connection (eg: `DB_PORT=27017`)
    1. change `DB_DATABASE` to your desired mongodb collection
    1. change `QUEUE_DRIVER` to `database`

## import showcase
run the following commands:

1. `php artisan queue:work` (https://laravel.com/docs/5.5/queues#running-the-queue-worker)
1. `php artisan import:showcase {url}`
1. you should see the results on `http://localhost/`

## running tests
run the following command:

- `vendor/bin/phpunit`