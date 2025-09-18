<x-app-layout><!-- vet dashboard -->
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
                       
                        <div class="bg-green-50 p-4 rounded-lg shadow">
                            <div class="text-xl font-bold">{{ $stats['reviews'] ?? 0 }}</div>
                            <div class="text-gray-600">Reviews</div>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm4-1a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1z"
                                        clip-rule="evenodd" />
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

                        @if (count($recentDiseases) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white border border-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                ID</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Pet</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Owner</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Diagnosis</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Reason</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Date</th>
                                            <th
                                                class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($recentDiseases as $disease)
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
                                                        @if ($disease->pet && $disease->pet->image_path)
                                                            <div class="h-8 w-8 rounded-full overflow-hidden mr-3">
                                                                <img src="{{ asset('storage/' . $disease->pet->image_path) }}"
                                                                    alt="{{ $disease->pet->pet_name }}"
                                                                    class="h-full w-full object-cover">
                                                            </div>
                                                        @else
                                                            <div
                                                                class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-4 w-4 text-gray-500" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-9a1 1 0 011 1v4a1 1 0 11-2 0v-4a1 1 0 011-1zm0-4a1 1 0 100 2 1 1 0 000-2z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </div>
                                                        @endif
                                                        <span
                                                            class="font-medium">{{ $disease->pet ? $disease->pet->pet_name : 'Unknown Pet' }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    {{ $disease->user ? $disease->user->name : 'Unknown User' }}</td>
                                                <td class="py-3 px-4 font-medium {{ $textColorClass }}">
                                                    {{ $disease->primary_diagnosis }}</td>
                                                <td class="py-3 px-4 text-xs">
                                                    <span class="inline-block max-w-xs truncate">
                                                        {{ $disease->detection_reason }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    @if ($disease->is_reviewed)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            Reviewed
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-3 px-4 text-gray-500 text-sm">
                                                    {{ $disease->created_at->format('M j, Y g:i A') }}</td>
                                                <td class="py-3 px-4">
                                                    <div class="flex space-x-2">

                                                        <!-- View & Review link (goes to dedicated page) -->
                                                        <a href="{{ route('vet.disease.view', $disease->id) }}"
                                                            class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                            Full Review
                                                        </a>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if (method_exists($recentDiseases, 'links'))
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

                    
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
