<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-xl">
                <!-- Header with icon -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-full mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">Edit Pet Profile</h1>
                    </div>
                    <p class="text-blue-100 mt-2 ml-16">Update {{ $pet->pet_name }}'s information</p>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <form action="{{ route('pet.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Image Upload Section -->
                        <div class="mb-8 flex flex-col items-center">
                            <div class="mb-4 relative w-32 h-32 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden">
                                <div id="preview" class="absolute inset-0 rounded-full flex items-center justify-center overflow-hidden">
                                    @if($pet->image_path)
                                        <img src="{{ $pet->image_url }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                                <input type="file" name="pet_image" id="pet_image" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" accept="image/*">
                            </div>
                            <label for="pet_image" class="text-sm font-medium text-indigo-600 cursor-pointer">Change photo</label>
                            <p class="text-gray-500 text-xs mt-1">JPEG, PNG, JPG, GIF. Max 2MB.</p>
                            @error('pet_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Two column layout for form fields -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div>
                                <div class="mb-5">
                                    <label for="pet_name" class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                        Pet Name
                                    </label>
                                    <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name', $pet->pet_name) }}" 
                                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('pet_name') border-red-500 @enderror"
                                           placeholder="Enter your pet's name">
                                    @error('pet_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-5">
                                    <label for="pet_type" class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9.243 3.03a1 1 0 01.727 1.213L9.53 6h2.94l.56-2.243a1 1 0 111.94.486L14.53 6H17a1 1 0 110 2h-2.97l-1 4H15a1 1 0 110 2h-2.47l-.56 2.242a1 1 0 11-1.94-.485L10.47 14H7.53l-.56 2.242a1 1 0 11-1.94-.485L5.47 14H3a1 1 0 110-2h2.97l1-4H5a1 1 0 110-2h2.47l.56-2.243a1 1 0 011.213-.727zM9.03 8l-1 4h2.938l1-4H9.031z" clip-rule="evenodd" />
                                        </svg>
                                        Pet Type
                                    </label>
                                    <input type="text" name="pet_type" id="pet_type" value="{{ old('pet_type', $pet->pet_type) }}" 
                                           placeholder="e.g., Dog, Cat, Bird" 
                                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('pet_type') border-red-500 @enderror">
                                    @error('pet_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-5">
                                    <label for="pet_breed" class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                        Pet Breed
                                    </label>
                                    <input type="text" name="pet_breed" id="pet_breed" value="{{ old('pet_breed', $pet->pet_breed) }}" 
                                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('pet_breed') border-red-500 @enderror"
                                           placeholder="Enter your pet's breed">
                                    @error('pet_breed')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Right Column -->
                            <div>
                                <div class="mb-5">
                                    <label for="age" class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        Age (Years)
                                    </label>
                                    <input type="number" name="age" id="age" value="{{ old('age', $pet->age) }}" min="0" max="100"
                                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 @error('age') border-red-500 @enderror"
                                           placeholder="Enter age in years">
                                    @error('age')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-5">
                                    <label class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                        Sex
                                    </label>
                                    <div class="flex space-x-4">
                                        <div class="flex items-center pl-4 border border-gray-300 rounded-lg bg-gray-50 w-1/2">
                                            <input type="radio" name="sex" id="male" value="male" {{ (old('sex', $pet->sex) == 'male') ? 'checked' : '' }} 
                                                class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                            <label for="male" class="w-full py-2.5 ml-2 text-sm font-medium text-gray-900">Male</label>
                                        </div>
                                        
                                        <div class="flex items-center pl-4 border border-gray-300 rounded-lg bg-gray-50 w-1/2">
                                            <input type="radio" name="sex" id="female" value="female" {{ (old('sex', $pet->sex) == 'female') ? 'checked' : '' }} 
                                                class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500">
                                            <label for="female" class="w-full py-2.5 ml-2 text-sm font-medium text-gray-900">Female</label>
                                        </div>
                                    </div>
                                    @error('sex')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-5">
                                    <label for="allergies" class="block text-gray-700 font-semibold mb-2 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Allergies (Optional)
                                    </label>
                                    <textarea name="allergies" id="allergies" rows="3" 
                                              class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5"
                                              placeholder="List any known allergies your pet has">{{ old('allergies', $pet->allergies) }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit and Cancel Buttons -->
                        <div class="flex items-center justify-between mt-8 pt-5 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <a href="{{ route('pet.profile') }}" class="flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Cancel
                                </a>
                                
                                <a href="{{ route('pet.show', $pet->id) }}" class="flex items-center px-5 py-2.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                    View Profile
                                </a>
                            </div>
                            
                            <button type="submit" class="flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Update Pet Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        document.getElementById('pet_image').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>`;
            }
        });
    </script>
</x-app-layout>