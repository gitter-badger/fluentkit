<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = [
        'name',
        'label'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Grant the given permission to a role.
     *
     * @param  Permission $permission
     * @return mixed
     */
    public function givePermissionTo(Permission $permission)
    {
        if($this->hasPermission($permission->name)){
            return;
        }
        return $this->permissions()->save($permission);
    }

    public function hasPermission($permission){
        return $this->permissions->reject(function($item) use ($permission){return $item->name != $permission;})->count() == 1;
    }
}
