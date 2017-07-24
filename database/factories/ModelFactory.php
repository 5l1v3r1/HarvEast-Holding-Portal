<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'role_id' => 2,
        'email' => $faker->unique()->safeEmail,
        'city_id' => rand(1,2),
        'department_id' => rand(1,2),
        'position_id' => rand(1,2),
        'boss_id' => rand(1,300),
        'birthday' => $faker->dateTimeThisDecade($max = 'now', $timezone = date_default_timezone_get()),
        'photo' =>$faker->imageUrl($width = 640, $height = 480),        
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    
    return [
        'name' => $faker->name,
        'body' => $faker->text(10000),
        'slug' => $faker->name,
        'media' =>$faker->imageUrl($width = 640, $height = 480),
        'user_id' => rand(1,4),
        'department_id' => rand(1,2),
        'city_id' => rand(1,2)
    ];
});

$factory->define(App\Poll::class, function (Faker\Generator $faker) {
    $random = rand(2,5);
    $from = Carbon::now()->subDays($random);
    $to = Carbon::now()->addDays(2);

    return [
        'name' => $faker->name,
        'start' => $from,
        'end'   => $to
    ];
});

$factory->define(App\Option::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name
    ];
});


$factory->define(App\Tag::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Position::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Phone::class, function (Faker\Generator $faker){

    return [
        'user_id' => $faker->numberBetween(1,300),
        'phone' => $faker->e164PhoneNumber
    ];
});

$factory->define(App\Document::class, function (Faker\Generator $faker){

    return [
        'name' =>$faker->name,
        'category_id' => $faker->numberBetween(1,5),
        'link' => $faker->randomElement(["/docs/08.01 MinoX.odt", "/docs/2017-03-03_ekoline.kiev.ua_Netpeak-Spider-Report.xls"]),
        'description' => $faker->text
    ];
});

$factory->define(App\DocumentCategory::class, function (Faker\Generator $faker){

    return [
        'name' => $faker->name
    ];
});

$factory->define(App\BidCategory::class, function (Faker\Generator $faker){

    return [
        'name' => $faker->name,
        'parent_id' => $faker->numberBetween(1,4)
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker){

    return [
        'body' => $faker->text,
        'user_id' => $faker->numberBetween(1,300),
        'article_id' => $faker->numberBetween(1,30)
    ];
});