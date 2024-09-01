<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\ContactDetailRepository;

class ContactDetailController extends Controller
{
    protected $contactDetailRepository;

    public function __construct(ContactDetailRepository $contactDetailRepository)
    {
        $this->contactDetailRepository = $contactDetailRepository;
    }

    public function index()
    {
        $detail = $this->contactDetailRepository->getContactDetails();
        return view("frontend.dashboard.contact-details", compact('detail'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "phone" => "required",
            "facebook" => "required|url",
            "twitter" => "nullable|url",
            "linkedin" => "nullable|url",
            "instagram" => "nullable|url",
            "address" => "required",
            "google_map_iframe" => "required"
        ]);

        $checkExists = $this->contactDetailRepository->getContactDetails();

        if ($checkExists)
            $this->contactDetailRepository->update($checkExists->id, $request->except("_token"));
        else
            $this->contactDetailRepository->create($request->except("_token"));

        return redirect()->back()->withSuccess("Contact details submitted successfully");
    }
}
