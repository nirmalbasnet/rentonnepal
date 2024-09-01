<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 18-Sep-20
 * Time: 10:27 PM
 */

namespace Repositories;

class BaseRepository
{
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($uid, $data)
    {
        return $this->model->find($uid)->update($data);
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

    public function paginate($limit){
        return $this->model->orderBy("id", "DESC")->paginate($limit);
    }

    public function generateFileName()
    {
        return uniqid() . time();
    }
}