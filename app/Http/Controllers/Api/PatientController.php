<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List semua pendaftaran',
            'data' => $applications->map(function ($application) {
                return [
                    'id' => $application->id,
                    'status' => $application->status,
                    'surat_rujukan' => Storage::url($application->referral_letter_path),
                    'tanggal' => $application->created_at->format('Y-m-d H:i:s'),
                ];
            }),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
    }
}
