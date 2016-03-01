<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Permission;
use App\Models\Role;

class CreateBaseRolesAndPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $admin = Role::create([
            'name' => 'administrator',
            'label' => 'Administrator'
        ]);

        $updateApplication = Permission::create([
            'name' => 'update.application',
            'label' => 'Update the Application'
        ]);

        $manager = Role::create([
            'name' => 'manager',
            'label' => 'Site Manager'
        ]);

        $viewAdmin = Permission::create([
            'name' => 'view.admin',
            'label' => 'Visit the Admin Area'
        ]);

        $manager->givePermissionTo($viewAdmin);

        //users

        $viewUsers = Permission::create([
            'name' => 'view.users',
            'label' => 'View Users'
        ]);

        $manager->givePermissionTo($viewUsers);

        $createUsers = Permission::create([
            'name' => 'create.users',
            'label' => 'Create Users'
        ]);

        $manager->givePermissionTo($createUsers);

        $updateUsers = Permission::create([
            'name' => 'update.users',
            'label' => 'Update Users'
        ]);

        $manager->givePermissionTo($updateUsers);

        $deleteUsers = Permission::create([
            'name' => 'delete.users',
            'label' => 'Delete Users'
        ]);

        $manager->givePermissionTo($deleteUsers);


        //roles

        $viewRoles = Permission::create([
            'name' => 'view.roles',
            'label' => 'View Roles'
        ]);

        $manager->givePermissionTo($viewRoles);

        $createRoles = Permission::create([
            'name' => 'create.roles',
            'label' => 'Create Roles'
        ]);

        $manager->givePermissionTo($createRoles);

        $updateRoles = Permission::create([
            'name' => 'update.roles',
            'label' => 'Update Roles'
        ]);

        $manager->givePermissionTo($updateRoles);

        $deleteRoles = Permission::create([
            'name' => 'delete.roles',
            'label' => 'Delete Roles'
        ]);

        $manager->givePermissionTo($deleteRoles);


        //settings

        $viewSettings = Permission::create([
            'name' => 'view.settings',
            'label' => 'View Settings'
        ]);

        $manager->givePermissionTo($viewSettings);

        $updateSettings = Permission::create([
            'name' => 'update.settings',
            'label' => 'Update Settings'
        ]);

        $manager->givePermissionTo($updateSettings);


        $viewPages = Permission::create([
            'name' => 'view.pages',
            'label' => 'View Pages'
        ]);

        $manager->givePermissionTo($viewPages);

        $createPages = Permission::create([
            'name' => 'create.pages',
            'label' => 'Create Pages'
        ]);

        $manager->givePermissionTo($createPages);

        $updatePages = Permission::create([
            'name' => 'update.pages',
            'label' => 'Update Pages'
        ]);

        $manager->givePermissionTo($updatePages);

        $deletePages = Permission::create([
            'name' => 'delete.pages',
            'label' => 'Delete Pages'
        ]);

        $manager->givePermissionTo($deletePages);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::whereIn('name', [
            'view.admin',
            'update.application'
        ])->delete();

        Role::whereIn('name', [
            'administrator',
            'manager'
        ])->delete();
    }
}
