<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }

        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is superadmin and user? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'superadmin,user');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach ($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);

                if ($role->name == 'superadmin') {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('superadmin granted all the permissions');
                } else {
                    // for others by default only read access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }

                // create one user for each role
                $this->createUser($role);

                $user = User::where('name', '=', 'superadmin')->first()->uuid;
                $menus = [
                    ['menu_title' => 'Access Control', 'icon_class' => 'fal fa-cog', 'order' => 1, 'created_by' => $user],
                    ['menu_title' => 'System Logs', 'route_name' => 'logs', 'icon_class' => 'fal fa-shield-check', 'order' => 2, 'created_by' => $user],
                    ['menu_title' => 'Permission Management', 'route_name' => 'permissions.index', 'parent_id' => 1, 'order' => 1, 'created_by' => $user],
                    ['menu_title' => 'Menu Management', 'route_name' => 'menus.index', 'parent_id' => 1, 'order' => 2, 'created_by' => $user],
                    ['menu_title' => 'Role Management', 'route_name' => 'roles.index', 'parent_id' => 1, 'order' => 3, 'created_by' => $user],
                    ['menu_title' => 'User Management', 'route_name' => 'users.index', 'parent_id' => 1, 'order' => 4, 'created_by' => $user],
                ];
                $this->command->getOutput()->createProgressBar(count($menus));
                $this->command->getOutput()->progressStart();
                foreach ($menus as $menu) {
                    Menu::create($menu);
                    $this->command->getOutput()->progressAdvance();
                }
                $this->command->getOutput()->progressFinish();
                $this->command->info('Data menu inserted to database');
                $role->menus()->attach(Menu::all());
                $this->command->info('superadmin granted all menus');
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');
        } else {
            Role::firstOrCreate(['name' => 'user']);
            $this->command->info('Added only default user role.');
        }

        // // now lets seed some posts for demo
        // factory(\App\Post::class, 30)->create();
        // $this->command->info('Some Posts data seeded.');
        // $this->command->warn('All done :)');
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        $user = User::create(['name' => 'superadmin', 'email' => 'superadmin@app.com', 'password' => Hash::make('password')]);
        //using tinker to generate user
        //$user = factory(User::class)->create();
        $user->assignRole($role->name);

        if ($role->name == 'superadmin') {
            $this->command->info('Here is your super admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "password"');
        }
    }
}
