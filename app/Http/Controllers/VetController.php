<?php


namespace App\Http\Controllers;

use App\Models\Vet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VetController extends Controller
{
    /**
     * Display a listing of vets.
     */
    public function index(Request $request): View
    {
        $query = Vet::with('user')->where('is_verified', true);
        
        // Apply search filters if provided
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })
            ->orWhere('specialization', 'LIKE', "%{$search}%")
            ->orWhere('clinic_name', 'LIKE', "%{$search}%")
            ->orWhere('city', 'LIKE', "%{$search}%")
            ->orWhere('state', 'LIKE', "%{$search}%");
        }
        
        // Filter by specialization
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->input('specialization'));
        }
        
        $vets = $query->paginate(8);
        return view('vet.index', compact('vets'));
    }
    
    /**
     * Display the specified vet.
     */
    public function show(string $id): View
    {
        $vet = Vet::with('user')->findOrFail($id);
        return view('vet.show', compact('vet'));
    }

    /**
     * Show form for registering as a vet
     */
    public function registerForm(): View|RedirectResponse
    {
        // Check if the user is already a vet with profile
        if (Auth::user()->isVet() && Auth::user()->vetProfile) {
            return redirect()->route('vet.dashboard')
                ->with('info', 'You are already registered as a veterinarian.');
        }

        return view('vet.registervet');
    }

    /**
     * Process the vet registration
     */
    public function registerSubmit(Request $request): RedirectResponse
    {
        // Validate the form
        $validated = $request->validate([
            'clinic_name' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:70',
            'qualification' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:vets',
            'biography' => 'nullable|string',
            'services_offered' => 'nullable|array',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'vet_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'terms_accepted' => 'required|accepted',
        ]);

        // Start a transaction
        DB::beginTransaction();
        
        try {
            // Update the user's role if not already a vet
            $user = Auth::user();
            if (!$user->isVet()) {
                $user->role = 'vet';
                $user->save();
            }
            
            // Handle image upload
            if ($request->hasFile('vet_image')) {
                $validated['image_path'] = $request->file('vet_image')->store('vet-images', 'public');
            }
            
            // Set default verification status
            $validated['is_verified'] = false;
            
            // Create the vet profile
            $validated['user_id'] = Auth::id();
            
            // Remove terms_accepted as it's not a database field
            unset($validated['terms_accepted']);
            
            $vet = Vet::create($validated);
            
            DB::commit();
            
            return redirect()->route('vet.dashboard')
                ->with('success', 'Your veterinarian profile has been created! It will be reviewed by our team shortly.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'There was a problem creating your vet profile: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the vet dashboard
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $vet = $user->vetProfile;
        
        // Add any dashboard stats you need
        $stats = [
            'appointments' => 0, // Replace with actual appointment count
            'reviews' => 0, // Replace with actual review count
            'rating' => 0, // Replace with actual rating
        ];
        
        return view('vet.dashboard', compact('vet', 'stats'));
    }

    /**
     * Show the form for editing the vet profile
     */
    public function editProfile(): View
    {
        $user = Auth::user();
        $vet = $user->vetProfile;
        
        return view('vet.edit-profile', compact('vet'));
    }

    /**
     * Update the vet profile
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $vet = $user->vetProfile;
        
        $validated = $request->validate([
            'clinic_name' => 'nullable|string|max:255',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:70',
            'qualification' => 'required|string|max:255',
            'license_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vets')->ignore($vet->id)
            ],
            'biography' => 'nullable|string',
            'services_offered' => 'nullable|array',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'phone_number' => 'required|string|max:20',
            'website' => 'nullable|url|max:255',
            'consultation_fee' => 'nullable|numeric|min:0',
            'vet_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('vet_image')) {
            // Delete old image if exists
            if ($vet->image_path) {
                Storage::disk('public')->delete($vet->image_path);
            }
            $validated['image_path'] = $request->file('vet_image')->store('vet-images', 'public');
        }

        $vet->update($validated);

        return redirect()->route('vet.dashboard')
            ->with('success', 'Veterinarian profile updated successfully!');
    }
    
    /**
     * Create a vet dashboard view stub
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $vet = $user->vetProfile;
        
        // For now, just return a basic view
        return view('vet.dashboard', compact('vet'));
    }
}