# Installation
Install the package using composer
```$xslt
composer require tnmdev/auth-service
```
Migrate the tables
```
php artisan migrate
```
Install Laravel passport
```$xslt
php artisan passport:install
```
Create `env` variable `AUTH_SERVER_CLIENT_SECRET` and assign it the client secret provided by the auth server

Make the following changes in `App\User` model

* Implement `TNM\AuthService\Models\HasPermissions`
* Use `TNM\AuthService\Models\HasPermissionsTrait`
* Replace `protected $fillable...` with `protected $guarded = []`
