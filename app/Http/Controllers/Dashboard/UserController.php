<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->paginateUser(10);
        return view("frontend.dashboard.users.list", compact("users"));
    }

    public function changeStatus($uid, Request $request){
        $newStatus = $request->{'new-status'};

        $this->userRepository->update($uid, [
            "status" => $newStatus
        ]);

        return $newStatus;
    }
}
