<?php
/**
 * Created by PhpStorm.
 * User: Nirmal
 * Date: 24-Dec-20
 * Time: 8:05 PM
 */

namespace Repositories;


use App\AgentRating;

class AgentRatingRepository extends BaseRepository
{
    protected $model;

    public function __construct(AgentRating $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function createOrUpdate($data)
    {
        return $this->model->updateOrCreate(
            ['user_id' => $data['user_id'], 'agent_id' => $data['agent_id']],
            ['rate' => $data['rate'], 'review' => $data['review'], 'publish' => 'No']
        );
    }

    public function findByAgentAndUser($agentId, $userId){
        return $this->model->where("agent_id", $agentId)->where("user_id", $userId)->first();
    }

    public function paginate($limit)
    {
        return $this->model->with(["agent", "user"])->orderByDesc("id")->paginate($limit);
    }

    public function paginateAgentRating($agentId, $limit){
        return $this->model->where("agent_id", $agentId)->where("publish", "yes")->with("user")->paginate($limit);
    }
}