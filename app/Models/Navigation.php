<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'icon', 'main_menu', 'sort'];

    // Anda bisa menambahkan relasi balik ke Permission jika diperlukan
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'navigation_id', 'id');
    }

    // Relasi ke sub-menus (self-referential relationship)
    public function subMenus()
    {
        return $this->hasMany(Navigation::class, 'main_menu', 'id')->orderBy('sort', 'asc');
    }
}
