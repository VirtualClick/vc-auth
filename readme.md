# VirtualClick Auth


## Sobre

Pacote de comunicação com servidor de autênticação

## Instalação

### Composer
````
composer require virtualclick/vc-auth
````

##### `config/app.php` para Laravel < 5.5
````
'providers' => [
    ...
    VCAuth\ServiceProvider::class,
],
````

##### `app/Http/Kernel.php`
````
protected $routeMiddleware = [
    ...
    'vcauth' => \VCAuth\HandleVcAuth::class,
];
````

### Publicação

Utilize o comando abaixo para publicar o aruqivo de configuração `config/vcauth.php`:
````
php artisan vendor:publish --provider="VCAuth\ServiceProvider"
````

### ENV
````
VCAUTH_URL=http://localhost
VCAUTH_TOKEN=123456
VCAUTH_USE_FORWARDED_FOR=false
````

## Uso
````
Route::middleware('vcauth')->get('/user', function (Request $request) {
    return $request->user();
});
````
