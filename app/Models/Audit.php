<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'action', 'table_name', 'old_data', 'new_data'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function roles()
    {
        return $this->belongsTo(Rol::class);
    }
}
