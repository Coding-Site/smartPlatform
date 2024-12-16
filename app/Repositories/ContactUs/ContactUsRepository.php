<?php

namespace App\Repositories\ContactUs;

use App\Models\ContactUs\ContactUs;
use Exception;

class ContactUsRepository
{
    public function all()
    {
        try {
            return ContactUs::orderBy('id', 'DESC')->paginate();
        } catch (Exception $e) {
            throw new Exception('Error fetching contact us messages: ' . $e->getMessage());
        }
    }

    public function findById(ContactUs $contactUs): ?ContactUs
    {
        try {
            return $contactUs;
        } catch (Exception $e) {
            throw new Exception('Error fetching contact us message: ' . $e->getMessage());
        }
    }

    public function create(array $data): ContactUs
    {
        try {
            return ContactUs::create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating contact us message: ' . $e->getMessage());
        }
    }


    public function delete(ContactUs $contactUs): bool
    {
        try {
            return $contactUs->delete();
        } catch (Exception $e) {
            throw new Exception('Error deleting contact us message: ' . $e->getMessage());
        }
    }
}
