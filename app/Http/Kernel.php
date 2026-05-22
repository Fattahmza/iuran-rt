protected $routeMiddleware = [
    // ... middleware lain
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
