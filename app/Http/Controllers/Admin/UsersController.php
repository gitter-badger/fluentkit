<?php
/**
 * Created by PhpStorm.
 * User: leemason
 * Date: 28/02/16
 * Time: 15:49
 */

namespace App\Http\Controllers\Admin;


use App\Repositories\User\UserRepositoryInterface;

class UsersController extends Controller
{

    protected $repo;

    public function __construct(UserRepositoryInterface $repo){

        $this->repo = $repo;

        parent::__construct();

        $this->middleware('can:view.users', ['only' => 'getIndex']);

        $this->middleware('can:edit.users', ['only' => 'getEdit']);
    }

    public function getIndex(){
        return view('admin.users.index')->with('page_title', trans('admin.users_title'));
    }

    public function getEdit($id){
        $user = $this->repo->findOrFail($id);
        return view('admin.users.edit')->with('page_title', trans('admin.users_title'))->with('id', $id);
    }

}