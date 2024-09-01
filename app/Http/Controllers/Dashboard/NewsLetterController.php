<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\NewsLetterRepository;

class NewsLetterController extends Controller
{
    protected $newsLetterRepository;

    public function __construct(NewsLetterRepository $newsLetterRepository)
    {
        $this->newsLetterRepository = $newsLetterRepository;
    }

    public function subscribers(){
        $subscribers = $this->newsLetterRepository->paginate(10);
        return view('frontend.dashboard.newsletter.subscribers', compact('subscribers'));
    }
}
