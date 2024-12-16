<?php

namespace App\Http\Controllers\ContactUs;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUs\ContactUsRequest;
use App\Models\ContactUs\ContactUs;
use App\Repositories\ContactUs\ContactUsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{

    protected $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }


    public function create(ContactUsRequest $request)
    {
        try {
            $contact = $this->contactUsRepository->create($request->all());
            return ApiResponse::sendResponse(201, 'Contact created successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to create contact');
        }
    }
}
