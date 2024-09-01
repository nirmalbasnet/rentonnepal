<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 08-Dec-20
 * Time: 9:06 PM
 */

namespace Repositories;


use App\ContactMessage;

class ContactMessageRepository extends BaseRepository
{
    protected $model;

    public function __construct(ContactMessage $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }
}