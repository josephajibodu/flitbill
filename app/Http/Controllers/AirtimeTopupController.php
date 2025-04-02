<?php

namespace App\Http\Controllers;

use App\Actions\Transactions\CreateAirtimeTransaction;
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

    public function store(Request $request, CreateAirtimeTransaction $airtimeTransaction)
    {
        $data = $request->validate([
            'phone_number' => ['required', 'string'],
            'network' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        try {
            $airtimeTransaction->execute($data);
        } catch (\Throwable $e) {
            return back()->withErrors("Airtime transaction failed");
        }

        return back();
    }
}