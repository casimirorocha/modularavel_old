## Laravel Auto Routes
```
                _              _____             _            
     /\        | |            |  __ \           | |           
    /  \  _   _| |_ ___ ______| |__) |___  _   _| |_ ___  ___ 
   / /\ \| | | | __/ _ \______|  _  // _ \| | | | __/ _ \/ __|
  / ____ \ |_| | || (_) |     | | \ \ (_) | |_| | ||  __/\__ \
 /_/    \_\__,_|\__\___/      |_|  \_\___/ \__,_|\__\___||___/
```
[![Total Downloads](https://poser.pugx.org/izniburak/laravel-auto-routes/d/total.svg)](https://packagist.org/packages/izniburak/laravel-auto-routes)
[![Latest Stable Version](https://poser.pugx.org/izniburak/laravel-auto-routes/v/stable.svg)](https://packagist.org/packages/izniburak/laravel-auto-routes)
[![Latest Unstable Version](https://poser.pugx.org/izniburak/laravel-auto-routes/v/unstable.svg)](https://packagist.org/packages/izniburak/laravel-auto-routes)
[![License](https://poser.pugx.org/izniburak/laravel-auto-routes/license.svg)](https://packagist.org/packages/izniburak/laravel-auto-routes)

Automatically Route Generator & Discovery Package for Laravel.

## Features
- All HTTP Methods which supported by Laravel
- AJAX supported HTTP Methods (XMLHttpRequest)
- Custom patterns for parameters with Regex
- kebab-case and snake_case supported URLs
- Livewire routes support [included Volt] _(in v2.x)_

## Install
Supported Laravel Versions:
- v2.x: Laravel 10 and later
- v1.x: Laravel 6 and later ([see the source](https://github.com/izniburak/laravel-auto-routes/tree/1.x))

Run the following command directly in your Project path:
```
$ composer require izniburak/laravel-auto-routes
```
**OR** open your `composer.json` file and add the package like this:
```json
{
    "require": {
        "izniburak/laravel-auto-routes": "^2.0"
    }
}
```
after run the install command.
```
$ composer install
```

The service provider of the Package will be **automatically discovered** by Laravel.

After that, you should publish the config file via following command:

```
$ php artisan vendor:publish --provider="Buki\AutoRoute\AutoRouteServiceProvider"
```
Greate! You can start to use **Auto Route** Package.

## Usage
Open `web.php` or `api.php` files in `routes` directory, and add a new route that will be generated automatically:
```php
Route::auto('/test', 'TestController');
```
All methods will be automatically generated by the AutoRoute Package.

## Details

- You can use `auto-route.php` file in `config` directory in order to change configuration of the Package. You can;
    * add new patterns for the parameters of the methods.
    * change default HTTP methods.
    * change main method.
    

- You can use `Buki\AutoRoute\Facades\Route` in `web.php` and `api.php` in order to simple code completion for the method while using an IDE or Editor. 
  You can add/replace the following line to top of the file:
```php
// use Illuminate\Support\Facades\Route;
use Buki\AutoRoute\Facades\Route;
```
- All methods which will be auto generated must have `public` accessor to discovered by the **AutoRoute** Package.
  
### Methods
- If you use `camelCase` style for your method names in the Controllers, these methods endpoints will automatically convert to `kebab-case` to make pretty URLs. For example:
```php
Route::auto('/test', 'TestController');
# OR
Route::auto('/test', TestController::class);
```
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL will be converted to "/test/foo-bar"
     */
    public function fooBar(Request $request)
    {
        // your codes
    }
}
```
- You can specify HTTP Method for the method of the Controllers. If you want that a method works with `GET` method and other method works with `POST` method, you can do it. Just add a prefix for the method. That's all. For example;
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/foo-bar"
     * This method will only work with 'GET' method. 
     */
    public function getFooBar(Request $request)
    {
        // your codes
    }
    
    /**
     * URL: "/test/bar-baz"
     * This method will only work with 'POST' method. 
     */
    public function postBarBaz(Request $request)
    {
        // your codes
    }
}
```
- If you don't add any prefix to your methods to use HTTP method definition, all URL will work with all HTTP methods. This options can be changed from `auto-route.php` configuration file.
  

- If you want to use `snake_case` format for your methods, you can do it like that:
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/foo_bar"
     * This method will only work with 'GET' method. 
     */
    public function get_foo_bar(Request $request)
    {
        // your codes
    }
    
    /**
     * URL: "/test/bar_baz"
     * This method will only work with 'POST' method. 
     */
    public function post_bar_baz(Request $request)
    {
        // your codes
    }
}
```

### Ajax Supported Methods

Also, you can add **AJAX supported** routes. For example; If you want to have a route which only access with GET method and XMLHttpRequest, you can define it simply.
This package has some AJAX supported methods. These are;
```
XGET, XPOST, XPUT, XDELETE, XPATCH, XOPTIONS, XANY.
```
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/foo"
     * This method will only work with 'GET' method and XMLHttpRequest.
     */
    public function xgetFoo(Request $request)
    {
        // your codes
    }
    
    /**
     * URL: "/test/bar"
     * This method will only work with 'POST' method and XMLHttpRequest.
     */
    public function xpostBar(Request $request)
    {
        // your codes
    }
    
    /**
     * URL: "/test/baz"
     * This method will work with any method and XMLHttpRequest. 
     */
    public function xanyBaz(Request $request)
    {
        // your codes
    }
}
```
As you see, you need to add only `x` char as prefix to define the AJAX supported routes. 
If you want to support XMLHttpRequest and all HTTP methods which supported by Laravel, you can use `xany` prefix.

For AJAX supported methods, the package will automatically add a middleware in order to check XMLHttpRequest for the routes.
This middleware throws a `MethodNotAllowedException` exception. But, you can change this middleware from `auto-routes.php` file in `config` directory, if you want.

### Options 

- You can add route options via third parameter of the `auto` method.
```php
Route::auto('/test', 'TestController', [
    // your options... 
]);
```
Options array may contain all Laravel route attributes like `name`, `middleware`, `namespace`, etc..

In addition, you can add `patterns` into the Options array in order to define new patterns for the parameters of the methods in the Controllers. For example:
```php
Route::auto('/test', 'TestController', [
    'name' => 'test',
    'middleware' => [YourMiddleware::class],
    'patterns' => [
        'id' => '\d+',
        'value' => '\w+',
    ],
]);
```
According to example above, you can use `$id` and `$value` parameters in all methods in the Controller. And for these parameters, the rules you defined will be applied.

Also, to define default patterns for the parameters, you can modify `patterns` in `auto-route.php` file.

- You can specify the Routes which will be generated automatically by using `only` or `except` with `options` parameters. You should use method names in the Controllers. For example;
```php
# First Example
Route::auto('/foo', 'FooController', [
    'only' => ['fooBar', 'postUpdatePost'],
]);

# Second Example
Route::auto('/bar', 'BarController', [
    'except' => ['test', 'putExample'],
]);
```

According to first example above, only two methods will be generated. And according to other example, all methods will be generated except two methods which specified.

- If you don't change the `main_method` in configurations, your main method will be `index` for the Controllers. That's mean, you should be add `index` method into your controller to define base endpoint of the Controller. For example;
```php
Route::auto('/test', 'TestController');
```
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test"
     */
    public function index(Request $request)
    {
        // your codes
    }
    
    /**
     * URL: "/test/foo-bar"
     */
    public function fooBar(Request $request)
    {
        // your codes
    }
}
```
### Parameters
- You can use parameters as `required` and `optional` for the methods in your Controllers. For example;
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/{id}"
     */
    public function index(Request $request, $id)
    {
        // your codes
    }
    
    /**
     * URL: "/test/foo-bar/{name}/{surname?}"
     */
    public function fooBar(Request $request, $name, $surname = null)
    {
        // your codes
    }
}
```
Also, you can use parameter type to use compatible pattern for the parameter. Parameter types can be `int`, `string`, `float` and `bool`. For example:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/{id}"
     * id parameter must be numeric.  
     */
    public function index(Request $request, int $id)
    {
        // your codes
    }
    
    /**
     * URL: "/test/foo-bar/{name}/{surname?}"
     * name and surname parameters must be string.
     */
    public function fooBar(Request $request, string $name, string $surname = null)
    {
        // your codes
    }
}
```
If you define patterns for these variable names in the `auto-route.php` configuration file, your definition will be used for the value checking.

To use `int`, `float`, `string` and `bool` patterns quickly for your parameters, you can use parameter type directly.


- You can use subfolder definition for the Controllers. For example;
```php
Route::auto('/test', 'Backend.TestController');
# OR
Route::auto('/test', 'Backend\\TestController');
```

## Livewire & Volt support 
You can define Livewire or Volt component routes directly in your controller by using Auto Routes package!
For this, you should add new methods which have prefix `volt` or `wire`. That's it. Auto Routes package will automatically discover your Livewire routes and add them into the application routes.

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * URL: "/test/foo"
     */
    public function voltFoo(): string
    {
        // resources/views/livewire/pages/foo.blade.php
        return 'pages.foo';
    }

    /**
     * URL: "/test/bar"
     */
    public function wireBar(): string
    {
        return \App\Livewire\TestComponent::class;
    }
}
```
As you see; for both methods, you must return a string value that Volt component path string or Livewire component class string. Now, you can access your Livewire components.


## Support
You can use Issues

[izniburak's homepage][author-url]

[izniburak's twitter][twitter-url]

## Licence
[MIT Licence][mit-url]

## Contributing

1. Fork it ( https://github.com/izniburak/laravel-auto-routes/fork )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create a new Pull Request

## Contributors

- [izniburak](https://github.com/izniburak) İzni Burak Demirtaş - creator, maintainer

[mit-url]: http://opensource.org/licenses/MIT
[author-url]: https://buki.dev
[twitter-url]: https://twitter.com/izniburak