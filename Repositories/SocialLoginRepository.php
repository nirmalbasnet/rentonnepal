<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 30-Nov-20
 * Time: 9:55 PM
 */

namespace Repositories;


use App\SocialLogin;

class SocialLoginRepository extends BaseRepository
{
    protected $model;

    public function __construct(SocialLogin $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function findByProviderId($providerId){
        return $this->model->where("provider_id", $providerId)->first();
    }
}