<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Veterinarian Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('vet.update', $vet->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                            
                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <div class="mt-1">
                                        <p class="py-2 px-3 bg-gray-50 rounded-md">{{ $vet->user->name }}</p>
                                    </div>
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1">
                                        <p class="py-2 px-3 bg-gray-50 rounded-md">{{ $vet->user->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Image Section -->
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Profile Image</h3>
                            
                            <div class="mt-4 flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    @if($vet->image_path)
                                        <img src="{{ asset('storage/' . $vet->image_path) }}" alt="{{ $vet->user->name }}" class="h-24 w-24 rounded-full object-cover">
                                    @else
                                        <span class="h-24 w-24 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                    @endif
                                </div>
                                
                                <div>
                                    <input type="file" name="vet_image" id="vet_image" accept="image/*" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <p class="mt-2 text-xs text-gray-500">Upload a new profile image (optional)</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Professional Information</h3>
                            
                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="clinic_name" class="block text-sm font-medium text-gray-700">Clinic Name</label>
                                    <input type="text" name="clinic_name" id="clinic_name" value="{{ old('clinic_name', $vet->clinic_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('clinic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="specialization" class="block text-sm font-medium text-gray-700">Animal Specialization</label>
                                    <select name="specialization" id="specialization" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Select animal specialization --</option>
                                        <option value="Dogs & Cats" {{ old('specialization', $vet->specialization) == 'Dogs & Cats' ? 'selected' : '' }}>Dogs & Cats</option>
                                        <option value="Dogs Only" {{ old('specialization', $vet->specialization) == 'Dogs Only' ? 'selected' : '' }}>Dogs Only</option>
                                        <option value="Cats Only" {{ old('specialization', $vet->specialization) == 'Cats Only' ? 'selected' : '' }}>Cats Only</option>
                                        <option value="Birds" {{ old('specialization', $vet->specialization) == 'Birds' ? 'selected' : '' }}>Birds</option>
                                        <option value="Exotics & Reptiles" {{ old('specialization', $vet->specialization) == 'Exotics & Reptiles' ? 'selected' : '' }}>Exotics & Reptiles</option>
                                        <option value="Small Mammals" {{ old('specialization', $vet->specialization) == 'Small Mammals' ? 'selected' : '' }}>Small Mammals (Rabbits, Guinea Pigs, etc.)</option>
                                        <option value="Farm Animals" {{ old('specialization', $vet->specialization) == 'Farm Animals' ? 'selected' : '' }}>Farm Animals</option>
                                        <option value="Equine" {{ old('specialization', $vet->specialization) == 'Equine' ? 'selected' : '' }}>Equine (Horses)</option>
                                        <option value="Aquatic" {{ old('specialization', $vet->specialization) == 'Aquatic' ? 'selected' : '' }}>Aquatic Animals</option>
                                        <option value="Wildlife" {{ old('specialization', $vet->specialization) == 'Wildlife' ? 'selected' : '' }}>Wildlife</option>
                                        <option value="All Animals" {{ old('specialization', $vet->specialization) == 'All Animals' ? 'selected' : '' }}>All Animals</option>
                                    </select>
                                    @error('specialization')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="license_number" class="block text-sm font-medium text-gray-700">License Number</label>
                                    <input type="text" name="license_number" id="license_number" value="{{ old('license_number', $vet->license_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('license_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="experience_years" class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                    <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $vet->experience_years) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('experience_years')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="qualification" class="block text-sm font-medium text-gray-700">Qualification</label>
                                    <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $vet->qualification) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('qualification')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $vet->phone_number) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-6">
                                    <label for="biography" class="block text-sm font-medium text-gray-700">Professional Biography</label>
                                    <textarea id="biography" name="biography" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('biography', $vet->biography) }}</textarea>
                                    <p class="mt-2 text-sm text-gray-500">Provide a professional biography highlighting your experience and expertise</p>
                                    @error('biography')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Services Offered -->
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Services Offered</h3>
                            
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                @php
                                    $services = is_array($vet->services_offered) ? $vet->services_offered : [];
                                @endphp
                                
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_checkup" value="General Checkup" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('General Checkup', $services) ? 'checked' : '' }}>
                                    <label for="service_checkup" class="ml-2 block text-sm text-gray-700">General Checkup</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_vaccination" value="Vaccination" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Vaccination', $services) ? 'checked' : '' }}>
                                    <label for="service_vaccination" class="ml-2 block text-sm text-gray-700">Vaccination</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_surgery" value="Surgery" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Surgery', $services) ? 'checked' : '' }}>
                                    <label for="service_surgery" class="ml-2 block text-sm text-gray-700">Surgery</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_dental" value="Dental Care" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Dental Care', $services) ? 'checked' : '' }}>
                                    <label for="service_dental" class="ml-2 block text-sm text-gray-700">Dental Care</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_xray" value="X-Ray & Imaging" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('X-Ray & Imaging', $services) ? 'checked' : '' }}>
                                    <label for="service_xray" class="ml-2 block text-sm text-gray-700">X-Ray & Imaging</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_laboratory" value="Laboratory Services" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Laboratory Services', $services) ? 'checked' : '' }}>
                                    <label for="service_laboratory" class="ml-2 block text-sm text-gray-700">Laboratory Services</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_emergency" value="Emergency Care" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Emergency Care', $services) ? 'checked' : '' }}>
                                    <label for="service_emergency" class="ml-2 block text-sm text-gray-700">Emergency Care</label>
                                </div>
                                <div class="flex items-start">
                                    <input type="checkbox" name="services_offered[]" id="service_behavior" value="Behavior Consultation" class="mt-1 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array('Behavior Consultation', $services) ? 'checked' : '' }}>
                                    <label for="service_behavior" class="ml-2 block text-sm text-gray-700">Behavior Consultation</label>
                                </div>
                            </div>
                            @error('services_offered')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Clinic Information -->
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Clinic Information</h3>
                            
                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address', $vet->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city', $vet->city) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                                    <input type="text" name="state" id="state" value="{{ old('state', $vet->state) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP / Postal Code</label>
                                    <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $vet->zip_code) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('zip_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website URL</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">https://</span>
                                        <input type="text" name="website" id="website" value="{{ old('website', preg_replace('#^https?://#', '', $vet->website)) }}" placeholder="www.example.com" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="sm:col-span-3">
                                    <label for="consultation_fee" class="block text-sm font-medium text-gray-700">Consultation Fee ($)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="consultation_fee" id="consultation_fee" value="{{ old('consultation_fee', $vet->consultation_fee) }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">USD</span>
                                        </div>
                                    </div>
                                    @error('consultation_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                            
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $vet->is_available) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_available" class="ml-2 block text-sm text-gray-900">Available for Consultations</label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input id="is_verified" name="is_verified" type="checkbox" value="1" {{ old('is_verified', $vet->is_verified) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_verified" class="ml-2 block text-sm text-gray-900">Verified Veterinarian</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('vet.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>