# Acme Widgets Digital JHA Tool
![test status](https://github.com/BenTracyDotCom/JHADigitizer/actions/workflows/ci.yml/badge.svg)

Online tool to search, create and manage Job Hazard Analysis documents\
**This guide uses Laravel Sail to run the demo app a development environment ONLY.**

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
#### To bootstrap the app to an existing database, modify this block in `.env` as required:

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
## To run tests in the development environment:
From root directory: `vendor/bin/sail test`

# Using the app:

![homepage](https://i.imgur.com/qY6W2NS.png)
![viewJha](https://i.imgur.com/zNWM7My.png)
![editJHA](https://i.imgur.com/vVPIGW0.png)
![addStep](https://i.imgur.com/4GYepDK.png)
![addText](https://i.imgur.com/0gm5sEd.png)
![editingFinished](https://i.imgur.com/gVYCWd6.png)
![updatedJha](https://i.imgur.com/a6F4L4Y.png)
![addJha](https://i.imgur.com/kXKRfYk.png)
![addStepsToNewJHA](https://i.imgur.com/xDsIkYg.png)
![addedStepsToNewJha](https://i.imgur.com/EzJjZbL.png)
![addHazardToNewJha](https://i.imgur.com/PAFhwtB.png)
![addControlToNewJha](https://i.imgur.com/Zgb3IP6.png)
![JhaAdded](https://i.imgur.com/w0Qa1oo.png)