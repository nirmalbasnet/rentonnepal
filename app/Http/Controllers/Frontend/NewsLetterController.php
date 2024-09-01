<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Repositories\NewsLetterRepository;

class NewsLetterController extends Controller
{
    protected $newsLetterRepository;

    public function __construct(NewsLetterRepository $newsLetterRepository)
    {
        $this->newsLetterRepository = $newsLetterRepository;
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|unique:news_letters"
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();

            if ($error === "The email has already been taken.")
                $error = "The email has already been subscribed.";

            return $error;
        }

        $this->newsLetterRepository->create($request->all());

        return "success";
    }
}
