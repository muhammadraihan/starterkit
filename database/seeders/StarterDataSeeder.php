<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class StarterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get default permissions data
        $permissions = Permission::defaultPermissions();

        if ($this->command->confirm('This command will migrate table and seed data for this starter kit can run basic function, do you want to proceed?', true)) {
            // Migrate table
            $this->command->warn("Migrating table");
            $this->command->call('migrate');
            $this->command->info("All table migrated");
            $this->command->newLine();

            // Seed defaut permission data
            $this->command->warn("Seeding default permissions data");
            $this->command->getOutput()->createProgressBar(count($permissions));
            $this->command->getOutput()->progressStart();
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info(count($permissions) . " default permission inserted to database");
            $this->command->newLine();

            // Seed superadmin role
            $this->command->warn("Add new role");
            $this->command->warn("Please provide role name");
            $role = $this->command->ask('Enter role name (exp: superadmin or superuser)');
            $this->command->newLine();
            $superadmin_role = Role::firstOrCreate(['name' => trim($role)]);
            $this->command->info("Role " . $superadmin_role->name . " inserted to database");
            $this->command->newLine();

            // Sync default permissions to role provided
            $this->command->warn("Sync all permission to " . $superadmin_role->name);
            $superadmin_role->syncPermissions(Permission::all());
            $this->command->info($superadmin_role->name . " granted all default permissions");
            $this->command->newLine();

            // Seed superadmin user
            $this->command->warn("Add new user");
            $this->command->warn("Please provide user data");
            $this->command->newLine();
            $fullname = $this->command->ask('Enter full name');
            $email = $this->command->ask('Enter email');
            $password = $this->command->ask('Enter password');
            $this->command->newLine();
            $user = User::create(['name' => $fullname, 'email' => $email, 'password' => Hash::make($password)]);
            $this->command->info("User inserted to database");
            $this->command->newLine();

            // Sync provided user to provided role
            $user->assignRole($superadmin_role->name);
            $this->command->info("Sync " . $superadmin_role->name . " to user " . $user->name);
            $this->command->newLine();

            // Seed basic menu
            $menus = [
                ['menu_title' => 'Access Control', 'icon_class' => 'fal fa-cog', 'order' => 1, 'created_by' => $user->uuid],
                ['menu_title' => 'System Logs', 'route_name' => 'logs', 'icon_class' => 'fal fa-shield-check', 'order' => 2, 'created_by' => $user->uuid],
                ['menu_title' => 'Permission Management', 'route_name' => 'permissions.index', 'parent_id' => 1, 'order' => 1, 'created_by' => $user->uuid],
                ['menu_title' => 'Menu Management', 'route_name' => 'menus.index', 'parent_id' => 1, 'order' => 2, 'created_by' => $user->uuid],
                ['menu_title' => 'Role Management', 'route_name' => 'roles.index', 'parent_id' => 1, 'order' => 3, 'created_by' => $user->uuid],
                ['menu_title' => 'User Management', 'route_name' => 'users.index', 'parent_id' => 1, 'order' => 4, 'created_by' => $user->uuid],
            ];
            $this->command->warn("Seeding basic menu data");
            $this->command->getOutput()->createProgressBar(count($menus));
            $this->command->getOutput()->progressStart();
            foreach ($menus as $menu) {
                Menu::create($menu);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info('Data menu inserted to database');
            // Attach menu to provided role
            $superadmin_role->menus()->attach(Menu::all());
            $this->command->info('Granted all menus to ' . $superadmin_role->name);
            $this->command->newLine();
            $this->command->warn('All data is set up!');
            $this->command->newLine();
            // Provide login information to screen
            $this->command->info('Here user details to login:');
            $this->command->warn('Email: ' . $email);
            $this->command->warn('Password: ' . $password);
            $this->command->newLine();
            $this->command->info('Have a nice day :)');
        }
    }
}
