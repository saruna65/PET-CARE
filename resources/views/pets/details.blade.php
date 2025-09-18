<div class="grid grid-cols-1 md:grid-cols-3 gap-6"> <!-- login in admin -admin dashboard - view pets - view details -->
    <!-- Pet Image -->
    <div class="md:col-span-1">
        <div class="rounded-lg overflow-hidden shadow">
            <img src="{{ $pet->getImageUrlAttribute() }}" alt="{{ $pet->pet_name }}" class="w-full h-auto">
        </div>
    </div>
    
    <!-- Pet Details -->
    <div class="md:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ $pet->pet_name }}</h2>
            <div class="flex space-x-2">
                <span class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded-full">{{ $pet->pet_type }}</span>
                <span class="bg-purple-100 text-purple-800 text-sm px-2 py-1 rounded-full">{{ $pet->getCapitalizedSexAttribute() }}</span>
            </div>
        </div>

        <!-- Pet info cards -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg">
                <span class="text-sm font-medium text-gray-500">Breed</span>
                <p class="text-gray-900 font-medium">{{ $pet->pet_breed }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <span class="text-sm font-medium text-gray-500">Age</span>
                <p class="text-gray-900 font-medium">{{ $pet->getFormattedAgeAttribute() }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <span class="text-sm font-medium text-gray-500">Allergies</span>
                <p class="text-gray-900 font-medium">{{ $pet->allergies ?: 'None' }}</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <span class="text-sm font-medium text-gray-500">Owner</span>
                <p class="text-gray-900 font-medium">{{ $pet->user->name }}</p>
            </div>
        </div>

        <!-- Recent Disease Detections -->
        @if($pet->diseaseDetections && $pet->diseaseDetections->count() > 0)
            <div class="mt-6 bg-white border border-gray-200 rounded-lg">
                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 rounded-t-lg">
                    <h3 class="text-lg font-medium text-gray-800">Recent Health Checks</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Confidence</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pet->diseaseDetections()->latest()->take(5)->get() as $detection)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-2 text-sm">{{ $detection->created_at->format('M d, Y') }}</td>
                                    <td class="px-3 py-2 text-sm font-medium">{{ $detection->primary_diagnosis }}</td>
                                    <td class="px-3 py-2 text-sm">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-1.5 mr-2">
                                                <div class="bg-{{ $detection->confidence_score > 0.7 ? 'red' : ($detection->confidence_score > 0.4 ? 'yellow' : 'green') }}-500 h-1.5 rounded-full" 
                                                    style="width: {{ $detection->confidence_score * 100 }}%"></div>
                                            </div>
                                            <span>{{ number_format($detection->confidence_score * 100, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($pet->diseaseDetections()->count() > 5)
                    <div class="bg-gray-50 px-4 py-2 text-center text-sm text-gray-500 rounded-b-lg">
                        Showing 5 of {{ $pet->diseaseDetections()->count() }} health checks
                    </div>
                @endif
            </div>
        @else
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-700">
                <div class="flex">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <p>No health check records found for this pet.</p>
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        <div class="mt-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
            <h4 class="font-medium text-gray-700 mb-2">Registration Information</h4>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <span class="text-gray-500">Registered on</span>
                    <p>{{ $pet->created_at->format('F d, Y') }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Last updated</span>
                    <p>{{ $pet->updated_at->format('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>