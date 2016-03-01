<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 24/01/16
 * Time: 18:01
 */

namespace App\Repositories\Provider;


use App\Models\Provider;
use App\Repositories\Repository;

class EloquentProviderRepository extends Repository implements ProviderRepositoryInterface
{

    public function __construct(Provider $user){
        parent::__construct($user);
    }

}