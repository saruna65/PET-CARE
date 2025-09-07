<x-app-layout>
    <div class="py-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Our Veterinarians</h1>
                <p class="mt-2 text-gray-600">Find the right vet for your pet's healthcare needs</p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-8 bg-white p-4 rounded-lg shadow-md">
                <form action="{{ route('vet.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search by name, specialization, or location">
                        </div>
                    </div>

                    <div class="w-full md:w-48">
                        <label for="specialization" class="sr-only">Specialization</label>
                        <select name="specialization" id="specialization" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">All Specializations</option>
                            <option value="General Practice" {{ request('specialization') == 'General Practice' ? 'selected' : '' }}>General Practice</option>
                            <option value="Surgery" {{ request('specialization') == 'Surgery' ? 'selected' : '' }}>Surgery</option>
                            <option value="Dermatology" {{ request('specialization') == 'Dermatology' ? 'selected' : '' }}>Dermatology</option>
                            <option value="Dentistry" {{ request('specialization') == 'Dentistry' ? 'selected' : '' }}>Dentistry</option>
                            <option value="Cardiology" {{ request('specialization') == 'Cardiology' ? 'selected' : '' }}>Cardiology</option>
                            <option value="Neurology" {{ request('specialization') == 'Neurology' ? 'selected' : '' }}>Neurology</option>
                            <option value="Oncology" {{ request('specialization') == 'Oncology' ? 'selected' : '' }}>Oncology</option>
                            <option value="Behavior" {{ request('specialization') == 'Behavior' ? 'selected' : '' }}>Behavior</option>
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Filter
                    </button>
                </form>
            </div>

            @if(auth()->check() && !auth()->user()->isVet())
                <div class="mb-8">
                    <a href="{{ route('vet.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Register as a Veterinarian
                    </a>
                </div>
            @endif

            <!-- Vets List -->
            @if(count($vets) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($vets as $vet)
                        <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                            <div class="h-48 bg-gray-200">
                                <img src="{{ $vet->image_url }}" alt="{{ $vet->user->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-xl text-gray-800">Dr. {{ $vet->user->name }}</h3>
                                <p class="text-indigo-600 font-medium">{{ $vet->specialization }}</p>
                                <div class="mt-2 text-gray-600 text-sm">
                                    <div class="flex items-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $vet->experience_years }} {{ Str::plural('year', $vet->experience_years) }} experience
                                    </div>
                                    
                                    @if($vet->clinic_name)
                                        <div class="flex items-center mb-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1v1a1 1 0 11-2 0v-1H7v1a1 1 0 11-2 0v-1a1 1 0 01-1-1V4zm3 1h6v4H7V5zm8 8V9H5v4h10z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $vet->clinic_name }}
                                        </div>
                                    @endif
                                    
                                    @if($vet->city)
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                            </svg>
                                            {{ $vet->city }}{{ $vet->state ? ', '.$vet->state : '' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-4 flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-700">
                                        @if($vet->consultation_fee > 0)
                                            ${{ number_format($vet->consultation_fee, 2) }}
                                        @else
                                            Fee varies
                                        @endif
                                    </span>
                                    <a href="{{ route('vet.show', $vet->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                        View profile
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $vets->links() }}
                </div>
            @else
                <div class="bg-white p-10 rounded-lg shadow-md text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-1">No veterinarians found</h3>
                    <p class="text-gray-500">There are currently no veterinarians registered on our platform.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>