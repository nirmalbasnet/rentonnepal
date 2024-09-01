<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Repositories\AgentRatingRepository;

class AgentRatingController extends Controller
{
    protected $agentRatingRepository;

    public function __construct(AgentRatingRepository $agentRatingRepository)
    {
        $this->agentRatingRepository = $agentRatingRepository;
    }

    public function index(){
        $data = $this->agentRatingRepository->paginate(10);
        return view("frontend.dashboard.agent-rating.list", compact("data"));
    }

    public function changePublishStatus($id)
    {
        $newPublishStatus = "Yes";

        $rating = $this->agentRatingRepository->findById($id);

        if ($rating->publish === "Yes")
            $newPublishStatus = "No";

        $this->agentRatingRepository->update($id, [
            "publish" => $newPublishStatus
        ]);

        return "success";
    }

    public function delete($id){
        $this->agentRatingRepository->delete($id);
        return redirect()->back()->withSuccess("Data deleted successfully");
    }
}
