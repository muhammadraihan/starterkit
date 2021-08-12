<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRole extends Model
{
    use HasFactory;

    protected $table = 'menu_role';

    public function ParentMenu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
