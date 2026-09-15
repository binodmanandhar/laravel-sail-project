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



#### Install JETSTEAM

docker compose exec laravel.test composer require laravel/jetstream


#### For the standard Livewire stack:

docker compose exec laravel.test php artisan jetstream:install livewire

#### Install frontend dependencies

docker compose exec laravel.test npm install

Then 

docker compose exec laravel.test npm run build


### Run migrations
docker compose exec laravel.test php artisan migrate

If this is only a practice project and you don't mind deleting your existing database:

docker compose exec laravel.test php artisan migrate:fresh