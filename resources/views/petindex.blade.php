<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('All Pets') }}
            </h2>
            <a href="{{ route('pet.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Pet
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('pets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Pet name, breed...">
                        </div>
                        
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Pet Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">All Types</option>
                                @foreach(\App\Models\Pet::select('pet_type')->distinct()->pluck('pet_type') as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-700">Sex</label>
                            <select name="sex" id="sex" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="">All</option>
                                <option value="male" {{ request('sex') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('sex') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Filter
                            </button>
                            <a href="{{ route('pets.index') }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pets list -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    @if($pets->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($pets as $pet)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-md hover:shadow-lg transition-shadow duration-300">
                                    <div class="relative h-48 overflow-hidden rounded-t-lg">
                                        <img src="{{ $pet->getImageUrlAttribute() }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                            <h3 class="text-xl font-bold text-white">{{ $pet->pet_name }}</h3>
                                            <p class="text-sm text-gray-200">{{ $pet->pet_type }} - {{ $pet->pet_breed }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="p-5">
                                        <div class="flex justify-between items-center mb-3">
                                            <div>
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pet->getFormattedAgeAttribute() }}</span>
                                                <span class="bg-purple-100 text-purple-800 text-xs font-medium ml-1 px-2.5 py-0.5 rounded-full">{{ $pet->getCapitalizedSexAttribute() }}</span>
                                            </div>
                                            <span class="text-sm text-gray-500">Owner: {{ $pet->user->name }}</span>
                                        </div>
                                        
                                        @if($pet->allergies)
                                            <div class="mb-3">
                                                <span class="text-xs font-medium text-gray-600">Allergies:</span>
                                                <p class="text-sm text-gray-700">{{ $pet->allergies }}</p>
                                            </div>
                                        @endif
                                        
                                        <div class="flex justify-between mt-4">
                                            <button type="button" 
                                                onclick="openPetModal({{ $pet->id }})" 
                                                class="text-sm font-medium text-blue-600 hover:underline">
                                                View Details
                                            </button>
                                            
                                            @if(auth()->user()->id === $pet->user_id || auth()->user()->is_admin)
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('pet.edit', $pet->id) }}" class="text-sm font-medium text-gray-600 hover:underline">Edit</a>
                                                    
                                                    <form action="{{ route('pet.destroy', $pet->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this pet?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $pets->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No pets found</h3>
                            <p class="mt-1 text-sm text-gray-500">No pets match your current filters or search criteria.</p>
                            <div class="mt-6">
                                <a href="{{ route('pet.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add a new pet
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Pet Detail Modal -->
    <div id="petDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Background overlay -->
            <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" onclick="closePetModal()"></div>

            <!-- Modal panel -->
            <div class="relative bg-white rounded-xl max-w-3xl w-full mx-auto shadow-xl">
                <!-- Close button -->
                <button type="button" onclick="closePetModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                
                <!-- Header with gradient -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 rounded-t-xl">
                    <h3 class="text-xl font-bold text-white" id="modalTitle">Pet Details</h3>
                </div>
                
                <!-- Content -->
                <div id="petDetailContent" class="p-6">
                    <!-- Loading spinner -->
                    <div class="flex justify-center items-center h-40">
                        <svg class="animate-spin h-10 w-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                    <button onclick="closePetModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition mr-3">
                        Close
                    </button>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPetModal(petId) {
    // Show the modal
    document.getElementById('petDetailModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    
    
    // This should match your route exactly
    fetch(`/pets/detail/${petId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('petDetailContent').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('petDetailContent').innerHTML = `
                <div class="text-center py-6 text-red-500">
                    <p>Error loading pet details. Please try again.</p>
                    <p class="text-sm mt-2">${error.message}</p>
                </div>
            `;
            console.error('Error:', error);
        });
}

        function closePetModal() {
            document.getElementById('petDetailModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when pressing ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePetModal();
            }
        });
    </script>
</x-app-layout>