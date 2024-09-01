<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Repositories\PostRepository;
use Repositories\UserRepository;

class DashboardController extends Controller
{
    protected $agentRepository, $postRepository;

    public function __construct(UserRepository $agentRepository, PostRepository $postRepository)
    {
        $this->agentRepository = $agentRepository;
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $agentCount = $this->agentRepository->agentCount();

        if (Auth::user()->user_type == "admin")
            $postCount = $this->postRepository->postCount();
        else
            $postCount = $this->postRepository->postCount(Auth::id());

        return view("frontend.dashboard.dashboard", compact('agentCount', 'postCount'));
    }
}
