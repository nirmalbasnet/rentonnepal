<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 30-Nov-20
 * Time: 9:59 PM
 */

namespace Repositories;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findByEmail($email)
    {
        return $this->model->where("email", $email)->first();
    }

    public function findByid($id)
    {
        return $this->model->with("agentRating")->find($id);
    }

    public function findBySlug($slug)
    {
        return $this->model->with(["agentRating", "posts"])->where("slug", $slug)->first();
    }

    public function paginateAgent($limit)
    {
        return $this->model->where("user_type", "agent")->orderBy("id", "DESC")->paginate($limit);
    }

    public function paginateUser($limit)
    {
        return $this->model->where("user_type", "tenant")->orderBy("id", "DESC")->paginate($limit);
    }

    public function agentCount()
    {
        return $this->model->where("user_type", "agent")->count();
    }

    public function fetchHomeAgents()
    {
        $agents = $this->model->where('user_type', 'agent')->where('id', '!=', 7)->where('status', 'Active')->where('is_profile_completed', true)->with('posts')->limit(6)->get();

        $agents = $agents->sortByDesc(function($agent){
            return $agent->average_rating;
        });

        return $agents;
    }

    public function generateSlug($name, $exists = false)
    {
        if (!$exists)
            $slug = Str::slug($name);
        else
            $slug = Str::slug($name) . "-" . uniqid();

        $checkIfSlugExists = $this->findBySlug($slug);

        if (!$checkIfSlugExists)
            return $slug;

        return $this->generateSlug($name, true);
    }

    public function agents($limit){
       return $this->model->where("user_type", "agent")->where('id', '!=', 7)->where("status", "Active")->where("is_profile_completed", true)->orderBy("name", "ASC")->paginate($limit);
    }

    public function findUserBySlugAndToken($slug, $token){
        return $this->model->with(["agentRating", "posts"])->where("slug", $slug)->where('unique_token', $token)->first();
    }

    function generateUniqueToken()
    {
        return md5(rand(1, 10) . microtime());
    }
}