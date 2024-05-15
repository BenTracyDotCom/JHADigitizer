# Acme Widgets Digital JHA Tool
![test status](https://github.com/BenTracyDotCom/JHADigitizer/actions/workflows/ci.yml/badge.svg)

Digital tool to search, create and manage Job Hazard Analysis documents\
**This guide uses Laravel Sail to run the demo app a development environment ONLY.**

##### This giude assumes you have PHP, Composer, and the Docker Desktop GUI installed

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

# Using the app:

If the database seeded correctly, the home page should look like this:

![homepage](https://i.imgur.com/qY6W2NS.png)


## Viewing, Updating and Deleting JHA Forms
When you click on any of the JHA tiles, a pop-up appears with more detailed information:

![viewJha](https://i.imgur.com/zNWM7My.png)

When you click "Edit Form", edit options appear on all editable fields, as well as a key to decipher the available options.

![editJHA](https://i.imgur.com/vVPIGW0.png)

Once you add a new step/hazard/control, it creates a record with a default name. You'll have to click the "edit field" icon to change that name.

![addStep](https://i.imgur.com/4GYepDK.png)
![addText](https://i.imgur.com/0gm5sEd.png)
While you're editing text, [ enter ] will submit the data, and [ esc ] will cancel your input and revert back to the original value.

Once you've added all the steps/hazards/controls you wish, all of the associated records have been saved. You can click "Finish editing" to view the updated form.
![editingFinished](https://i.imgur.com/gVYCWd6.png)
![updatedJha](https://i.imgur.com/a6F4L4Y.png)

Clicking the "Delete" button at any point will delete the JHA form.

## Creating JHA Forms:

WHen you click "Add a Job Hazard Analysis" from the home screen, the following dialog box appears requesting a job name and author:
![addJha](https://i.imgur.com/kXKRfYk.png)

Once you submit the data, the form is created and you may add steps to the JHA.
![addStepsToNewJHA](https://i.imgur.com/xDsIkYg.png)

You can add as many steps as you want before assigning Hazards, likewise Hazards to Controls.
![addedStepsToNewJha](https://i.imgur.com/EzJjZbL.png)
![addHazardToNewJha](https://i.imgur.com/PAFhwtB.png)
![addControlToNewJha](https://i.imgur.com/Zgb3IP6.png)

When finished, you can select "Save & Exit" to see the updated list of JHA's with the newly created record at the top.
![JhaAdded](https://i.imgur.com/w0Qa1oo.png)