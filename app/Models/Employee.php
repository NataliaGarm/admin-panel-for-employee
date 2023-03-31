<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Employee extends Model
{
    use HasFactory, \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

    protected $table = "employees";

    protected $casts = [
        //'phone' => E164PhoneNumberCast::class.':UA',
        'employment_date' => 'datetime:d.m.y',
        'created_at' => 'datetime:d.m.y H:i:s',
        'updated_at' => 'datetime:d.m.y H:i:s'
    ];

    public function getParentKeyName()
    {
        return 'head';
    }

    /**
     * Get the position that owns the employee.
     */
    public function positionEmployee()
    {
        return $this->belongsTo(Position::class, 'position');
    }

    /**
     * Get the admin that created the employee.
     */
    public function adminCreatedId()
    {
        return $this->belongsTo(User::class, 'admin_created_id')->withDefault();
    }

    /**
     * Get the admin that created the employee.
     */
    public function adminUpdatedId()
    {
        return $this->belongsTo(User::class, 'admin_updated_id')->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'head');
    }

    /*public function children()
    {
        return $this->hasMany(self::class, 'head');
    }*/

    public static function boot()
    {
        parent::boot();

        self::deleting(function($employee)
        {
            Employee::whereBelongsTo($employee, 'parent')->update(['head' => 1]);
        });
    }


    public static function getEmployeesArray($employees)
    {
        $employeesArray = [];
        foreach ($employees as $employee) {
           $descendantsAndSelf = $employee->descendantsAndSelf()->depthFirst()->get();
           $maxDepth = self::getMaxDepth($descendantsAndSelf);
            if ($maxDepth) $employeesArray += [$employee->id => $employee->name];
        }
        return  $employeesArray;
    }

    public static function getMaxDepth($descendantsAndSelf)
    {
        foreach ($descendantsAndSelf as $depth) {
            if ($depth->depth > 4) return false;
        }
        return true;
    }

}
