<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('pet.profile') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to all pets
                </a>
            </div>

            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <!-- Pet Profile Header -->
                <div class="relative">
                    <div class="h-64 bg-gradient-to-r from-indigo-500 to-purple-600">
                        @if($pet->image_path)
                            <img src="{{ $pet->image_url }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover opacity-60">
                        @endif
                    </div>
                    
                    <div class="absolute left-96 bottom-0 inset-x-0 p-6 text-white">
                        <h1 class="text-3xl font-bold">{{ $pet->pet_name }}</h1>
                        <p class="text-white/80">{{ $pet->pet_breed }}</p>
                    </div>
                    
                    <div class="absolute -bottom-16 left-6">
                        <div class="relative w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg">
                            <img src="{{ $pet->image_url }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    <div class="absolute top-4 right-4 flex space-x-3">
                        <!-- Disease Detection Button -->
                        <button type="button" onclick="openDiseaseModal()" class="inline-flex items-center px-4 py-2 bg-amber-500/80 hover:bg-amber-600/90 backdrop-blur-sm text-white rounded-lg transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Disease Detection
                        </button>
                        
                        <a href="{{ route('pet.edit', $pet->id) }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white rounded-lg transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Profile
                        </a>
                        
                        <form action="{{ route('pet.delete', $pet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this pet profile?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500/70 hover:bg-red-500/90 backdrop-blur-sm text-white rounded-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Pet Information -->
                <div class="mt-20 p-8">
                    <!-- Pet Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-indigo-50 p-4 rounded-xl text-center">
                            <span class="block text-indigo-400 text-sm font-medium uppercase tracking-wide">Type</span>
                            <span class="block text-indigo-800 text-xl font-bold mt-1">{{ $pet->pet_type }}</span>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-xl text-center">
                            <span class="block text-indigo-400 text-sm font-medium uppercase tracking-wide">Age</span>
                            <span class="block text-indigo-800 text-xl font-bold mt-1">{{ $pet->formatted_age }}</span>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-xl text-center">
                            <span class="block text-indigo-400 text-sm font-medium uppercase tracking-wide">Sex</span>
                            <span class="block text-indigo-800 text-xl font-bold mt-1">{{ $pet->capitalized_sex }}</span>
                        </div>
                    </div>
                    
                    <!-- Pet Details Sections -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                Basic Information
                            </h2>
                            <div class="bg-gray-50 p-5 rounded-xl">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Pet Name</dt>
                                        <dd class="mt-1 text-gray-900 font-medium">{{ $pet->pet_name }}</dd>
                                    </div>
                                    
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Breed</dt>
                                        <dd class="mt-1 text-gray-900 font-medium">{{ $pet->pet_breed }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Health Information
                            </h2>
                            <div class="bg-gray-50 p-5 rounded-xl">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500">Known Allergies</dt>
                                    <dd class="mt-1 text-gray-900">
                                        @if($pet->allergies)
                                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-2">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-yellow-700">
                                                            {{ $pet->allergies }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-600">No known allergies</p>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('pet.profile') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to All Pets
                        </a>
                        
                        <!-- Disease Detection Mobile Button -->
                        <button type="button" onclick="openDiseaseModal()" class="inline-flex items-center px-4 py-2 bg-amber-500 text-white rounded-lg shadow-md hover:bg-amber-600 transition duration-300 md:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                            </svg>
                            Disease Detection
                        </button>
                        
                        <a href="{{ route('pet.edit', $pet->id) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit Pet Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disease Detection History Section -->
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mt-8">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm4-1a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">Disease Detection History</h2>
                            <p class="text-amber-100">{{ $pet->pet_name }}'s previous health scans</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    @if(isset($diseaseDetections) && count($diseaseDetections) > 0)
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($diseaseDetections as $detection)
                                <div class="bg-gray-50 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition duration-300">
                                    <div class="flex">
                                        <!-- Detection Image -->
                                        <div class="w-1/3 h-28 bg-gray-200 rounded-l-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ asset('storage/' . $detection->image_path) }}" alt="Detection image" class="w-full h-full object-cover">
                                        </div>
                                        
                                        <!-- Detection Details -->
                                        <div class="p-4 flex-1 flex flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between mb-1">
                                                    <h3 class="font-medium text-gray-800 truncate">{{ $detection->primary_diagnosis }}</h3>
                                                    
                                                    @php
                                                        $confidence = $detection->confidence_score * 100;
                                                        $badgeClass = 'bg-green-100 text-green-800';
                                                        
                                                        if ($confidence > 70) {
                                                            $badgeClass = 'bg-red-100 text-red-800';
                                                        } elseif ($confidence > 30) {
                                                            $badgeClass = 'bg-yellow-100 text-yellow-800';
                                                        }
                                                    @endphp
                                                    
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                                        {{ number_format($confidence, 1) }}%
                                                    </span>
                                                </div>
                                                
                                                <p class="text-xs text-gray-500">{{ $detection->created_at->format('M j, Y \a\t g:i A') }}</p>
                                            </div>
                                            
                                            <button type="button" onclick="openDetectionModal({{ $detection->id }})" class="mt-2 text-sm inline-flex items-center text-indigo-600 hover:text-indigo-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                </svg>
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(isset($diseaseDetections) && $diseaseDetections->hasPages())
                            <div class="mt-6 border-t border-gray-200 pt-4">
                                {{ $diseaseDetections->links() }}
                            </div>
                        @endif
                        
                        <div class="mt-6 flex justify-center">
                            
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="bg-amber-100 p-3 rounded-full inline-block mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-gray-800 font-medium mb-1">No disease detections yet</h3>
                            <p class="text-gray-500 mb-4">Upload an image to scan for potential conditions.</p>
                            <button type="button" onclick="openDiseaseModal()" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg shadow-md transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                Perform Disease Detection
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Disease Detection Modal -->
    <div id="diseaseModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-lg w-full mx-4 shadow-2xl">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-4 rounded-t-xl flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pet Disease Detection
                </h3>
                <button onclick="closeDiseaseModal()" class="text-white hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <p class="text-gray-700 mb-4">Upload a photo of your pet's condition to detect possible diseases. Our AI system will analyze the image and provide potential diagnoses.</p>
                
                <form action="{{ route('disease.analyze', $pet->id) }}" method="POST" enctype="multipart/form-data" id="diseaseForm">
                    @csrf
                    <div class="mb-6">
                        <div class="mb-4 flex flex-col items-center">
                            <div id="imagePreview" class="w-full h-64 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center mb-2 overflow-hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <label for="imageUpload" class="cursor-pointer bg-indigo-50 text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-100 transition">
                                Choose Image
                            </label>
                            <input type="file" id="imageUpload" name="disease_image" class="hidden" accept="image/*" required>
                            <p class="text-gray-500 text-xs mt-1">JPEG, PNG, JPG, GIF. Max 5MB.</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-between border-t border-gray-200 pt-4">
                        <button type="button" onclick="closeDiseaseModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition">
                            Cancel
                        </button>
                        <button type="submit" id="analyzeButton" disabled class="px-6 py-2 bg-amber-500 text-white rounded-lg shadow-md hover:bg-amber-600 transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                Analyze Image
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Upload Script -->
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const imagePreview = document.getElementById('imagePreview');
            const analyzeButton = document.getElementById('analyzeButton');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                    analyzeButton.disabled = false;
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>`;
                analyzeButton.disabled = true;
            }
        });
        
        function openDiseaseModal() {
            document.getElementById('diseaseModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
        
        function closeDiseaseModal() {
            document.getElementById('diseaseModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            // Reset the form
            document.getElementById('diseaseForm').reset();
            document.getElementById('imagePreview').innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>`;
            document.getElementById('analyzeButton').disabled = true;
        }
        
        
function closeDetectionModal() {
    document.getElementById('detectionModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
    </script>
    <!-- Detection Results Modal -->
<div id="detectionModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden overflow-y-auto">
    <div class="bg-white rounded-xl max-w-4xl w-full mx-4 my-6 shadow-2xl max-h-[90vh] flex flex-col">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-4 rounded-t-xl flex justify-between items-center flex-shrink-0">
            <h3 class="text-xl font-bold text-white flex items-center truncate pr-4" id="detectionModalTitle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="truncate">Detection Results</span>
            </h3>
            <button onclick="closeDetectionModal()" class="text-white hover:text-gray-200 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Modal Body - Make it scrollable -->
        <div class="p-6 overflow-y-auto flex-grow" id="detectionModalContent">
            <div class="flex items-center justify-center py-8">
                <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-between flex-shrink-0">
            <button onclick="closeDetectionModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                Close
            </button>
            <a href="#" id="printDetectionBtn" class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Print Results
            </a>
        </div>
    </div>
</div>
<script>
// Replace the existing openDetectionModal function with this responsive version
function openDetectionModal(detectionId) {
    const modal = document.getElementById('detectionModal');
    const modalContent = document.getElementById('detectionModalContent');
    const modalTitle = document.getElementById('detectionModalTitle');
    const printBtn = document.getElementById('printDetectionBtn');
    
    // Show modal with loading state
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    // Fetch the detection details using AJAX
    fetch(`/pet/{{ $pet->id }}/disease/${detectionId}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    })
    .then(response => response.json())
    .then(data => {
        // Update modal content
        modalTitle.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="truncate">Detection Results: ${data.primary_diagnosis}</span>
        `;
        
        // Format the confidence score
        const confidence = (data.confidence_score * 100).toFixed(1);
        
        // Determine color classes based on confidence
        let colorClass = 'bg-green-100 text-green-800';
        let barColor = 'bg-green-600';
        if (data.confidence_score > 0.7) {
            colorClass = 'bg-red-100 text-red-800';
            barColor = 'bg-red-600';
        } else if (data.confidence_score > 0.3) {
            colorClass = 'bg-yellow-100 text-yellow-800';
            barColor = 'bg-yellow-600';
        }
        
        // Format date
        const date = new Date(data.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Responsive layout adjustment based on screen width
        const isSmallScreen = window.innerWidth < 768;
        const columnLayout = isSmallScreen ? 
            'flex flex-col space-y-6' : 
            'grid md:grid-cols-5 gap-6';
        
        // Replace the contentHtml in your openDetectionModal function with this complete version:

const contentHtml = `
    <div class="${columnLayout}">
        <!-- Left: Image -->
        <div class="${isSmallScreen ? '' : 'md:col-span-2'}">
            <h4 class="font-medium text-gray-800 mb-2">Uploaded Image:</h4>
            <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                <img src="${data.image_url}" alt="Detection image" class="w-full h-auto max-h-80 object-contain">
            </div>
            <p class="text-xs text-gray-500 mt-2">Uploaded on ${formattedDate}</p>
            
            <div class="mt-4 p-3 rounded-lg ${colorClass} shadow-sm">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-medium">Primary Diagnosis:</span>
                    <span class="text-sm font-bold">${confidence}%</span>
                </div>
                <div class="text-lg font-bold mb-2">${data.primary_diagnosis}</div>
                <div class="w-full bg-white/60 rounded-full h-2.5 overflow-hidden">
                    <div class="h-2.5 rounded-full ${barColor}" style="width: ${confidence}%"></div>
                </div>
            </div>
        </div>
        
        <!-- Right: Results and Recommendations -->
        <div class="${isSmallScreen ? '' : 'md:col-span-3'}">
            <h4 class="font-medium text-gray-800 mb-2">Detailed Analysis Results:</h4>
            <div class="space-y-3 pr-1 mb-4">
                ${data.results.map(result => {
                    const percent = (result.probability * 100).toFixed(1);
                    let resultColorClass = 'bg-green-100 text-green-800';
                    let resultBarColor = 'bg-green-600';
                    
                    if (result.probability > 0.7) {
                        resultColorClass = 'bg-red-100 text-red-800';
                        resultBarColor = 'bg-red-600';
                    } else if (result.probability > 0.3) {
                        resultColorClass = 'bg-yellow-100 text-yellow-800';
                        resultBarColor = 'bg-yellow-600';
                    }
                    
                    return `
                        <div class="p-3 rounded-lg ${resultColorClass} shadow-sm">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium">${result.className}</span>
                                <span class="text-sm font-bold">${percent}%</span>
                            </div>
                            <div class="w-full bg-white/60 rounded-full h-2.5 overflow-hidden">
                                <div class="h-2.5 rounded-full ${resultBarColor}" style="width: ${percent}%"></div>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
            
            <h4 class="font-medium text-gray-800 mt-4 mb-2">Recommendations:</h4>
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
                ${data.recommendation_html || `
                    <p class="mb-2">Based on our analysis, we recommend consulting with your veterinarian for a proper diagnosis.</p>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        <li>Schedule an appointment with your vet</li>
                        <li>Bring this report with you to your appointment</li>
                        <li>Monitor your pet for any changes in symptoms</li>
                    </ul>
                `}
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="font-medium text-gray-800 mb-2">Next Steps:</h4>
                <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700">
                    <li>Consult with your veterinarian about these results</li>
                    <li>Follow any specific treatment recommendations from your vet</li>
                    <li>Schedule a follow-up scan after treatment to monitor progress</li>
                    <li>Keep track of any changes in your pet's condition</li>
                </ul>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Detection ID: #${data.id}</span>
                    <span class="text-sm text-gray-500">Confidence: ${confidence}%</span>
                </div>
            </div>
        </div>
    </div>
`;
        modalContent.innerHTML = contentHtml;
        
        // Update print button href
        printBtn.href = `/pet/${data.pet_id}/disease/${data.id}`;
    })
    .catch(error => {
        console.error('Error:', error);
        modalContent.innerHTML = `
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>Failed to load detection details. Please try again.</p>
                </div>
            </div>
        `;
    });
} </script>
</x-app-layout>
