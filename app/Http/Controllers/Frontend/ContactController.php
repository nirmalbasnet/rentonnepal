<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\ContactDetailRepository;
use Repositories\ContactMessageRepository;

class ContactController extends Controller
{
    protected $contactDetailRepository, $contactMessageRepository;

    public function __construct(ContactDetailRepository $contactDetailRepository, ContactMessageRepository $contactMessageRepository)
    {
        $this->contactDetailRepository = $contactDetailRepository;
        $this->contactMessageRepository = $contactMessageRepository;
    }

    public function index(){
        $contactDetail = $this->contactDetailRepository->getContactDetails();
        return view("ui.contact", compact('contactDetail'));
    }

    public function submit(Request $request){
        $this->validate($request, [
           "name" => "required",
           "email" => "required|email",
           "message" => "required|max:1000"
        ]);

        $this->contactMessageRepository->create($request->except('_token'));

        return redirect()->back()->withSuccess("Thank you for reaching us. We'll get back to you as soon as possible.");
    }
}
