<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class DataTopupController extends Controller
{
    public function index()
    {
        return Inertia::render('data-topup/history');
    }

    public function create()
    {
        return Inertia::render('data-topup/create');
    }
}
