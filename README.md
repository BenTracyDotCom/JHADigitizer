# Acme Widgets Digital JHA Tool

Online tool to search, create and manage Job Hazard Analysis documents\
**This is a demo tool with limited security. This repo and guide will not protect production databases.**

## How to Run:
### Install dependencies:
From the root directory:
```shell 
composer install
npm install
```
### Copy `.env.example` into a new file, `.env`
```shell
cp .env.example .env
```
#### Edit this block in the newly created `.env` file:
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```
#### To the following:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```
### Spin up the server, database, and database GUI:
``` bash
vendor/bin/sail up
```
Once the process completes, 'localhost:8001' should navigate to PHPMyadmin.
* Login info for the purpose of this demo is:
    * Username: sail
    * Password: password
 
### Run migrations and Seed Database (optional)
In Docker Desktop, under the `jhadigitizer` cluster, find the 'laravel.test' image, click the ellipsis next to it and select "Open in terminal":

![docker GUI](https://i.imgur.com/W6FKBOg.png)

In the terminal window, run `php artisan migrate` and, if desired, `php artisan db:seed`

### Spin up the frontend manager:
Start the Vite/Vue frontend with ```npm run dev```
## Navigate to 'localhost' to view the app!

