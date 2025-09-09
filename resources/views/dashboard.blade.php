<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->isAdmin())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Admin Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        


                        <a href="{{ route('pets.index') }}" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                            <svg class="h-8 w-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-gray-700">View Pets</span>
                        </a>

                        <a href="{{ route('become.vet.form') }}" class="flex flex-col items-center justify-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-gray-700">Register Vet</span>
                        </a>

                        <a href="{{ route('vet.index') }}" class="flex flex-col items-center justify-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="mt-2 text-sm font-medium text-gray-700">Manage Vets</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-3xl font-bold">{{ \App\Models\User::count() }}</div>
                        <div class="text-sm text-gray-500">Total Users</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-3xl font-bold">{{ \App\Models\Pet::count() }}</div>
                        <div class="text-sm text-gray-500">Registered Pets</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-3xl font-bold">{{ \App\Models\Vet::count() }}</div>
                        <div class="text-sm text-gray-500">Registered Vets</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-3xl font-bold">{{ \App\Models\DiseaseDetection::count() ?? 0 }}</div>
                        <div class="text-sm text-gray-500">Disease Detections</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Recent Pets -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Recent Pets</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registered</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(\App\Models\Pet::with('user')->latest()->take(5)->get() as $pet)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $pet->pet_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $pet->pet_type }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $pet->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $pet->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('pets.index') }}" class="text-sm text-blue-600 hover:underline">View all pets →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Vets -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Recent Vets</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clinic</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach(\App\Models\Vet::with('user')->latest()->take(5)->get() as $vet)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $vet->user->name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $vet->clinic_name }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $vet->specialization }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vet->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $vet->is_available ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('vet.index') }}" class="text-sm text-blue-600 hover:underline">View all vets →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pet Type Distribution -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Pet Type Distribution</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet Type</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $totalPets = \App\Models\Pet::count();
                                        $petTypes = \App\Models\Pet::select('pet_type')
                                            ->selectRaw('count(*) as count')
                                            ->groupBy('pet_type')
                                            ->orderByDesc('count')
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    
                                    @foreach($petTypes as $type)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $type->pet_type }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $type->count }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ round(($type->count / $totalPets) * 100, 1) }}%</span>
                                                <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($type->count / $totalPets) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Vet Specialization Distribution -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Vet Specializations</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $totalVets = \App\Models\Vet::count();
                                        $vetSpecs = \App\Models\Vet::select('specialization')
                                            ->selectRaw('count(*) as count')
                                            ->groupBy('specialization')
                                            ->orderByDesc('count')
                                            ->take(5)
                                            ->get();
                                    @endphp
                                    
                                    @foreach($vetSpecs as $spec)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $spec->specialization }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $spec->count }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="mr-2">{{ round(($spec->count / $totalVets) * 100, 1) }}%</span>
                                                <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ ($spec->count / $totalVets) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>