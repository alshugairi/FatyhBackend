<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permissions' => ['view', 'create', 'edit', 'delete'],
            'roles' => ['view', 'create', 'edit', 'delete'],
            'admins' => ['view', 'create', 'edit', 'delete'],
            'clients' => ['view', 'create', 'edit', 'delete'],
            'languages' => ['view', 'create', 'edit', 'delete'],
            'countries' => ['view', 'create', 'edit', 'delete'],
            'cities' => ['view', 'create', 'edit', 'delete'],
            'currencies' => ['view', 'create', 'edit', 'delete'],
            'pages' => ['view', 'create', 'edit', 'delete'],
            'faqs' => ['view', 'create', 'edit', 'delete'],
            'faq_groups' => ['view', 'create', 'edit', 'delete'],
            'sliders' => ['view', 'create', 'edit', 'delete'],
            'units' => ['view', 'create', 'edit', 'delete'],
            'brands' => ['view', 'create', 'edit', 'delete'],
            'products' => ['view', 'create', 'edit', 'delete'],
            'categories' => ['view', 'create', 'edit', 'delete'],
            'attributes' => ['view', 'create', 'edit', 'delete'],
            'coupons' => ['view', 'create', 'edit', 'delete'],
            'taxes' => ['view', 'create', 'edit', 'delete'],
            'return_reasons' => ['view', 'create', 'edit', 'delete'],
            'suppliers' => ['view', 'create', 'edit', 'delete'],
            'purchases' => ['view', 'create', 'edit', 'delete'],
            'collections' => ['view', 'create', 'edit', 'delete', 'view_products','add_products', 'delete_products'],
            'menus' => ['view', 'create', 'edit', 'delete'],
            'settings' => ['view', 'edit'],
            'contact' => ['view', 'delete'],
        ];

        $flattenedPermissions = [];
        foreach ($permissions as $group => $actions) {
            foreach ($actions as $action) {
                $flattenedPermissions[] = "$group.$action";
            }
        }

        //Permission::query()->delete();
        Permission::whereNotIn('name', $flattenedPermissions)->delete();

        foreach ($flattenedPermissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName],
                ['name' => $permissionName]
            );
        }

        // Assign all permissions to the admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $allPermissions = Permission::pluck('name')->toArray();

        $adminRole->givePermissionTo($allPermissions);

        $adminUser = User::where('email', 'admin@admin.com')->first();
        if ($adminRole) {
            $adminUser->assignRole($adminRole);
        }
    }
}
