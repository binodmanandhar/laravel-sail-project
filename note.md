docker compose exec laravel.test php artisan

or
./vendor/bin/sail artisan make:seeder UserSeeder
./vendor/bin/sail artisan db:seed --class=UserSeeder

### How to create a fake data in user table

php artisan make:factory UserFactory --model=User

This created UserFactory in factories folder

Add return in definition
public function definition(): array
{
return [
'name' => fake()->name(),
'email' => fake()->unique()->safeEmail(),
'email_verified_at' => now(),
'password' => static::$password ??= Hash::make('password'),
'remember_token' => Str::random(10),
];
}

### create UserSeeder

php artisan make:seeder UserSeeder

This creates database/seeders/UserSeeder.php

Add this
public function run(): void
{
User::factory()->count(50)->create();
}

php artisan db:seed --class=UserSeeder




### Creating controllers

docker compose exec laravel.test php artisan make:controller UserController

### creating controller resource

docker compose exec laravel.test php artisan make:controller ExampleController --resource


### View route list

docker compose exec laravel.test php artisan route:list --except-vendor


### How to view git commit in graph

1) Install git graph extension
2) Ctrl + Shift + p
3) Git Graph: View Git Graph