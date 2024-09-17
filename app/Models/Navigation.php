<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // relasi agar menu utama bereleasi dengan sub-menu
    // 1 menu utama bisa mempunyai banyak sub-menu
    public function subMenus()
    {
        return $this->hasMany(Navigation::class, 'main_menu');
    }
}
