<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Veterinarian Profile') }}
            </h2>
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->id() === $vet->user_id))
            <div>
                <a href="{{ route('vet.edit', $vet->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Profile
                </a>
            </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Status and Verification Banner -->
            @if(!$vet->is_verified)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                    <p class="font-medium">This veterinarian profile is pending verification.</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="md:flex md:space-x-6">
                        <!-- Profile Image Column -->
                        <div class="md:w-1/3 mb-6 md:mb-0 flex flex-col items-center">
                            <img src="{{ $vet->image_url }}" alt="{{ $vet->user->name }}" class="rounded-lg w-64 h-64 object-cover shadow-md">
                            
                            <div class="mt-6 text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $vet->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $vet->is_available ? 'Available for Consultations' : 'Not Available' }}
                                </span>
                            </div>

                            @if($vet->is_verified)
                            <div class="mt-3 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="-ml-0.5 mr-1.5 h-3 w-3 text-blue-700" fill="currentColor" viewBox="0 0 12 12">
                                        <path d="M3.7071 5.70711L2.29289 4.29289L1 5.58579L3.7071 8.29289L9 3L7.70711 1.70711L3.7071 5.70711Z" />
                                    </svg>
                                    Verified Profile
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Info Column -->
                        <div class="md:w-2/3">
                            <h1 class="text-2xl font-bold text-gray-900">Dr. {{ $vet->user->name }}</h1>
                            <p class="text-lg text-indigo-700 font-medium">{{ $vet->specialization }}</p>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Clinic</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->clinic_name ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Experience</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->experience_years }} {{ Str::plural('year', $vet->experience_years) }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Qualification</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->qualification ?: 'Not specified' }}</p>
                                </div>

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">License Number</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->license_number }}</p>
                                </div>

                                @if($vet->consultation_fee)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Consultation Fee</h3>
                                    <p class="mt-1 text-gray-900">${{ number_format($vet->consultation_fee, 2) }}</p>
                                </div>
                                @endif

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Phone</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->phone_number ?: 'Not provided' }}</p>
                                </div>

                                @if($vet->website)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Website</h3>
                                    <a href="{{ $vet->website }}" target="_blank" class="mt-1 text-indigo-600 hover:text-indigo-900">
                                        {{ preg_replace('#^https?://#', '', $vet->website) }}
                                    </a>
                                </div>
                                @endif

                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                                    <p class="mt-1 text-gray-900">{{ $vet->user->email }}</p>
                                </div>
                            </div>

                            <!-- Biography -->
                            @if($vet->biography)
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900">Biography</h3>
                                <div class="mt-2 prose prose-indigo">
                                    <p>{{ $vet->biography }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Services Offered -->
                    @if($vet->services_offered && count($vet->services_offered) > 0)
                    <div class="mt-10 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Services Offered</h3>
                        
                        <div class="flex flex-wrap gap-2">
                            @foreach($vet->services_offered as $service)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ $service }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    

                    <!-- Contact & Location Info -->
                    <div class="mt-10 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900">Location Information</h3>
                        
                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 gap-x-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Address</h4>
                                <address class="mt-1 not-italic text-gray-900">
                                    {{ $vet->address ?: 'Address not provided' }}
                                    @if($vet->city || $vet->state || $vet->zip_code)
                                    <br>
                                    {{ collect([$vet->city, $vet->state, $vet->zip_code])->filter()->join(', ') }}
                                    @endif
                                </address>
                            </div>
                            
                            
                        </div>
                    </div>

                    <!-- Professional Details -->
                    <div class="mt-10 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Professional Details</h3>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Specialization</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->specialization }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">License Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->license_number }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Years of Experience</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->experience_years }} {{ Str::plural('year', $vet->experience_years) }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Qualification</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->qualification ?: 'Not specified' }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Joined</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->created_at->format('F d, Y') }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $vet->updated_at->format('F d, Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>
</x-app-layout>