<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::updateOrCreate(['slug' => 'admin'], ['name' => 'Admin']);
        Roles::updateOrCreate(['slug' => 'employee'], ['name' => 'Employee']);
        Roles::updateOrCreate(['slug' => 'customer'], ['name' => 'Customer']);

        // Add the two new roles
        Roles::updateOrCreate(['slug' => 'sales-employee'], ['name' => 'Sales Employee']);
        Roles::updateOrCreate(['slug' => 'purchase-employee'], ['name' => 'Purchase Employee']);
        Roles::updateOrCreate(['slug' => 'inventory-employee'], ['name' => 'Inventory Employee']);
        Roles::updateOrCreate(['slug' => 'warehouse-employee'], ['name' => 'Warehouse Employee']);
    }
}
