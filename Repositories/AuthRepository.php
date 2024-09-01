<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 30-Nov-20
 * Time: 7:25 PM
 */

namespace Repositories;


use App\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function login($credentials, $remember = null){
        $remember = $remember === "on" ? true : false;
        return Auth::attempt($credentials, $remember);
    }
}