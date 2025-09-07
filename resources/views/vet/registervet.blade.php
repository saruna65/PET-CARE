<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                    <h2 class="text-2xl font-bold text-white">Complete Your Veterinarian Profile</h2>
                    <p class="text-blue-100 mt-1">Fill in your professional details to get started helping pet owners</p>
                </div>
                
                <div class="p-6 sm:p-8">
                    @if (session('info'))
                        <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p>{{ session('info') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('become.vet.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Professional Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                    </svg>
                                    Professional Qualifications
                                </span>
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm space-y-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="qualification" class="block text-sm font-medium text-gray-700">Medical Degree/Qualification <span class="text-red-600">*</span></label>
                                        <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="DVM, VMD, BVSc, etc.">
                                        @error('qualification')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="license_number" class="block text-sm font-medium text-gray-700">License Number <span class="text-red-600">*</span></label>
                                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Your veterinary license number">
                                        @error('license_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500">This will be verified before your profile is approved</p>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization <span class="text-red-600">*</span></label>
                                        <select name="specialization" id="specialization" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">-- Select specialization --</option>
                                            <option value="General Practice" {{ old('specialization') == 'General Practice' ? 'selected' : '' }}>General Practice</option>
                                            <option value="Surgery" {{ old('specialization') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                                            <option value="Dermatology" {{ old('specialization') == 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                                            <option value="Dentistry" {{ old('specialization') == 'Dentistry' ? 'selected' : '' }}>Dentistry</option>
                                            <option value="Cardiology" {{ old('specialization') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                                            <option value="Neurology" {{ old('specialization') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                                            <option value="Oncology" {{ old('specialization') == 'Oncology' ? 'selected' : '' }}>Oncology</option>
                                            <option value="Behavior" {{ old('specialization') == 'Behavior' ? 'selected' : '' }}>Behavior</option>
                                            <option value="Emergency & Critical Care" {{ old('specialization') == 'Emergency & Critical Care' ? 'selected' : '' }}>Emergency & Critical Care</option>
                                            <option value="Internal Medicine" {{ old('specialization') == 'Internal Medicine' ? 'selected' : '' }}>Internal Medicine</option>
                                            <option value="Ophthalmology" {{ old('specialization') == 'Ophthalmology' ? 'selected' : '' }}>Ophthalmology</option>
                                            <option value="Radiology" {{ old('specialization') == 'Radiology' ? 'selected' : '' }}>Radiology</option>
                                        </select>
                                        @error('specialization')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="experience_years" class="block text-sm font-medium text-gray-700">Years of Experience <span class="text-red-600">*</span></label>
                                        <input type="number" name="experience_years" id="experience_years" min="0" max="70" value="{{ old('experience_years') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        @error('experience_years')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="biography" class="block text-sm font-medium text-gray-700">Professional Biography</label>
                                    <textarea name="biography" id="biography" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Tell pet owners about your professional background, expertise, and approach to veterinary care.">{{ old('biography') }}</textarea>
                                    @error('biography')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Practice Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1v1a1 1 0 11-2 0v-1H7v1a1 1 0 11-2 0v-1a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8V9H5v4h10z" clip-rule="evenodd" />
                                    </svg>
                                    Practice Information
                                </span>
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm space-y-4">
                                <div>
                                    <label for="clinic_name" class="block text-sm font-medium text-gray-700">Clinic/Hospital Name</label>
                                    <input type="text" name="clinic_name" id="clinic_name" value="{{ old('clinic_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Name of your clinic or hospital">
                                    @error('clinic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                                        <input type="text" name="address" id="address" value="{{ old('address') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Street address of your practice">
                                        @error('address')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="City">
                                        @error('city')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                        <input type="text" name="state" id="state" value="{{ old('state') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="State or province">
                                        @error('state')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="zip_code" class="block text-sm font-medium text-gray-700">Zip/Postal Code</label>
                                        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Postal code">
                                        @error('zip_code')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    Contact Information
                                </span>
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm space-y-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number <span class="text-red-600">*</span></label>
                                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Office or professional contact number">
                                        @error('phone_number')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700">Website (optional)</label>
                                        <input type="url" name="website" id="website" value="{{ old('website') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://your-website.com">
                                        @error('website')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Services and Fees -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Services and Fees
                                </span>
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Services Offered</label>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                        @php
                                            $services = [
                                                'General Checkup', 'Vaccinations', 'Surgery', 'Dental Care', 'Laboratory Services', 
                                                'Preventative Care', 'Microchipping', 'X-rays & Imaging', 'Nutritional Counseling',
                                                'Emergency Care', 'House Calls', 'Behavioral Counseling', 'Exotic Pet Care',
                                                'Geriatric Care', 'Pharmacy Services', 'Grooming'
                                            ];
                                        @endphp
                                        
                                        @foreach($services as $service)
                                            <div class="flex items-center">
                                                <input id="service_{{ Str::slug($service) }}" name="services_offered[]" type="checkbox" value="{{ $service }}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                    {{ (old('services_offered') && in_array($service, old('services_offered'))) ? 'checked' : '' }}>
                                                <label for="service_{{ Str::slug($service) }}" class="ml-2 block text-sm text-gray-700">
                                                    {{ $service }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('services_offered')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="consultation_fee" class="block text-sm font-medium text-gray-700">Consultation Fee ($)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" name="consultation_fee" id="consultation_fee" value="{{ old('consultation_fee') }}" min="0" step="0.01" class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="0.00">
                                    </div>
                                    @error('consultation_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Enter your standard consultation fee. Leave blank if fees vary or you prefer to discuss with clients directly.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Image -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                    Profile Image
                                </span>
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-lg shadow-sm space-y-4">
                                <div>
                                    <label for="vet_image" class="block text-sm font-medium text-gray-700 mb-2">Upload a professional photo</label>
                                    <div class="flex items-center">
                                        <div id="preview-container" class="hidden mr-4 w-24 h-24 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex items-center justify-center">
                                            <img id="preview-image" src="#" alt="Preview" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="vet_image" id="vet_image" accept="image/*" class="block w-full text-sm text-gray-500
                                                file:mr-4 file:py-2 file:px-4
                                                file:rounded-md file:border-0
                                                file:text-sm file:font-semibold
                                                file:bg-indigo-50 file:text-indigo-600
                                                hover:file:bg-indigo-100">
                                            @error('vet_image')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                            <p class="mt-1 text-xs text-gray-500">JPEG, PNG, JPG, GIF up to 2MB. A professional headshot is recommended.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg shadow-sm">
                            <div class="mb-4">
                                <h3 class="font-medium text-gray-800">Review and Submit</h3>
                                <p class="text-sm text-gray-600 mt-1">Please review your information before submitting. Your profile will be reviewed by our team before being published.</p>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" name="terms_accepted" id="terms_accepted" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="terms_accepted" class="ml-2 block text-sm text-gray-700">
                                    I confirm that all information provided is accurate and I am a licensed veterinary professional. <span class="text-red-600">*</span>
                                </label>
                            </div>
                            @error('terms_accepted')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const imageInput = document.getElementById('vet_image');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');
            
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>