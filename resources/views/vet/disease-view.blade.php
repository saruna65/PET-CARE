<x-app-layout><!-- vet review -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Disease Case Details') }}
            </h2>
            <a href="{{ route('vet.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back to Dashboard
            </a>
        </div>
    </x-slot>
    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-red-700 text-sm font-medium">
                        Please fix the following errors:
                    </p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Header with case info -->
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="bg-white/20 p-3 rounded-full mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="text-white">
                                <h3 class="text-xl font-bold">{{ $disease->primary_diagnosis }}</h3>
                                <p class="text-white/80">
                                    Case ID: #{{ $disease->id }} •
                                    {{ round($disease->confidence_score * 100, 1) }}% Confidence •
                                    {{ $disease->created_at->format('M j, Y g:i A') }}
                                </p>
                            </div>
                        </div>

                        <div>
                            @if ($disease->is_reviewed)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Reviewed
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Pending Review
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="p-8">
                    <!-- Pet and owner info -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h4 class="font-medium text-gray-800 mb-3">Pet Information</h4>
                        <div class="flex items-center">
                            <div class="h-16 w-16 rounded-full overflow-hidden mr-4">
                                @if ($pet && $pet->image_path)
                                    <img src="{{ asset('storage/' . $pet->image_path) }}" alt="{{ $pet->pet_name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="bg-gray-200 h-full w-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h5 class="font-medium text-lg">{{ $pet ? $pet->pet_name : 'Unknown Pet' }}</h5>
                                <p class="text-gray-600">
                                    {{ $pet ? $pet->pet_breed : '' }}
                                    @if ($pet && $pet->formatted_age)
                                        • {{ $pet->formatted_age }}
                                    @endif
                                </p>
                                <p class="text-gray-600 mt-1">Owner:
                                    {{ $disease->user ? $disease->user->name : 'Unknown Owner' }}</p>
                            </div>
                        </div>
                    </div>

                    @if ($pet && $pet->allergies)
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Known Pet Allergies</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ $pet->allergies }}</p>
                                    </div>
                                    <div class="mt-1">
                                        <p class="text-xs text-red-600">This pet has known allergies that may be related
                                            to the current condition.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left column: Uploaded Image and Flagging Reason -->
                        <div>
                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Uploaded Image
                            </h4>
                            <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('storage/' . $disease->image_path) }}" alt="Uploaded condition"
                                    class="w-full h-auto max-h-96 object-contain">
                            </div>

                            <div class="mt-6">
                                <h4 class="font-medium text-gray-800 mb-2 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Reason for Vet Review
                                </h4>
                                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded">
                                    {{ $disease->detection_reason }}
                                </div>
                            </div>
                        </div>

                        <!-- Right column: AI Analysis Results -->
                        <div>
                            <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12zm-1-5a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1zm-3-4a1 1 0 100 2h4a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                AI Analysis Results
                            </h4>
                            <div class="space-y-4">
                                @foreach ($disease->results as $prediction)
                                    @php
                                        $probability = $prediction['probability'] * 100;
                                        $colorClass = 'bg-green-100 text-green-800';
                                        $barColor = 'bg-green-600';

                                        if ($probability > 70) {
                                            $colorClass = 'bg-red-100 text-red-800';
                                            $barColor = 'bg-red-600';
                                        } elseif ($probability > 30) {
                                            $colorClass = 'bg-yellow-100 text-yellow-800';
                                            $barColor = 'bg-yellow-600';
                                        }
                                    @endphp
                                    <div class="p-4 rounded-lg {{ $colorClass }}">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-medium">{{ $prediction['className'] }}</span>
                                            <span
                                                class="text-sm font-bold">{{ number_format($probability, 1) }}%</span>
                                        </div>
                                        <div class="w-full bg-white/60 rounded-full h-3">
                                            <div class="h-3 rounded-full {{ $barColor }}"
                                                style="width: {{ $probability }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($recommendationHtml)
                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-800 mb-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-amber-500"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        AI Recommendations
                                    </h4>
                                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                        {!! $recommendationHtml !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Vet Review Section -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-bold mb-4">Veterinary Assessment</h3>

                        @if ($disease->is_reviewed && $disease->vet_diagnosis)
                            <!-- Display existing review if already reviewed -->
                            <div class="bg-green-50 rounded-lg p-6 mb-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="font-medium text-gray-800">Diagnosis</h4>
                                        <p class="mt-1">{{ $disease->vet_diagnosis }}</p>
                                    </div>

                                    @if ($disease->is_critical)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Critical Case
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-4">
                                    <h4 class="font-medium text-gray-800">Recommended Treatment</h4>
                                    <div class="mt-1 prose max-w-none">
                                        {!! nl2br(e($disease->vet_treatment)) !!}
                                    </div>
                                </div>

                                @if ($disease->vet_notes)
                                    <div>
                                        <h4 class="font-medium text-gray-800">Additional Notes</h4>
                                        <div class="mt-1 prose max-w-none">
                                            {!! nl2br(e($disease->vet_notes)) !!}
                                        </div>
                                    </div>
                                @endif

                                @if ($disease->has_zoonotic_risk)
                                    <div class="my-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">⚠️ Zoonotic Risk Alert
                                                </h3>
                                                <div class="mt-2 text-sm text-red-700">
                                                    <p class="font-semibold">This condition has the potential to spread
                                                        to humans.</p>
                                                    @if ($disease->zoonotic_precautions)
                                                        <div class="mt-2 prose prose-sm max-w-none">
                                                            <h4 class="text-red-800 font-medium mb-1">Precaution
                                                                Instructions:</h4>
                                                            {!! nl2br(e($disease->zoonotic_precautions)) !!}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div
                                    class="mt-4 pt-4 border-t border-green-200 text-sm text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Reviewed on {{ $disease->reviewed_at->format('M j, Y g:i A') }}
                                    @if ($disease->reviewer)
                                        by Dr. {{ $disease->reviewer->name }}
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('vet.dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                                    Return to Dashboard
                                </a>
                            </div>
                        @else
                            <!-- Review Form if not yet reviewed -->
                            <form action="{{ route('vet.disease.submit-review', $disease->id) }}" method="POST"
                                class="bg-gray-50 rounded-lg p-6">
                                @csrf

                                <div class="mb-6">
                                    <label for="diagnosis"
                                        class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                                    <input type="text" name="diagnosis" id="diagnosis"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                                        value="{{ old('diagnosis') }}" required>
                                    @error('diagnosis')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="treatment"
                                        class="block text-sm font-medium text-gray-700 mb-1">Recommended
                                        Treatment</label>
                                    <textarea name="treatment" id="treatment" rows="5"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                                        required>{{ old('treatment') }}</textarea>
                                    @error('treatment')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <label for="notes"
                                        class="block text-sm font-medium text-gray-700 mb-1">Additional Notes
                                        (optional)</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_critical" id="is_critical" value="1"
                                            class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50"
                                            {{ old('is_critical') ? 'checked' : '' }}>
                                        <label for="is_critical" class="ml-2 text-sm font-medium text-gray-700">Mark
                                            as Critical Case</label>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1">Check this if the condition requires
                                        immediate attention or is potentially life-threatening.</p>
                                </div>

                                <!-- Update the has_zoonotic_risk checkbox -->
                                <div class="mb-6">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="has_zoonotic_risk" id="has_zoonotic_risk"
                                                value="1"
                                                class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50"
                                                {{ old('has_zoonotic_risk') ? 'checked' : '' }}>
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="has_zoonotic_risk" class="font-medium text-gray-700">Zoonotic
                                                Risk Alert</label>
                                            <p class="text-gray-500">Check this if the condition poses a risk of
                                                transmission to humans (zoonotic disease)</p>
                                        </div>
                                    </div>
                                </div>

                                <div id="zoonotic_precautions_container"
                                    class="mb-6 {{ old('has_zoonotic_risk') ? '' : 'hidden' }}">
                                    <label for="zoonotic_precautions"
                                        class="block text-sm font-medium text-gray-700 mb-1">
                                        Zoonotic Precaution Instructions
                                    </label>
                                    <textarea name="zoonotic_precautions" id="zoonotic_precautions" rows="3"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-500 focus:ring-opacity-50"
                                        placeholder="Provide specific instructions for preventing transmission to humans...">{{ old('zoonotic_precautions') }}</textarea>
                                    @error('zoonotic_precautions')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <a href="{{ route('vet.dashboard') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-300">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg shadow transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const zoonoticCheckbox = document.getElementById('has_zoonotic_risk');
            const precautionsContainer = document.getElementById('zoonotic_precautions_container');

            if (zoonoticCheckbox && precautionsContainer) {
                zoonoticCheckbox.addEventListener('change', function() {
                    precautionsContainer.classList.toggle('hidden', !this.checked);

                    // If showing the field, make sure it's required
                    const precautionsField = document.getElementById('zoonotic_precautions');
                    if (precautionsField) {
                        precautionsField.required = this.checked;
                    }
                });

                // Set initial state
                const precautionsField = document.getElementById('zoonotic_precautions');
                if (precautionsField) {
                    precautionsField.required = zoonoticCheckbox.checked;
                }
            }
        });
    </script>
</x-app-layout>
