<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 01-Dec-20
 * Time: 9:23 PM
 */

namespace Repositories;


use App\PostImage;

class PostImageRepository extends BaseRepository
{
    protected $model;

    public function __construct(PostImage $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function countPostImages($postId){
        return $this->model->where("post_id", $postId)->count();
    }
}