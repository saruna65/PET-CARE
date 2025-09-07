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
        $query = Vet::with('user');
        
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
            return redirect()->route('vet.index')
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
            
            // Handle image upload
            if ($request->hasFile('vet_image')) {
                $validated['image_path'] = $request->file('vet_image')->store('vet-images', 'public');
            }
            
            // Set default verification status
            $validated['is_verified'] = false;
            $validated['is_available'] = false;
            
            // Create the vet profile
            $validated['user_id'] = Auth::id();
            
            // Remove terms_accepted as it's not a database field
            unset($validated['terms_accepted']);
            
            $vet = Vet::create($validated);
            
            // Only change role if not an admin
            if (!$user->is_admin) {
                $user->role = 'vet';
                $user->save();
            }
            
            DB::commit();
            
            return redirect()->route('vet.index')
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
     * Show the form for creating a new vet (admin only).
     */
    public function create(): View
    {
        // Get users who aren't already vets
        $users = User::whereDoesntHave('vetProfile')->orderBy('name')->get();
        
        return view('vet.create', compact('users'));
    }
    
    /**
     * Store a newly created vet in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:vets,user_id',
            'clinic_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:vets',
            'experience_years' => 'nullable|integer|min:0',
            'qualification' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'is_available' => 'boolean',
            'is_verified' => 'boolean',
        ]);
        
        // Set default values if not provided
        if (!isset($validated['is_available'])) {
            $validated['is_available'] = false;
        }
        
        if (!isset($validated['is_verified'])) {
            $validated['is_verified'] = true;  // Admin-created vets are verified by default
        }
        
        // Create the vet
        $vet = Vet::create($validated);
        
        // Update the user's role to 'vet' ONLY IF they're not an admin
        $user = User::find($request->user_id);
        
        // Preserve admin status if the user is an admin
        if (!$user->is_admin) {
            $user->role = 'vet';
            $user->save();
        } else {
            // If user is admin, just update role if they don't have one
            if (empty($user->role)) {
                $user->role = 'admin';
                $user->save();
            }
        }
        
        return redirect()->route('vet.index')
            ->with('success', 'Veterinarian registered successfully!');
    }
    
    /**
     * Show the form for editing the specified vet.
     */
    public function edit(string $id): View
    {
        $vet = Vet::with('user')->findOrFail($id);
        return view('vet.edit', compact('vet'));
    }
    
    /**
     * Update the specified vet in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $vet = Vet::findOrFail($id);
        
        $validated = $request->validate([
            'clinic_name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'license_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vets')->ignore($id)
            ],
            'experience_years' => 'nullable|integer|min:0',
            'qualification' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'is_available' => 'boolean',
            'is_verified' => 'boolean',
        ]);
        
        // Set default values if not provided
        if (!isset($validated['is_available'])) {
            $validated['is_available'] = false;
        }
        if (!isset($validated['is_verified'])) {
            $validated['is_verified'] = false;
        }
        
        $vet->update($validated);
        
        return redirect()->route('vet.index')
            ->with('success', 'Veterinarian updated successfully!');
    }
    
    /**
     * Remove the specified vet from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $vet = Vet::findOrFail($id);
        
        // Delete associated image if exists
        if ($vet->image_path) {
            Storage::disk('public')->delete($vet->image_path);
        }
        
        $vet->delete();
        
        return redirect()->route('vet.index')
            ->with('success', 'Veterinarian removed successfully!');
    }

    /**
     * Show form for registering a new user as a vet.
     */
    public function createWithUser(): View
    {
        return view('vet.create-with-user');
    }

    /**
     * Store a newly created user and vet profile.
     */
    public function storeWithUser(Request $request): RedirectResponse
{
    // Validate request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'clinic_name' => 'required|string|max:255',
        'specialization' => 'required|string|max:255',
        'license_number' => 'required|string|max:50|unique:vets',
        'experience_years' => 'required|integer|min:0',
        'qualification' => 'required|string|max:255',
        'biography' => 'nullable|string',
        'services_offered' => 'nullable|array',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'zip_code' => 'nullable|string|max:20',
        'phone_number' => 'required|string|max:20',
        'website' => 'nullable|string|max:255',
        'consultation_fee' => 'nullable|numeric|min:0',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'vet_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
    
    // Set default values
    if (!isset($validated['is_available'])) {
        $validated['is_available'] = false;
    }
    if (!isset($validated['is_verified'])) {
        $validated['is_verified'] = true;  // Admin-created vets are verified by default
    }
    
    // Start transaction
    DB::beginTransaction();
    
    try {
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'vet',
        ]);
        
        // Create vet profile data array
        $vetData = array_filter($validated, function($key) {
            return !in_array($key, ['name', 'email', 'password', 'password_confirmation', 'vet_image']);
        }, ARRAY_FILTER_USE_KEY);
        
        // Handle the website URL format
        if (!empty($vetData['website']) && !str_starts_with($vetData['website'], 'http')) {
            $vetData['website'] = 'https://' . $vetData['website'];
        }
        
        // Encode services_offered to JSON if it exists
        if (isset($vetData['services_offered'])) {
            $vetData['services_offered'] = json_encode($vetData['services_offered']);
        }
        
        $vetData['user_id'] = $user->id;
        
        // Handle image upload
        if ($request->hasFile('vet_image')) {
            $vetData['image_path'] = $request->file('vet_image')->store('vet-images', 'public');
        }
        
        $vet = Vet::create($vetData);
        
        DB::commit();
        
        return redirect()->route('vet.index')
            ->with('success', 'New veterinarian registered successfully with a user account!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'There was a problem creating the vet with user account: ' . $e->getMessage())
            ->withInput($request->except('password', 'password_confirmation'));
    }
}
}