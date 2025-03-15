<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AirtimeTopupController extends Controller
{
    public function index()
    {
        return Inertia::render('airtime/history');
    }

    public function create()
    {
        return Inertia::render('airtime/create');
    }
}