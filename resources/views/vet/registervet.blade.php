<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register New User as Veterinarian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p>{{ session('error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('vet.store.with.user') }}" method="POST" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">User Account Information</h3>
                            <p class="mt-1 text-sm text-gray-500">Create a new user account for this veterinarian.</p>

                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full
                                        Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email
                                        Address</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700">Password</label>
                                    <input type="password" name="password" id="password" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="password_confirmation"
                                        class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <!-- Profile Picture Upload -->
                                <div class="sm:col-span-6">
                                    <label for="vet_image" class="block text-sm font-medium text-gray-700">Profile
                                        Picture</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <svg class="h-full w-full text-gray-300" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </span>
                                        <input type="file" name="vet_image" id="vet_image" accept="image/*"
                                            class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    </div>
                                    @error('vet_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">Upload a professional headshot (recommended
                                        size: 400x400 pixels)</p>
                                </div>


                            </div>
                        </div>

                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Professional Information</h3>

                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-3">
                                    <label for="clinic_name" class="block text-sm font-medium text-gray-700">Clinic
                                        Name</label>
                                    <input type="text" name="clinic_name" id="clinic_name"
                                        value="{{ old('clinic_name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('clinic_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="specialization" class="block text-sm font-medium text-gray-700">Animal
                                        Specialization</label>
                                    <select name="specialization" id="specialization" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="">-- Select animal specialization --</option>
                                        <option value="Dogs & Cats"
                                            {{ old('specialization') == 'Dogs & Cats' ? 'selected' : '' }}>Dogs & Cats
                                        </option>
                                        <option value="Dogs Only"
                                            {{ old('specialization') == 'Dogs Only' ? 'selected' : '' }}>Dogs Only
                                        </option>
                                        <option value="Cats Only"
                                            {{ old('specialization') == 'Cats Only' ? 'selected' : '' }}>Cats Only
                                        </option>
                                        <option value="Birds"
                                            {{ old('specialization') == 'Birds' ? 'selected' : '' }}>Birds</option>
                                        <option value="Exotics & Reptiles"
                                            {{ old('specialization') == 'Exotics & Reptiles' ? 'selected' : '' }}>
                                            Exotics & Reptiles</option>
                                        <option value="Small Mammals"
                                            {{ old('specialization') == 'Small Mammals' ? 'selected' : '' }}>Small
                                            Mammals (Rabbits, Guinea Pigs, etc.)</option>
                                        <option value="Farm Animals"
                                            {{ old('specialization') == 'Farm Animals' ? 'selected' : '' }}>Farm
                                            Animals</option>
                                        <option value="Equine"
                                            {{ old('specialization') == 'Equine' ? 'selected' : '' }}>Equine (Horses)
                                        </option>
                                        <option value="Aquatic"
                                            {{ old('specialization') == 'Aquatic' ? 'selected' : '' }}>Aquatic Animals
                                        </option>
                                        <option value="Wildlife"
                                            {{ old('specialization') == 'Wildlife' ? 'selected' : '' }}>Wildlife
                                        </option>
                                        <option value="All Animals"
                                            {{ old('specialization') == 'All Animals' ? 'selected' : '' }}>All Animals
                                        </option>
                                    </select>
                                    @error('specialization')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">Select the primary type of animals you
                                        specialize in treating</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="license_number" class="block text-sm font-medium text-gray-700">License
                                        Number</label>
                                    <input type="text" name="license_number" id="license_number"
                                        value="{{ old('license_number') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('license_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="experience_years"
                                        class="block text-sm font-medium text-gray-700">Years of Experience</label>
                                    <input type="number" name="experience_years" id="experience_years"
                                        value="{{ old('experience_years') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('experience_years')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="qualification"
                                        class="block text-sm font-medium text-gray-700">Qualification</label>
                                    <input type="text" name="qualification" id="qualification"
                                        value="{{ old('qualification') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('qualification')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone
                                        Number</label>
                                    <input type="text" name="phone_number" id="phone_number"
                                        value="{{ old('phone_number') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('phone_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Biography -->
                                <div class="sm:col-span-6">
                                    <label for="biography"
                                        class="block text-sm font-medium text-gray-700">Professional Biography</label>
                                    <textarea id="biography" name="biography" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('biography') }}</textarea>
                                    <p class="mt-2 text-sm text-gray-500">Provide a short professional biography,
                                        including academic background and professional achievements</p>
                                    @error('biography')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                
                            </div>
                        </div>

                        <div class="border-b border-gray-200 pb-6 mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Clinic Information</h3>

                            <div class="mt-4 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" name="address" id="address"
                                        value="{{ old('address') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="state"
                                        class="block text-sm font-medium text-gray-700">State/Province</label>
                                    <input type="text" name="state" id="state" value="{{ old('state') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700">ZIP / Postal
                                        Code</label>
                                    <input type="text" name="zip_code" id="zip_code"
                                        value="{{ old('zip_code') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('zip_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="website" class="block text-sm font-medium text-gray-700">Website
                                        URL</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">https://</span>
                                        <input type="text" name="website" id="website"
                                            value="{{ old('website') }}" placeholder="www.example.com"
                                            class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    </div>
                                    @error('website')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="consultation_fee"
                                        class="block text-sm font-medium text-gray-700">Consultation Fee ($)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" min="0" name="consultation_fee"
                                            id="consultation_fee" value="{{ old('consultation_fee') }}"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                                        <div
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">USD</span>
                                        </div>
                                    </div>
                                    @error('consultation_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Availability & Status</h3>

                            <div class="mt-4 flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_available" id="is_available" value="1"
                                        {{ old('is_available') ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="is_available" class="ml-2 block text-sm text-gray-700">Available for
                                        consultations</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_verified" id="is_verified" value="1"
                                        {{ old('is_verified', true) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <label for="is_verified" class="ml-2 block text-sm text-gray-700">Verify
                                        immediately</label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6">
                            <a href="{{ route('vet.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Register New Vet with Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
