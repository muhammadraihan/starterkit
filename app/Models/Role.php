<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;

class Role extends \Spatie\Permission\Models\Role
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'guard_name',
    ];

    /**
     * The attibutes for logging the event change
     *
     * @var array
     */
    protected static $logAttributes = ['name', 'guard_name'];

    /**
     * Logging name
     *
     * @var string
     */
    protected static $logName = 'role';

    /**
     * Logging only the changed attributes
     *
     * @var boolean
     */
    protected static $logOnlyDirty = true;

    /**
     * Prevent save logs items that have no changed attribute
     *
     * @var boolean
     */
    protected static $submitEmptyLogs = false;

    /**
     * Custom logging description
     *
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Data has been {$eventName}";
    }

    /**
     * The menu that belong to the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Models\Menu');
    }

    /**
     * Method to retrive if role has menu
     *
     * @param int $role_id
     * @param int $menu_item
     * @return boolean
     */
    public function hasMenu($role_id, $menu_item): bool
    {
        $role_menus = MenuRole::select('menu_id')->where('menu_id', $menu_item)->where('role_id', $role_id)->first();
        if ($role_menus) {
            return true;
        }
        return false;
    }
}
