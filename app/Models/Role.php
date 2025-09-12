<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';
    protected $primaryKey = 'RolId';
    public $timestamps = true;
    protected $fillable = [
        'Nombre',
        'Estado'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'rol', 'RolId');
    }
}
