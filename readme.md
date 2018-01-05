# Gritbox - a full-featured Nette project starter

Gritbox is a pre-packaged and pre-configured Nette Framework application
that you can use as the skeleton for your new applications.


Goal is to create an application skeleton using best practices (ORM, DI, Services, Components) including base functionalities every app needs like user register/login/password reset etc.

It is based on these technologies:

- PHP
- [Nette](https://github.com/nette/nette) (PHP framework)
- [Nextras\ORM](https://github.com/nextras/orm) (ORM)
- [Bootstrap 4 alpha 6](http://getbootstrap.com/) (CSS framework)
- [Webpack](https://webpack.js.org/) (CSS, JS compiling, bundling and minification)
- SCSS (CSS pre-processor)
- jQuery (Javasript framework)
- NPM (package manager)


## Features

### Basic user management

Because every app needs these:

- Admin area
- Login form
- Register form
- Reset password form (sends password reset e-mail)
- TODO: Adding/removing users from Admin area

### and more:

- ACL (Access Control List) defined in config.neon and annotations
- Flashmessage UX (stay always visible)
- Modules (Front, Admin)
- Services: EmailService
- Development tools:
	- [Nextras MailPanel](https://github.com/nextras/mail-panel)
- Stack setup: vendor bundles, caching via hashed files

## Installation

### 1. Create project based on Gritbox via Composer

The best way to install Gritbox is using Composer. If you don't have Composer yet, download
it following [the instructions](http://doc.nette.org/composer). Then use command:

	composer create-project gritbox/gritbox my-app
	cd my-app

### 2. Install Node modules via NPM

After you have Gritbox downloaded by Composer, run

	npm install

which will install all Node modules into `node_modules` directory.

### 3. Import Database

Create MySQL database and import basic database structure from `/database/database.sql` dump.

### 4. Set local configuration

Rename `config.local.template.neon` to `config.local.neon` and edit database credentials

### 5. Make some dirs writable

Make directories `temp` and `log` writable. Navigate your browser
to the `www` directory and you will see a welcome page. PHP 5.4 allows
you run `php -S localhost:8888 -t www` to start the web server and
then visit `http://localhost:8888` in your browser.

It is CRITICAL that whole `app`, `log` and `temp` directories are NOT accessible
directly via a web browser! See [security warning](http://nette.org/security-warning).


## Licenses

- Nette: New BSD License or GPL 2.0 or 3.0 (http://nette.org/license)
- Nextras\ORM: MIT License (https://github.com/nextras/orm/blob/master/license.md)
- jQuery: MIT License (https://jquery.org/license)
- Adminer: Apache License 2.0 or GPL 2 (http://www.adminer.org)
- Sandbox: The Unlicense (http://unlicense.org)
- NPM: The Artistic License 2.0 (https://docs.npmjs.com/policies/license)
- Bootstrap: MIT License (https://github.com/twbs/bootstrap/blob/master/LICENSE)