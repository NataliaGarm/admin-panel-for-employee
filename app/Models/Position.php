<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = "positions";

    protected $casts = [
        'created_at' => 'datetime:d.m.y H:i:s',
        'updated_at' => 'datetime:d.m.y H:i:s'
    ];

    /**
     * Get the employees that own the position.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class, 'position');
    }

    /**
     * Get the admin that created the position.
     */
    public function adminCreatedId()
    {
        return $this->belongsTo(User::class, 'admin_created_id')->withDefault();
    }

    /**
     * Get the admin that created the position.
     */
    public function adminUpdatedId()
    {
        return $this->belongsTo(User::class, 'admin_updated_id')->withDefault();
    }

    public static function getPositionsArray(array $positions)
    {
        return array_map(function($val){
            return $val['name'];
        }, $positions);
    }
}
