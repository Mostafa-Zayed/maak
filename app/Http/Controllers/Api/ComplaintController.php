<?php

namespace App\Http\Controllers\Api;

use App\Models\Complaint;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\StoreComplaintRequest;

class ComplaintController extends Controller
{
    use ResponseTrait;

    public function StoreComplaint(StoreComplaintRequest $Request)
    {
        Complaint::create($Request->validated() + (['user_id' => auth()->id()]));
        return $this->successMsg(__('apis.complaint_send'));
    }
}
