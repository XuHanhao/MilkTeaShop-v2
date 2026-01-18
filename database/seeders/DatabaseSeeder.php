<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 创建角色：用户和管理员
        $roles = ['customer', 'admin'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $admin = User::firstOrCreate(
            ['email' => 'admin@milktea.local'],
            [
                'name' => '超级管理员',
                'password' => Hash::make('Admin@123'),
                'type' => 'admin',
                'status' => 'active',
            ],
        );
        $admin->assignRole('admin');

        $category = Category::firstOrCreate(
            ['slug' => 'classic-tea'],
            ['name' => '经典奶茶', 'sort_order' => 1],
        );

        Product::firstOrCreate(
            ['slug' => 'pearl-milk-tea'],
            [
                'category_id' => $category->id,
                'name' => '珍珠奶茶',
                'base_price' => 12.00,
                'stock' => 999,
                'status' => 'active',
                'sort_order' => 1,
            ],
        );
    }
}
