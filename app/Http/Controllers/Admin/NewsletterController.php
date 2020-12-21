<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsletterController extends Controller
{
    public function index()
    {
        $items = Newsletter::get();

        return Inertia::render('Admin/Newsletter', [
            'items' => $items
        ]);

    }
}
