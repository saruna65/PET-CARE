<?php


namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PetController extends Controller
{
    /**
     * Display a listing of the user's pets.
     */
    public function index(): View
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        return view('pets.index', compact('pets'));
    }

    /**
     * Show the form for creating a new pet.
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Store a newly created pet in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:100',
            'sex' => 'required|in:male,female',
            'allergies' => 'nullable|string',
            'pet_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle image upload if provided
        if ($request->hasFile('pet_image')) {
            $path = $request->file('pet_image')->store('pets', 'public');
            $validated['image_path'] = $path;
        }

        Pet::create($validated);

        return redirect()->route('pet.profile')
            ->with('success', 'Pet profile created successfully.');
    }

    /**
     * Show the form for editing the specified pet.
     */
    public function edit(string $id): View|RedirectResponse
    {
        $pet = Pet::where('user_id', Auth::id())->findOrFail($id);
        return view('pets.edit', compact('pet'));
    }

    /**
     * Update the specified pet in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $pet = Pet::where('user_id', Auth::id())->findOrFail($id);
        
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'pet_type' => 'required|string|max:255',
            'pet_breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:100',
            'sex' => 'required|in:male,female',
            'allergies' => 'nullable|string',
            'pet_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('pet_image')) {
            // Delete old image if it exists
            if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
                Storage::disk('public')->delete($pet->image_path);
            }
            
            $path = $request->file('pet_image')->store('pets', 'public');
            $validated['image_path'] = $path;
        }

        $pet->update($validated);

        return redirect()->route('pet.profile')
            ->with('success', 'Pet profile updated successfully.');
    }

    /**
     * Remove the specified pet from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $pet = Pet::where('user_id', Auth::id())->findOrFail($id);
        
        // Delete associated image if it exists
        if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
            Storage::disk('public')->delete($pet->image_path);
        }
        
        $pet->delete();

        return redirect()->route('pet.profile')
            ->with('success', 'Pet profile deleted successfully.');
    }
   
    
/**
 * Display the specified pet.
 */
public function show(string $id): View
{
    $pet = Pet::where('user_id', Auth::id())->findOrFail($id);
    
    // Get recent disease detections for this pet (limited to 3)
    $diseaseDetections = \App\Models\DiseaseDetection::where('pet_id', $pet->id)
        ->orderBy('created_at', 'desc')
        ->paginate(3);
    
    // Get vet disease detections for this pet (limited to 3)
    $vetDiseases = \App\Models\VetDisease::where('pet_id', $pet->id)
        ->orderBy('created_at', 'desc')
        ->paginate(3);
    
    return view('pets.show', compact('pet', 'diseaseDetections', 'vetDiseases'));
}

/**
 * Analyze disease from uploaded image and show results.
 */

public function analyzeDisease(Request $request, string $id): View
{
    // Validate the uploaded image and predictions
    $request->validate([
        'disease_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        'predictions_json' => 'required|json',
    ]);

    // Find the pet
    $pet = Pet::where('user_id', Auth::id())->findOrFail($id);
    
    // Store the uploaded image
    $uploadedImage = $request->file('disease_image')->store('disease-images', 'public');
    $uploadedDate = now()->format('F j, Y \a\t g:i A');
    
    // Get predictions from the request
    $predictions = json_decode($request->input('predictions_json'), true);
    
    // Map short class names to full class names if needed
    $classNameMap = [
        'Hypersensivi...' => 'Hypersensivity Allergic dermatosis',
        'Fungal Infec...' => 'Fungal Infections',
        'Bacterial de...' => 'Bacterial dermatosis',
        'Healthy' => 'Healthy'
    ];
    
    // Convert any shortened class names to full names
    foreach ($predictions as $key => $prediction) {
        if (isset($classNameMap[$prediction['className']])) {
            $predictions[$key]['className'] = $classNameMap[$prediction['className']];
        }
    }
    
    // Get the highest probability prediction for recommendation
    $highestPrediction = collect($predictions)->sortByDesc('probability')->first();
    $recommendationHtml = null;
    
    // Recommendations database - same as dashboard
    $recommendations = [
        "Hypersensivity Allergic dermatosis" => '
            <div class="text-red-800 font-medium mb-2">Hypersensitivity Allergic Dermatosis Detected</div>
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
        "Healthy" => '
            <div class="text-green-800 font-medium mb-2">No Issues Detected - Healthy Skin</div>
            <p class="mb-2">Great news! Your pet\'s skin appears healthy. Here are some tips to maintain skin health:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Continue regular grooming and bathing with pet-appropriate products</li>
                <li>Maintain a balanced diet with proper nutrition</li>
                <li>Schedule regular check-ups with your veterinarian</li>
                <li>Use parasite prevention as recommended by your vet</li>
                <li>Monitor for any changes in skin appearance or behavior</li>
                <li>Provide fresh water and a clean living environment</li>
            </ul>
        '
    ];
    
    if ($highestPrediction && isset($recommendations[$highestPrediction['className']])) {
        $recommendationHtml = $recommendations[$highestPrediction['className']];
    }
    
    // Save the results to the disease_detections table
    $diseaseDetection = new \App\Models\DiseaseDetection([
        'pet_id' => $pet->id,
        'user_id' => Auth::id(),
        'image_path' => $uploadedImage,
        'results' => $predictions,
        'primary_diagnosis' => $highestPrediction['className'],
        'confidence_score' => $highestPrediction['probability']
    ]);
    $diseaseDetection->save();
    
    // Determine if this case should be sent for veterinarian review
    $sendToVet = false;
    $detectionReason = null;
    
    // Cases where confidence is high for a condition (>70%)
    if ($highestPrediction['probability'] > 0.7 && $highestPrediction['className'] !== 'Healthy') {
        $sendToVet = true;
        $detectionReason = "High confidence disease detection (" . number_format($highestPrediction['probability'] * 100, 1) . "%)";
    }
    
    // If we need to send to vet, create a record in vet_diseases table
    if ($sendToVet) {
        // Create a VetDisease record
        $vetDisease = new \App\Models\VetDisease([
            'pet_id' => $pet->id,
            'user_id' => Auth::id(),
            'image_path' => $uploadedImage,
            'results' => $predictions,
            'primary_diagnosis' => $highestPrediction['className'],
            'confidence_score' => $highestPrediction['probability'],
            'is_reviewed' => false,
            'detection_reason' => $detectionReason
        ]);
        $vetDisease->save();
    }
    
    return view('pets.disease-results', compact(
        'pet', 
        'uploadedImage', 
        'uploadedDate', 
        'predictions', 
        'recommendationHtml',
        'diseaseDetection',
        'sendToVet',
        'detectionReason'
    ));
}

/**
 * Get detection details as JSON for the modal
 */
public function getDetectionDetails(string $petId, string $detectionId)
{
    $pet = Pet::where('user_id', Auth::id())->findOrFail($petId);
    $detection = \App\Models\DiseaseDetection::where('pet_id', $pet->id)
        ->findOrFail($detectionId);
    
    // Mapping for consistent class names
    $classNameMap = [
        'Hypersensivi...' => 'Hypersensivity Allergic dermatosis',
        'Fungal Infec...' => 'Fungal Infections',
        'Bacterial de...' => 'Bacterial dermatosis',
        'Healthy' => 'Healthy'
    ];
    
    // Convert primary diagnosis if needed
    $primaryDiagnosis = $detection->primary_diagnosis;
    if (isset($classNameMap[$primaryDiagnosis])) {
        $primaryDiagnosis = $classNameMap[$primaryDiagnosis];
    }
    
    // Convert result class names
    $results = $detection->results;
    if (is_array($results)) {
        foreach ($results as $key => $result) {
            if (isset($result['className']) && isset($classNameMap[$result['className']])) {
                $results[$key]['className'] = $classNameMap[$result['className']];
            }
        }
    }
    
    // Recommendations database - same as analyzeDisease
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
        "Healthy" => '
            <div class="text-green-800 font-medium mb-2">No Issues Detected - Healthy Skin</div>
            <p class="mb-2">Great news! Your pet\'s skin appears healthy. Here are some tips to maintain skin health:</p>
            <ul class="list-disc pl-5 space-y-1">
                <li>Continue regular grooming and bathing with pet-appropriate products</li>
                <li>Maintain a balanced diet with proper nutrition</li>
                <li>Schedule regular check-ups with your veterinarian</li>
                <li>Use parasite prevention as recommended by your vet</li>
                <li>Monitor for any changes in skin appearance or behavior</li>
                <li>Provide fresh water and a clean living environment</li>
            </ul>
        '
    ];
    
    $recommendationHtml = null;
    if (isset($recommendations[$primaryDiagnosis])) {
        $recommendationHtml = $recommendations[$primaryDiagnosis];
    }
    
    // Return detection data as JSON
    return response()->json([
        'id' => $detection->id,
        'pet_id' => $detection->pet_id,
        'primary_diagnosis' => $primaryDiagnosis,
        'confidence_score' => $detection->confidence_score,
        'results' => $results,
        'image_url' => asset('storage/' . $detection->image_path),
        'created_at' => $detection->created_at,
        'recommendation_html' => $recommendationHtml
    ]);
}

/**
 * Get vet disease details as JSON for the modal
 */
public function getVetDiseaseDetails(string $petId, string $diseaseId)
{
    $pet = Pet::where('user_id', Auth::id())->findOrFail($petId);
    $disease = \App\Models\VetDisease::where('pet_id', $pet->id)
        ->findOrFail($diseaseId);
    
    // Mapping for consistent class names
    $classNameMap = [
        'Hypersensivi...' => 'Hypersensivity Allergic dermatosis',
        'Fungal Infec...' => 'Fungal Infections',
        'Bacterial de...' => 'Bacterial dermatosis',
        'Healthy' => 'Healthy'
    ];
    
    // Convert primary diagnosis if needed
    $primaryDiagnosis = $disease->primary_diagnosis;
    if (isset($classNameMap[$primaryDiagnosis])) {
        $primaryDiagnosis = $classNameMap[$primaryDiagnosis];
    }
    
    // Convert result class names
    $results = $disease->results;
    if (is_array($results)) {
        foreach ($results as $key => $result) {
            if (isset($result['className']) && isset($classNameMap[$result['className']])) {
                $results[$key]['className'] = $classNameMap[$result['className']];
            }
        }
    }
    
    // Get reviewer name if available
    $reviewerName = null;
    if ($disease->reviewed_by) {
        $reviewer = \App\Models\User::find($disease->reviewed_by);
        $reviewerName = $reviewer ? $reviewer->name : null;
    }
    
    // Return disease data as JSON
    return response()->json([
        'id' => $disease->id,
        'pet_id' => $disease->pet_id,
        'primary_diagnosis' => $primaryDiagnosis,
        'vet_diagnosis' => $disease->vet_diagnosis,
        'vet_treatment' => $disease->vet_treatment,
        'vet_notes' => $disease->vet_notes,
        'confidence_score' => $disease->confidence_score,
        'results' => $results,
        'image_url' => asset('storage/' . $disease->image_path),
        'created_at' => $disease->created_at,
        'reviewed_at' => $disease->reviewed_at,
        'is_reviewed' => $disease->is_reviewed,
        'is_critical' => $disease->is_critical,
        'reviewed_by' => $disease->reviewed_by,
        'reviewer_name' => $reviewerName
    ]);
}

/**
 * Print vet disease details
 */
public function printVetDisease(string $petId, string $diseaseId)
{
    $pet = Pet::where('user_id', Auth::id())->findOrFail($petId);
    $disease = \App\Models\VetDisease::where('pet_id', $pet->id)
        ->with('reviewer')
        ->findOrFail($diseaseId);
    
    return view('pets.print-vet-disease', compact('pet', 'disease'));
}

}