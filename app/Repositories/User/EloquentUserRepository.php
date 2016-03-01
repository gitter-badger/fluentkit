<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/01/16
 * Time: 18:01
 */

namespace App\Repositories\User;


use App\Repositories\Repository;
use App\Models\User;

class EloquentUserRepository extends Repository implements UserRepositoryInterface
{

    public function __construct(User $user){
        parent::__construct($user);
    }

}