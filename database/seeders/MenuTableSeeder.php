<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('name', '=', 'superadmin')->first()->uuid;
        $menus = [
            ['menu_title' => 'Access Control', 'icon_class' => 'fal fa-cog', 'order' => 1, 'created_by' => $user],
            ['menu_title' => 'System Logs', 'route_name' => 'logs', 'icon_class' => 'fal fa-shield-check', 'order' => 2, 'created_by' => $user],
            ['menu_title' => 'User Management', 'route_name' => 'users.index', 'icon_class' => 'fal fa-cog', 'parent_id' => 1, 'order' => 1, 'created_by' => $user],
            ['menu_title' => 'Permission Management', 'route_name' => 'permissions.index', 'icon_class' => 'fal fa-cog', 'parent_id' => 1, 'order' => 2, 'created_by' => $user],
            ['menu_title' => 'Role Management', 'route_name' => 'roles.index', 'icon_class' => 'fal fa-cog', 'parent_id' => 1, 'order' => 3, 'created_by' => $user],
        ];
        if ($this->command->confirm('Create basic menu? [y|N]', true)) {
            $this->command->getOutput()->createProgressBar(count($menus));
            $this->command->getOutput()->progressStart();
            foreach ($menus as $menu) {
                Menu::create($menu);
                $this->command->getOutput()->progressAdvance();
            }
            $this->command->getOutput()->progressFinish();
            $this->command->info('Data witel inserted to database');
        }
    }
}
