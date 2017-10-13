<p align="center"><a href="https://rcs.github.io/voyager/" target="_blank"><img width="400" src="#"></a></p>

<p align="center">
<a href="https://travis-ci.org/rcs/laravel-cms"><img src="https://travis-ci.org/the-control-group/voyager.svg?branch=master" alt="Build Status"></a>
<a href="https://styleci.io/repos/72069409/shield?style=flat"><img src="https://styleci.io/repos/72069409/shield?style=flat" alt="Build Status"></a>
<a href="https://packagist.org/packages/rcs/cms"><img src="https://poser.pugx.org/rcs/cms/downloads.svg?format=flat" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/rcs/cms"><img src="https://poser.pugx.org/rcs/laravel-cms/v/stable.svg?format=flat" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/rcs/cms"><img src="https://poser.pugx.org/rcs/laravel-cms/license.svg?format=flat" alt="License"></a>
<a href="https://github.com/larapack/awesome-cms"><img src="https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg" alt="Awesome Voyager"></a>
</p>

# **C**MS - Content Management Made Easy!
Made with ❤️ by [RCS](https://www.rcswebhosting.com)

![Voyager Screenshot](https://www.rcswebhosting.com/templates/YourHost/images/rcslogo.png)

Website & Documentation: https://www.rcswebhosting.com

Video Tutorial Here: https://www.rcswebhosting.com

Join our Slack chat: https://laravel-cms-slack-invitation.herokuapp.com/

View the CMS Cheat Sheet: https://www.rcswebhosting.com

<hr>

Laravel Admin & CMS System (Browse, Read, Edit, Add & Delete), supporting Laravel 5.5 and newer!

## Installation Steps

### 1. Require the Package

After creating your new Laravel application you can include the Voyager package with the following command: 

```bash
composer require rcs/cms
```

### 2. Add the DB Credentials & APP_URL

Next make sure to create a new database and add your database credentials to your .env file:

```
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

You will also want to update your website URL inside of the `APP_URL` variable inside the .env file:

```
APP_URL=http://localhost:8000
```

> Enjoy!

### 3. Run The Installer

Lastly, we can install voyager. You can do this either with or without dummy data.
The dummy data will include 1 admin account (if no users already exists), 1 demo page, 4 demo posts, 2 categories and 7 settings.

To install Voyager without dummy simply run

```bash
php artisan cms:install
```

If you prefer installing it with dummy run

```bash
php artisan cms:install --with-dummy
```

> Troubleshooting: **Specified key was too long error**. If you see this error message you have an outdated version of MySQL, use the following solution: https://laravel-news.com/laravel-5-4-key-too-long-error

And we're all good to go!

Start up a local development server with `php artisan serve` And, visit [http://localhost:8000/admin](http://localhost:8000/admin).

## Creating an Admin User

If you did go ahead with the dummy data, a user should have been created for you with the following login credentials:

>**email:** `admin@admin.com`   
>**password:** `password`

NOTE: Please note that a dummy user is **only** created if there are no current users in your database.

If you did not go with the dummy user, you may wish to assign admin privileges to an existing user.
This can easily be done by running this command:

```bash
php artisan cms:admin your@email.com
```

If you did not install the dummy data and you wish to create a new admin user you can pass the `--create` flag, like so:

```bash
php artisan cms:admin your@email.com --create
```

And you will be prompted for the user's name and password.