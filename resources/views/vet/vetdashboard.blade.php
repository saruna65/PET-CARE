<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vet Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome, Dr. {{ auth()->user()->name }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg shadow">
                            <div class="text-xl font-bold">{{ $stats['appointments'] ?? 0 }}</div>
                            <div class="text-gray-600">Appointments</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <div class="text-xl font-bold">{{ $stats['reviews'] ?? 0 }}</div>
                            <div class="text-gray-600">Reviews</div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg shadow">
                            <div class="text-xl font-bold">{{ number_format($stats['rating'] ?? 0, 1) }}</div>
                            <div class="text-gray-600">Rating</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg shadow">
                            <div class="text-xl font-bold">{{ $stats['unreviewed'] ?? 0 }}</div>
                            <div class="text-gray-600">Need Review</div>
                        </div>
                    </div>
                    
                    <!-- Disease Cases Section -->
                    <div class="mt-8">
                        <div class="mb-6 flex justify-between items-center">
                            <h4 class="text-lg font-medium flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm4-1a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Cases Requiring Veterinary Review
                            </h4>
                            <div class="flex space-x-2">
                                <a href="?status=all" 
                                   class="px-4 py-2 {{ !request('status') || request('status') == 'all' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }} rounded-md text-sm font-medium">
                                    All
                                </a>
                                <a href="?status=unreviewed" 
                                   class="px-4 py-2 {{ request('status') == 'unreviewed' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }} rounded-md text-sm font-medium">
                                    Unreviewed
                                </a>
                                <a href="?status=reviewed" 
                                   class="px-4 py-2 {{ request('status') == 'reviewed' ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }} rounded-md text-sm font-medium">
                                    Reviewed
                                </a>
                            </div>
                        </div>

                        @if(count($recentDiseases) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($recentDiseases as $disease)
                                            @php
                                                $confidence = $disease->confidence_score * 100;
                                                $textColorClass = 'text-green-700';
                                                
                                                if ($confidence > 70) {
                                                    $textColorClass = 'text-red-700';
                                                } elseif ($confidence > 30) {
                                                    $textColorClass = 'text-yellow-700';
                                                }
                                            @endphp
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4 text-gray-500">{{ $disease->id }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex items-center">
                                                        @if($disease->pet && $disease->pet->image_path)
                                                            <div class="h-8 w-8 rounded-full overflow-hidden mr-3">
                                                                <img src="{{ asset('storage/' . $disease->pet->image_path) }}" alt="{{ $disease->pet->pet_name }}" class="h-full w-full object-cover">
                                                            </div>
                                                        @else
                                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-9a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1zm0-4a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <span class="font-medium">{{ $disease->pet ? $disease->pet->pet_name : 'Unknown Pet' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">{{ $disease->user ? $disease->user->name : 'Unknown User' }}</td>
                                                <td class="py-3 px-4 font-medium {{ $textColorClass }}">{{ $disease->primary_diagnosis }}</td>
                                                <td class="py-3 px-4 text-xs">
                                                    <span class="inline-block max-w-xs truncate">
                                                        {{ $disease->detection_reason }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    @if($disease->is_reviewed)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Reviewed
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-gray-500 text-sm">{{ $disease->created_at->format('M j, Y g:i A') }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex space-x-2">
                                                        <button type="button" 
                                                                onclick="openDiseaseDetailsModal({{ $disease->id }})" 
                                                                class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                            View
                                                        </button>
                                                        @if(!$disease->is_reviewed)
                                                            <form action="{{ route('vet.mark-reviewed', $disease->id) }}" method="POST" class="inline-block">
                                                                @csrf
                                                                <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                                                                    Mark Reviewed
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
<!-- In the Actions column of the disease table -->
<td class="py-3 px-4">
    <div class="flex space-x-2">
        <a href="{{ route('vet.disease.view', $disease->id) }}" 
           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
            View & Review
        </a>
        @if(!$disease->is_reviewed)
            <form action="{{ route('vet.mark-reviewed', $disease->id) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-900 text-sm font-medium">
                    Mark Reviewed
                </button>
            </form>
        @endif
    </div>
</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            @if(method_exists($recentDiseases, 'links'))
                                <div class="mt-6">
                                    {{ $recentDiseases->links() }}
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 p-6 rounded-lg text-center">
                                <p class="text-gray-500">No disease cases found matching your criteria.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="border-t pt-4 mt-8">
                        <h4 class="font-medium mb-2">Quick Actions</h4>
                        <div class="flex space-x-2">
                            <a href="{{ route('vet.edit.profile') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disease Details Modal -->
    <div id="diseaseDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-xl max-w-4xl w-full mx-4 shadow-2xl">
            <!-- Modal content will be loaded dynamically -->
            <div id="diseaseDetailsModalContent">
                <div class="p-8 text-center">
                    <svg class="animate-spin h-8 w-8 text-indigo-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="mt-2 text-gray-600">Loading disease details...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDiseaseDetailsModal(diseaseId) {
            const modal = document.getElementById('diseaseDetailsModal');
            const modalContent = document.getElementById('diseaseDetailsModalContent');
            
            // Show modal with loading state
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            
            // Fetch the disease details using AJAX
            fetch(`/vet/disease/${diseaseId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => response.json())
            .then(data => {
                // Format the confidence score
                const confidence = (data.confidence_score * 100).toFixed(1);
                
                // Determine color classes based on confidence
                let colorClass = 'bg-green-100 text-green-800';
                let barColor = 'bg-green-600';
                if (data.confidence_score > 0.7) {
                    colorClass = 'bg-red-100 text-red-800';
                    barColor = 'bg-red-600';
                } else if (data.confidence_score > 0.3) {
                    colorClass = 'bg-yellow-100 text-yellow-800';
                    barColor = 'bg-yellow-600';
                }
                
                // Format date
                const date = new Date(data.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                // Build the modal content
                modalContent.innerHTML = `
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-4 rounded-t-xl flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Disease Case Details
                        </h3>
                        <button onclick="closeDiseaseDetailsModal()" class="text-white hover:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Left column: Pet Info & Uploaded Image -->
                            <div>
                                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                    <h4 class="font-medium text-gray-800 mb-3">Pet Information</h4>
                                    <div class="flex items-center mb-2">
                                        <div class="h-12 w-12 rounded-full overflow-hidden mr-3">
                                            <img src="${data.pet_image}" alt="${data.pet_name}" class="h-full w-full object-cover">
                                        </div>
                                        <div>
                                            <h5 class="font-medium">${data.pet_name}</h5>
                                            <p class="text-sm text-gray-600">${data.pet_breed} • ${data.pet_age}</p>
                                        </div>
                                    </div>
                                    <div class="text-sm">
                                        <p class="mb-1"><span class="font-medium">Owner:</span> ${data.owner_name}</p>
                                        <p class="mb-1"><span class="font-medium">Case Date:</span> ${formattedDate}</p>
                                    </div>
                                </div>
                                
                                <h4 class="font-medium text-gray-800 mb-2">Uploaded Image</h4>
                                <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                                    <img src="${data.image_url}" alt="Uploaded condition" class="w-full h-auto object-contain max-h-80">
                                </div>
                                
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-800 mb-1">Flagged for Veterinary Review:</h4>
                                    <p class="text-sm">${data.detection_reason}</p>
                                </div>
                            </div>
                            
                            <!-- Right column: Analysis Results -->
                            <div>
                                <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-5a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-3-4a1 1 0 100 2h4a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Analysis Results
                                </h4>
                                <div class="space-y-4 mb-6">
                                    ${data.results.map(prediction => {
                                        const probability = prediction.probability * 100;
                                        let predColorClass = 'bg-green-100 text-green-800';
                                        let predBarColor = 'bg-green-600';
                                        
                                        if (probability > 70) {
                                            predColorClass = 'bg-red-100 text-red-800';
                                            predBarColor = 'bg-red-600';
                                        } else if (probability > 30) {
                                            predColorClass = 'bg-yellow-100 text-yellow-800';
                                            predBarColor = 'bg-yellow-600';
                                        }
                                        
                                        return `
                                            <div class="p-4 rounded-lg ${predColorClass}">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="font-medium">${prediction.className}</span>
                                                    <span class="text-sm font-bold">${probability.toFixed(1)}%</span>
                                                </div>
                                                <div class="w-full bg-white/60 rounded-full h-3">
                                                    <div class="h-3 rounded-full ${predBarColor}" style="width: ${probability}%"></div>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>
                                
                                <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    Veterinary Recommendations
                                </h4>
                                
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-5 rounded-lg">
                                    ${data.recommendation_html || `
                                        <div class="text-blue-800 font-medium mb-2">Professional Assessment Needed</div>
                                        <p class="mb-2">Based on the AI analysis, this case requires professional veterinary assessment. Consider the following steps:</p>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Contact the pet owner to schedule an in-person examination</li>
                                            <li>Consider additional diagnostic tests to confirm the AI detection</li>
                                            <li>Provide appropriate treatment recommendations based on your professional assessment</li>
                                            <li>Follow up with the pet owner regarding treatment progress</li>
                                        </ul>
                                    `}
                                </div>
                                
                                ${!data.is_reviewed ? `
                                    <div class="mt-6">
                                        <form action="/vet/disease/${data.id}/review" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow transition">
                                                Mark as Reviewed
                                            </button>
                                        </form>
                                    </div>
                                ` : `
                                    <div class="mt-6 bg-green-50 p-4 rounded-lg flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-green-800 font-medium">This case has been reviewed</span>
                                    </div>
                                `}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                        <button onclick="closeDiseaseDetailsModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition mr-2">
                            Close
                        </button>
                        <button onclick="printDiseaseResults()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition">
                            Print Report
                        </button>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Error:', error);
                modalContent.innerHTML = `
                    <div class="p-6">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            <p>Failed to load disease details. Please try again.</p>
                        </div>
                        <div class="mt-4 text-center">
                            <button onclick="closeDiseaseDetailsModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition">
                                Close
                            </button>
                        </div>
                    </div>
                `;
            });
        }
        
        function closeDiseaseDetailsModal() {
            document.getElementById('diseaseDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
        
        function printDiseaseResults() {
            window.print();
        }
    </script>
</x-app-layout>