<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\ContactMessageRepository;

class MessageController extends Controller
{
    protected $messageRepository;

    public function __construct(ContactMessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function index(){
        $messages = $this->messageRepository->paginate(10);
        return view('frontend.dashboard.message', compact('messages'));
    }

    public function respond($id){
        $this->messageRepository->update($id, [
            "is_responded" => "yes"
        ]);

        return "success";
    }
}
