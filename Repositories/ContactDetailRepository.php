<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 05-Dec-20
 * Time: 11:36 PM
 */

namespace Repositories;


use App\ContactDetail;

class ContactDetailRepository extends BaseRepository
{
    protected $model;

    public function __construct(ContactDetail $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getContactDetails(){
        return $this->model->first();
    }
}