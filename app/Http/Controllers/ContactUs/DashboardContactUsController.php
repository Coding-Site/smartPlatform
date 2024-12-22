<?php

namespace App\Http\Controllers\ContactUs;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactUs\ContactUsResource;
use App\Models\ContactUs\ContactUs;
use App\Repositories\ContactUs\ContactUsRepository;

class DashboardContactUsController extends Controller
{

    protected $contactUsRepository;

    public function __construct(ContactUsRepository $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    public function index()
    {
        $contacts = $this->contactUsRepository->all();
        return ApiResponse::sendResponse(200, 'All Contacts', ContactUsResource::collection($contacts));
    }


    public function show(ContactUs $contactUs)
    {
        $contact = $this->contactUsRepository->findById($contactUs);
        return ApiResponse::sendResponse(200, 'Contact Details', new ContactUsResource($contact));
    }


    public function destroy(ContactUs $contactUs)
    {
        try {
            $this->contactUsRepository->delete($contactUs);
            return ApiResponse::sendResponse(200, 'Contact deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to delete contact');
        }
    }
}
