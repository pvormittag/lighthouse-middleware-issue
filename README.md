This is a minimal reproducible example detailing an issue  described for [Lighthouse](https://github.com/nuwave/lighthouse). It contains a stock Laravel / Lighthouse implementation.

## Running the Example

Run the example with [Docker Compose](https://docs.docker.com/compose/) by executing `docker-compose up -d`.

## Walkthrough

A simple middleware is in place to highlight the return values between different usages:

From: `app/Http/Middleware/Test.php`
```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    echo 'App\Http\Middleware\Test has returned value from $next as:';
    dd($response);
}
```

First, visit http://localhost/test in a browser and you should expect a `Response` object as the dumped value.

From: `app/Http/Controllers/TestController.php`
```php
public function index(): string
{
    // Even though we are returning a string, Laravel will ensure a valid
    // Response object is sent back to the middleware stack.
    // https://github.com/laravel/framework/blob/5.8/src/Illuminate/Foundation/Http/Kernel.php#L148
    // https://github.com/laravel/framework/blob/5.8/src/Illuminate/Routing/Router.php#L730

    return 'Hello, world!';
}
```

Then, make a GraphQL request to http://localhost/graphql from a [GraphQL client](https://insomnia.rest/) with the following query and you should expect "world!" as the dumped value, which is the return value of the field resolver.

```graphql
query {
  hello
}
```

From: `app/GraphQL/Queries/Hello.php`
```php
public function resolve(): string {
    // When using the `middleware` directive, the value from the resolver
    // is passed directly back to the middleware stack, which breaks the
    // implicit contact that a Middleware's `handle` method will call `next`
    // with a Response object.
    // https://github.com/nuwave/lighthouse/blob/3.x/src/Schema/Directives/MiddlewareDirective.php#L92

    return 'world!';
}
```