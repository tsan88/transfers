


## About Transfers

Transfers is a web application develop on laravel 5.8. and Laradock

- Register\signup user
- add Transfer
- more validation makes on backend
- 5 last transfer by current user display on home page
- 1 last ransfer by each user display on home page, if transfer exists
- console command to do the transfer runing hourly

## Requirements

- Apache (with mod_rewrite enabled) or Nginx
- PHP 7.1+ with the following extensions: dom, gd, json, mbstring, openssl, pdo_mysql, tokenizer
- MySQL 5.6+ or MariaDB 10.0.5+
- SSH (command-line) access to run Composer

## Installation

- clone this repository
- run 'composer install'
- copy 'env.example' > '.env'
- run 'art migrate'
- run 'db:seed'
