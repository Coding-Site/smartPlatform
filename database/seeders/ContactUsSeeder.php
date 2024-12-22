<?php

namespace Database\Seeders;

use App\Models\ContactUs\ContactUs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::create(['name' => 'John Doe', 'email' => 'john@example.com', 'message' => 'Hello, this is a test message.']);
        ContactUs::create(['name' => 'Jane Smith', 'email' => 'jane@example.com', 'message' => 'Hi, this is another test message.']);
        ContactUs::create(['name' => 'Alice Johnson', 'email' => 'alice@example.com', 'message' => 'Greetings, this is a sample message.']);
        ContactUs::create(['name' => 'Bob Brown', 'email' => 'bob@example.com', 'message' => 'Hey, this is a demo message.']);
        ContactUs::create(['name' => 'Charlie Davis', 'email' => 'charlie@example.com', 'message' => 'Hello, this is a test contact.']);    }
}
