<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@flight.ru'],
            [
                'fio' => 'Админ Админович Админов',
                'password' => Hash::make('QWEasd123'),
                'role' => 'admin',
                'api_token' => Str::random(64),
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@flight.ru'],
            [
                'fio' => 'Иванов Иван Иванович',
                'password' => Hash::make('password'),
                'role' => 'client',
                'api_token' => Str::random(64),
            ]
        );

        $products = [
            ['name' => 'SU-100 Москва - Сочи', 'description' => 'Рейс SU-100, Вылет 12:00, Эконом класс', 'price' => 8500],
            ['name' => 'SU-202 Москва - Санкт-Петербург', 'description' => 'Рейс SU-202, Вылет 15:30, Эконом класс', 'price' => 4200],
            ['name' => 'SU-303 Москва - Казань', 'description' => 'Рейс SU-303, Вылет 18:00, Эконом класс', 'price' => 3500],
            ['name' => 'SU-404 Санкт-Петербург - Сочи', 'description' => 'Рейс SU-404, Вылет 09:15, Бизнес класс', 'price' => 15900],
            ['name' => 'SU-505 Москва - Екатеринбург', 'description' => 'Рейс SU-505, Вылет 21:45, Эконом класс', 'price' => 6300],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
