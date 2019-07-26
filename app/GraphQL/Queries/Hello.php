<?php

namespace App\GraphQL\Queries;

class Hello
{
    public function resolve(): string {
        // When using the `middleware` directive, the value from the resolver
        // is passed directly back to the middleware stack, which breaks the
        // implicit contact that a Middleware's `handle` method will call `next`
        // with a Response object.
        // https://github.com/nuwave/lighthouse/blob/3.x/src/Schema/Directives/MiddlewareDirective.php#L92

        return 'world!';
    }
}
