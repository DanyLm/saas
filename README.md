<p align="center"><a href="https://devdojo.com/wave" target="_blank"><img src="https://cdn.devdojo.com/images/october2024/wave-logo.png" width="200"></a></p>

<p align="center">
<a href="https://github.com/thedevdojo/wave/actions"><img src="https://github.com/thedevdojo/wave/actions/workflows/tests.yml/badge.svg" alt="Build Status"></a>
<a href="https://github.com/thedevdojo/wave"><img src="https://img.shields.io/github/v/release/thedevdojo/wave" alt="Latest Stable Version"></a>
<a href="https://github.com/thedevdojo/wave"><img src="https://img.shields.io/badge/license-MIT-green" alt="License"></a>
<a href="https://herd.laravel.com/new?starter-kit=devdojo/wave"><img src="https://img.shields.io/badge/Install%20with%20Herd-f55247?logo=laravel&logoColor=white"></a>
</p>

First attempts of **ChattingHub** app.
## Installation

Open a terminal and run this command
```shell
git clone https://github.com/DanyLm/saas.git
```
> If git command doesn't exist in your MAC, run this command `brew install git`


Move into saas directory, in root folder run 
```shell
cp .env.example .env
```

Then install all the dependencies
```shell
composer install
```
> If composer command doesn't exist in your MAC, run `brew install composer`

Last things, you needs to set up migration (database) and default data
```shell
php artisan migrate:fresh && php artisan db:seed
```

## Login

- Username : `admin@chattinghub.com`
- Password : `password`

## Full documentation of this Saas


- <a href="https://devdojo.com/wave/docs/features/auth" target="_blank">Authentication</a>
- <a href="https://devdojo.com/wave/docs/features/user-profiles" target="_blank">User Profiles</a>
- <a href="https://devdojo.com/wave/docs/features/user-impersonations" target="_blank">User Impersonations</a>
- <a href="https://devdojo.com/wave/docs/features/billing" target="_blank">Billing</a>
- <a href="https://devdojo.com/wave/docs/features/subscription-plans" target="_blank">Subscription Plans</a>
- <a href="https://devdojo.com/wave/docs/features/roles-permissions" target="_blank">Roles & Permissions</a>
- <a href="https://devdojo.com/wave/docs/features/notifications" target="_blank">User Notifications</a>
- <a href="https://devdojo.com/wave/docs/features/changelog" target="_blank">Changelog</a>
- <a href="https://devdojo.com/wave/docs/features/blog" target="_blank">Blog</a>
- <a href="https://devdojo.com/wave/docs/features/pages" target="_blank">Pages</a>
- <a href="https://devdojo.com/wave/docs/features/api" target="_blank">API</a>
- <a href="https://devdojo.com/wave/docs/features/admin" target="_blank">Admin</a>
- <a href="https://devdojo.com/wave/docs/features/themes" target="_blank">Themes</a>
- <a href="https://devdojo.com/wave/docs/features/plugins" target="_blank">Plugins</a>

Be sure to view a list of <a href="https://devdojo.com/wave/docs/features/auth" target="_blank">all features here</a>.


Checkout the [official documentation here](https://devdojo.com/wave/docs).



