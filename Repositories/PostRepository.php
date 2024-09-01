<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 01-Dec-20
 * Time: 9:22 PM
 */

namespace Repositories;


use App\Post;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository
{
    protected $model;

    public function __construct(Post $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function fetchPostByUserId($userId){
        return $this->model->where("user_id", $userId)->orderBy("id", "DESC")->with(["postImages", "agent"])->paginate("10");
    }

    public function fetchPost($limit = 10){
        return $this->model->orderBy("id", "DESC")->with(["postImages", "agent"])->paginate($limit);
    }

    public function findById($id)
    {
        return $this->model->with("postImages")->find($id);
    }

    public function findBySlug($slug){
        return $this->model->with(["postImages", "agent"])->where("slug", $slug)->first();
    }

    public function postCount($id = null){
        if($id)
            return $this->model->where("user_id", $id)->count();

        return $this->model->count();
    }

    public function fetchHomePost(){
        return $this->model->where("published", "Yes")->with("postImages")->orderBy("id", "DESC")->limit(15)->get();
    }

    public function generateSlug($title, $exists = false){
        if(!$exists)
            $slug = Str::slug($title);
        else
            $slug = Str::slug($title)."-".uniqid();

        $checkIfSlugExists = $this->findBySlug($slug);

        if(!$checkIfSlugExists)
            return $slug;

        return $this->generateSlug($title, true);
    }

    public function fetchProperties($limit = 10){
        return $this->model->where("published", "Yes")->with(["postImages", "agent"])->orderBy("id", "DESC")->paginate($limit);
    }

    public function buyProperties($limit = 10){
        return $this->model->where("published", "Yes")->where("category", "sale")->with(["postImages", "agent"])->orderBy("id", "DESC")->paginate($limit);
    }

    public function rentProperties($limit = 10){
        return $this->model->where("published", "Yes")->where("category", "rent")->with(["postImages", "agent"])->orderBy("id", "DESC")->paginate($limit);
    }

    public function searchProperties($limit = 10, $filter){
        if(!isset($filter['keyword']))
            $filter['keyword'] = "";

        if(isset($filter['category']) && $filter['category'] === "Buy")
            $filter['category'] = "sale";

        return $this->model->where("category", $filter['category'])->where("sub_category", $filter['sub_category'])->where("published", "Yes")->where(function($query) use ($filter){
            $query->where('title', 'LIKE', '%'.$filter['keyword'].'%');
            $query->orWhere('location', 'LIKE', '%'.$filter['keyword'].'%');
            $query->orWhere('description', 'LIKE', '%'.strip_tags($filter['keyword']).'%');
        })->with(["postImages", "agent"])->orderBy("id", "DESC")->paginate($limit)->appends($filter);
    }

    public function popularPosts($excludedId = null){
        if($excludedId)
            return $this->model->where("published", "Yes")->where("id", "!=", $excludedId)->with(["postImages", "agent"])->orderBy("view", "DESC")->limit(6)->get();

        return $this->model->where("published", "Yes")->with(["postImages", "agent"])->orderBy("view", "DESC")->limit(6)->get();
    }

    public function totalDeals($uid){
        return $this->model->where("user_id", $uid)->whereIn("status", ["Rented", "Sold"])->count();
    }

    public function agentPublishedProperties($agent, $limit)
    {
        return $this->model->where("user_id", $agent->id)->where("published", "Yes")->orderBy("id", "DESC")->paginate($limit);
    }
}