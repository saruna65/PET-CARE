<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::with('user');

        // Apply search filters
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pet_name', 'like', "%{$search}%")->orWhere('pet_breed', 'like', "%{$search}%");
            });
        }

        // Filter by pet type
        if ($request->has('type') && $request->type != '') {
            $query->where('pet_type', $request->type);
        }

        // Filter by sex
        if ($request->has('sex') && $request->sex != '') {
            $query->where('sex', $request->sex);
        }

        $pets = $query->latest()->paginate(12);

        return view('petindex', compact('pets'));
    }

    public function details($pet)
    {
        // For admin, ensure they can see all pets
        $pet = Pet::with(['user', 'diseaseDetections'])->findOrFail($pet);

        return view('pets.details', compact('pet'));
    }
}
