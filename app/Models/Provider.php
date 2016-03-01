<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 08/02/16
 * Time: 23:16
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'provider_data'
    ];

    protected $casts = [
        'provider_data' => 'object'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}