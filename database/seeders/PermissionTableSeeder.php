<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            
            //Product
            'product-list',
            'product-create',
            'product-destroy',
            'product-show',
            'product-edit',

            //Buy Product
            'buy-product-list',
            'buy-product-create-list',
           
            //Customer
           'customer-list',
           'customer-create-list',
           'customer-edit-list',
           'customer-delete-list',

           //User
            'user-list',
            'user-show',
            'user-create',
            'user-edit',
            'user-delete',
           
            //Role
            'role-list',
            'role-show',
            'role-create',
            'role-edit',
            'role-delete',

            //Invoice
            'invoice',
            'payment',



        ];
        
        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
