<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 06-Dec-20
 * Time: 1:06 AM
 */

namespace Repositories;


use App\NewsLetter;

class NewsLetterRepository extends BaseRepository
{
    protected $model;

    public function __construct(NewsLetter $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}