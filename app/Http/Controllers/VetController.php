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

public function dashboard(Request $request): View
{
    $user = Auth::user();
    $vet = $user->vetProfile;
    
    // Query for diseases with filters
    $query = \App\Models\VetDisease::with(['pet', 'user']);
    
    // Filter by reviewed status
    if ($request->has('status')) {
        if ($request->status === 'unreviewed') {
            $query->where('is_reviewed', false);
        } elseif ($request->status === 'reviewed') {
            $query->where('is_reviewed', true);
        }
    } else {
        // By default, show unreviewed cases first
        $query->orderBy('is_reviewed', 'asc');
    }
    
    // Get diseases with pagination
    $recentDiseases = $query->orderBy('created_at', 'desc')->paginate(10);
    
    // Count all unreviewed cases
    $unreviewedCount = \App\Models\VetDisease::where('is_reviewed', false)->count();
    
    // Add dashboard stats
    $stats = [
        'appointments' => 0, // Replace with actual appointment count when implemented
        'reviews' => 0, // Replace with actual review count when implemented
        'rating' => 0, // Replace with actual rating when implemented
        'unreviewed' => $unreviewedCount
    ];
    
    return view('vet.vetdashboard', compact('vet', 'stats', 'recentDiseases'));
}

/**
 * Get all disease cases for vets
 */
public function allDiseases(Request $request): View
{
    $query = \App\Models\VetDisease::with(['pet', 'user']);
    
    // Filter by reviewed status
    if ($request->has('status')) {
        if ($request->status === 'unreviewed') {
            $query->where('is_reviewed', false);
        } elseif ($request->status === 'reviewed') {
            $query->where('is_reviewed', true);
        }
    }
    
    $diseases = $query->orderBy('created_at', 'desc')->paginate(10);
    
    return view('vet.diseases', compact('diseases'));
}

/**
 * Get disease details as JSON for the modal
 */
public function getDiseaseDetails(string $id)
{
    $disease = \App\Models\VetDisease::with(['pet', 'user'])->findOrFail($id);
    
    // Recommendations database - same as in PetController
    $recommendations = [
        "Hypersensivity Allergic dermatosis" => '
            <div class="text-red-800 font-medium mb-2">Hypersensitivity/Allergic Dermatosis Detected</div>
            <p class="mb-2">Your pet appears to have signs of allergic dermatosis. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Schedule a veterinary visit as soon as possible to confirm diagnosis</li>
                <li>Try to identify and remove potential allergens from your pet\'s environment</li>
                <li>Consider hypoallergenic pet food recommended by your veterinarian</li>
                <li>Avoid using harsh chemical cleaners around your home</li>
                <li>Regular bathing with vet-recommended medicated shampoo may help</li>
                <li>Do not use human medications without veterinary guidance</li>
            </ul>
        ',
        "Fungal Infections" => '
            <div class="text-red-800 font-medium mb-2">Fungal Infection Detected</div>
            <p class="mb-2">Your pet appears to have signs of a fungal infection. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Visit your veterinarian for proper diagnosis and treatment</li>
                <li>Keep the affected areas clean and dry</li>
                <li>Your vet may prescribe antifungal medications, shampoos or creams</li>
                <li>Follow the complete treatment course, even if symptoms improve</li>
                <li>Disinfect bedding, brushes and other items your pet frequently uses</li>
                <li>Some fungal infections can spread to humans, so practice good hygiene</li>
                <li>Consider isolating your pet from other animals until the infection clears</li>
            </ul>
        ',
        "Bacterial dermatosis" => '
            <div class="text-red-800 font-medium mb-2">Bacterial Dermatosis Detected</div>
            <p class="mb-2">Your pet appears to have signs of bacterial skin infection. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Consult with your veterinarian for proper diagnosis and treatment</li>
                <li>Antibiotics are typically needed and must be prescribed by a professional</li>
                <li>Keep the affected area clean using a gentle antiseptic solution recommended by your vet</li>
                <li>Prevent your pet from scratching, licking, or biting the affected areas</li>
                <li>Complete the full course of antibiotics even if symptoms improve</li>
                <li>Check for underlying causes like allergies or parasites</li>
                <li>Regular bathing with medicated shampoos may be recommended</li>
            </ul>
        ',
    ];
    
    $recommendationHtml = null;
    if (isset($recommendations[$disease->primary_diagnosis])) {
        $recommendationHtml = $recommendations[$disease->primary_diagnosis];
    }
    
    // Get pet details if available
    $pet = $disease->pet;
    $petImage = $pet && $pet->image_path 
        ? asset('storage/' . $pet->image_path) 
        : asset('images/default-pet.png');
    
    // Return detection data as JSON
    return response()->json([
        'id' => $disease->id,
        'pet_id' => $disease->pet_id,
        'pet_name' => $pet ? $pet->pet_name : 'Unknown Pet',
        'pet_breed' => $pet ? $pet->pet_breed : '',
        'pet_age' => $pet ? $pet->formatted_age : '',
        'pet_image' => $petImage,
        'owner_name' => $disease->user ? $disease->user->name : 'Unknown Owner',
        'primary_diagnosis' => $disease->primary_diagnosis,
        'confidence_score' => $disease->confidence_score,
        'results' => $disease->results,
        'image_url' => asset('storage/' . $disease->image_path),
        'created_at' => $disease->created_at,
        'recommendation_html' => $recommendationHtml,
        'detection_reason' => $disease->detection_reason,
        'is_reviewed' => $disease->is_reviewed
    ]);
}

/**
 * Mark a case as reviewed
 */
public function markDiseaseReviewed(string $id): RedirectResponse
{
    $disease = \App\Models\VetDisease::findOrFail($id);
    $disease->update(['is_reviewed' => true]);
    
    return back()->with('success', 'Case marked as reviewed.');
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

/**
 * Display detailed disease view page with review form
 */
public function viewDisease(string $id): View
{
    // Get the disease with related data
    $disease = \App\Models\VetDisease::with(['pet', 'user'])->findOrFail($id);
    
    // Get pet details if available
    $pet = $disease->pet;
    
    // Get recommendations database - same as in other methods
    $recommendations = [
        "Hypersensivity Allergic dermatosis" => '
            <div class="text-red-800 font-medium mb-2">Hypersensitivity/Allergic Dermatosis Detected</div>
            <p class="mb-2">Your pet appears to have signs of allergic dermatosis. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Schedule a veterinary visit as soon as possible to confirm diagnosis</li>
                <li>Try to identify and remove potential allergens from your pet\'s environment</li>
                <li>Consider hypoallergenic pet food recommended by your veterinarian</li>
                <li>Avoid using harsh chemical cleaners around your home</li>
                <li>Regular bathing with vet-recommended medicated shampoo may help</li>
                <li>Do not use human medications without veterinary guidance</li>
            </ul>
        ',
        "Fungal Infections" => '
            <div class="text-red-800 font-medium mb-2">Fungal Infection Detected</div>
            <p class="mb-2">Your pet appears to have signs of a fungal infection. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Visit your veterinarian for proper diagnosis and treatment</li>
                <li>Keep the affected areas clean and dry</li>
                <li>Your vet may prescribe antifungal medications, shampoos or creams</li>
                <li>Follow the complete treatment course, even if symptoms improve</li>
                <li>Disinfect bedding, brushes and other items your pet frequently uses</li>
                <li>Some fungal infections can spread to humans, so practice good hygiene</li>
                <li>Consider isolating your pet from other animals until the infection clears</li>
            </ul>
        ',
        "Bacterial dermatosis" => '
            <div class="text-red-800 font-medium mb-2">Bacterial Dermatosis Detected</div>
            <p class="mb-2">Your pet appears to have signs of bacterial skin infection. Here are some recommendations:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Consult with your veterinarian for proper diagnosis and treatment</li>
                <li>Antibiotics are typically needed and must be prescribed by a professional</li>
                <li>Keep the affected area clean using a gentle antiseptic solution recommended by your vet</li>
                <li>Prevent your pet from scratching, licking, or biting the affected areas</li>
                <li>Complete the full course of antibiotics even if symptoms improve</li>
                <li>Check for underlying causes like allergies or parasites</li>
                <li>Regular bathing with medicated shampoos may be recommended</li>
            </ul>
        ',
    ];
    
    $recommendationHtml = null;
    if (isset($recommendations[$disease->primary_diagnosis])) {
        $recommendationHtml = $recommendations[$disease->primary_diagnosis];
    }
    
    return view('vet.disease-view', compact('disease', 'pet', 'recommendationHtml'));
}


/**
 * Submit a veterinary review for a disease case
 */
public function submitReview(Request $request, string $id): RedirectResponse
{
    // Find the disease
    $disease = \App\Models\VetDisease::findOrFail($id);
    
    // Validate the request
    $validated = $request->validate([
        'diagnosis' => 'required|string|max:255',
        'treatment' => 'required|string',
        'notes' => 'nullable|string',
    ]);
    
    // Explicitly handle is_critical as a boolean
    $is_critical = $request->has('is_critical');
    
    // Update the disease with the vet's review
    $disease->update([
        'vet_diagnosis' => $validated['diagnosis'],
        'vet_treatment' => $validated['treatment'],
        'vet_notes' => $validated['notes'],
        'is_critical' => $is_critical,
        'is_reviewed' => true,
        'reviewed_at' => now(),
        'reviewed_by' => Auth::id()
    ]);
    
    // You might want to notify the pet owner here
    // Notification::send($disease->user, new DiseaseReviewed($disease));
    
    return redirect()->route('vet.dashboard')
        ->with('success', 'Your review has been submitted successfully.');
}
}