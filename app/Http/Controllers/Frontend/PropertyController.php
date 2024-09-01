<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Repositories\PostRepository;

class PropertyController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->fetchProperties(9);
        return view("ui.properties", compact("posts"));
    }

    public function buy()
    {
        $posts = $this->postRepository->buyProperties(9);
        return view("ui.buy-properties", compact("posts"));
    }

    public function rent()
    {
        $posts = $this->postRepository->rentProperties(9);
        return view("ui.rent-properties", compact("posts"));
    }

    public function search(Request $request)
    {
        $posts = $this->postRepository->searchProperties(9, $request->all());
        return view("ui.search-properties", compact("posts"));
    }

    public function details($category, $subCategory, $slug, Request $request)
    {
        $post = $this->postRepository->findBySlug($slug);

        $sessionViewArray = $request->session()->get("sessionViewArray");
        if (!$sessionViewArray) {
            $request->session()->put("sessionViewArray", [$post->id]);
            //increase view of post
            $this->postRepository->update($post->id, [
                "view" => DB::raw('view+1')
            ]);
        } else {
            if (!in_array($post->id, $sessionViewArray)) {
                array_push($sessionViewArray, $post->id);
                $request->session()->put("sessionViewArray", $sessionViewArray);
                //increase view of post
                $this->postRepository->update($post->id, [
                    "view" => DB::raw('view+1')
                ]);
            }
        }

        $popularPosts = $this->postRepository->popularPosts($post->id);
        return view("ui.property-detail", compact("post", "popularPosts"));
    }
}
