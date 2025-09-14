
<x-app-layout><!-- pet -image upload - review results -->
    <div class="py-12 bg-gradient-to-b from-blue-50 to-white">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('pet.show', $pet->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to {{ $pet->pet_name }}'s Profile
                </a>
            </div>

            <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white/20 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-white">Disease Detection Results</h1>
                                <p class="text-amber-100">For {{ $pet->pet_name }} ({{ $pet->pet_breed }} {{ $pet->pet_type }})</p>
                            </div>
                        </div>
                        
                        <div class="hidden md:block">
                            <div class="h-16 w-16 rounded-full overflow-hidden border-2 border-white shadow-lg">
                                <img src="{{ $pet->image_url }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Content -->
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Left column: Uploaded Image -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                </svg>
                                Uploaded Image
                            </h2>
                            <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $uploadedImage) }}" alt="Uploaded condition" class="w-full h-auto object-contain max-h-96">
                            </div>
                            <p class="text-sm text-gray-500 mt-2">Uploaded on {{ $uploadedDate }}</p>
                        </div>
                        
                        <!-- Right column: Analysis Results -->
                        <div>
                            <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-5a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-3-4a1 1 0 100 2h4a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Analysis Results
                            </h2>
                            <div class="space-y-4">
                                @foreach($predictions as $prediction)
                                    @php 
                                        $probability = $prediction['probability'] * 100; 
                                        $colorClass = '';
                                        $bgColorClass = '';
                                        
                                        if ($probability > 70) {
                                            $colorClass = 'bg-red-100 text-red-800';
                                            $barColor = 'bg-red-600';
                                        } elseif ($probability > 30) {
                                            $colorClass = 'bg-yellow-100 text-yellow-800';
                                            $barColor = 'bg-yellow-600';
                                        } else {
                                            $colorClass = 'bg-green-100 text-green-800';
                                            $barColor = 'bg-green-600';
                                        }
                                        
                                        // Map short class names to full class names
                                        $fullClassName = $prediction['className'];
                                        $classNameMap = [
                                            'Hypersensivi...' => 'Hypersensivity Allergic dermatosis',
                                            'Fungal Infec...' => 'Fungal Infections',
                                            'Bacterial de...' => 'Bacterial dermatosis',
                                            'Healthy' => 'Healthy'
                                        ];
                                        
                                        if (array_key_exists($prediction['className'], $classNameMap)) {
                                            $fullClassName = $classNameMap[$prediction['className']];
                                        }
                                    @endphp
                                    
                                    <div class="p-4 rounded-lg {{ $colorClass }}">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="font-medium">{{ $fullClassName }}</span>
                                            <span class="text-sm font-bold ml-2 flex-shrink-0">{{ number_format($probability, 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-white/60 rounded-full h-3">
                                            <div class="h-3 rounded-full {{ $barColor }}" style="width: {{ $probability }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recommendations Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h2 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            Recommendations
                        </h2>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded-lg">
                            @if($recommendationHtml)
                                {!! $recommendationHtml !!}
                            @else
                                <div class="text-blue-800 font-medium mb-2">Recommendations</div>
                                <p class="mb-2">Based on our analysis, we recommend consulting with your veterinarian for a proper diagnosis. While our AI can detect patterns that may indicate certain conditions, only a qualified veterinarian can provide an official diagnosis and treatment plan.</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Schedule an appointment with your vet</li>
                                    <li>Bring this report with you to your appointment</li>
                                    <li>Monitor your pet for any changes or worsening symptoms</li>
                                    <li>Keep the affected area clean and prevent your pet from scratching or licking it</li>
                                </ul>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Add this right after the Recommendations Section, before Action Buttons -->
                    @if(isset($sentToVet) && $sentToVet)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-5 rounded-lg">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h3 class="text-indigo-800 font-medium text-lg">Sent to Veterinarians</h3>
                                        <p class="text-indigo-600">This case has been sent to our veterinarian network for review.</p>
                                        @if(isset($detectionReason))
                                            <p class="text-indigo-600 mt-1 text-sm"><strong>Reason:</strong> {{ $detectionReason }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-wrap gap-4 justify-between">
                        <a href="{{ route('pet.show', $pet->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Pet Profile
                        </a>
                        
                        <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 rounded-lg transition duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                            </svg>
                            Print Results
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>