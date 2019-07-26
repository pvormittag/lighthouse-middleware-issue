<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function index(): string
    {
        // Even though we are returning a string, Laravel will ensure a valid
        // Response object is sent back to the middleware stack.
        // https://github.com/laravel/framework/blob/5.8/src/Illuminate/Foundation/Http/Kernel.php#L148
        // https://github.com/laravel/framework/blob/5.8/src/Illuminate/Routing/Router.php#L730

        return 'Hello, world!';
    }
}
