<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLatheTracking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'lathe_id', 'start', 'finish'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lathe()
    {
        return $this->belongsTo(Lathe::class, 'lathe_id');
    }
}
