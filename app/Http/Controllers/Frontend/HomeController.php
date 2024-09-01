<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\PostRepository;
use Repositories\UserRepository;

class HomeController extends Controller
{
    protected $postRepository, $agentRepository;

    public function __construct(PostRepository $postRepository, UserRepository $agentRepository)
    {
        $this->postRepository = $postRepository;
        $this->agentRepository = $agentRepository;
    }

    public function index(){
        $posts = $this->postRepository->fetchHomePost();
        $agents = $this->agentRepository->fetchHomeAgents();
        return view("ui.home", compact("posts", "agents"));
    }
}
