<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $table = 'detail_users';

    protected $fillable = [
        'user_id', 
        'program_reguler', 
        'semester', 
        'IPK', 
        'Umur', 
        'status_beasiswa', 
        'jurusan'
    ];

    /**
     * Get the user that owns the detail.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
