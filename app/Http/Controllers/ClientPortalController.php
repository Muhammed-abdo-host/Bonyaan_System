<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientPortalController extends Controller
{
    public function index(Request $request): View
    {
        $projects = $request->user()
            ->projects()
            ->with([
                'siteUpdates' => fn ($query) => $query->latest(),
            ])
            ->latest()
            ->get();

        return view('client', compact('projects'));
    }
}