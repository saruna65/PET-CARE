<x-app-layout><!-- view profile -->
    <div class="py-10 sm:py-14 bg-gradient-to-b from-indigo-50 via-white to-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Top Navigation / Back -->
            <div class="flex items-center justify-between">
                <a href="{{ route('pet.profile') }}"
                    class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium group transition">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Pets
                </a>
            </div>

            <!-- Profile Card -->
            <div class="relative bg-white shadow-xl rounded-2xl overflow-hidden ring-1 ring-gray-100">
                <!-- Header banner -->
                <div class="relative h-56 sm:h-64 bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600">
                    @if ($pet->image_path)
                        <img src="{{ $pet->image_url }}" alt="{{ $pet->pet_name }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-40 mix-blend-multiply">
                    @endif

                    <!-- Action buttons (top-right) -->
                    <div class="absolute top-4 right-4 flex items-center space-x-2">
                        <button type="button" onclick="openDiseaseModal()"
                            class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-amber-500/90 hover:bg-amber-500 shadow-lg shadow-amber-500/30 backdrop-blur-sm text-sm font-medium transition active:scale-95">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                                    clip-rule="evenodd" />
                            </svg>
                            Disease Detection
                        </button>

                        <a href="{{ route('pet.edit', $pet->id) }}"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-white/20 hover:bg-white/30 text-white text-sm font-medium backdrop-blur-sm transition shadow">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>

                        <form action="{{ route('pet.delete', $pet->id) }}" method="POST"
                            onsubmit="return confirm('Delete this pet profile?');" class="inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-red-500/80 hover:bg-red-600 text-white transition shadow-md shadow-red-500/30 active:scale-95"
                                title="Delete">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2v10a2 2 0 002
                                    2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011
                                    2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2
                                    0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- Avatar -->
                    <div class="absolute -bottom-16 left-6">
                        <div
                            class="relative w-40 h-40 rounded-2xl overflow-hidden ring-4 ring-white shadow-2xl bg-white">
                            <img src="{{ $pet->image_url ?? 'https://via.placeholder.com/300x300?text=Pet' }}"
                                alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Name & Breed -->
                    <div class="absolute bottom-4 left-52 pr-6">
                        <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-white drop-shadow-sm">
                            {{ $pet->pet_name }}
                        </h1>
                        <p class="text-white/80 font-medium">{{ $pet->pet_breed }}</p>
                    </div>
                </div>

                <!-- Body -->
                <div class="pt-20 px-6 sm:px-10 pb-10">

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-10">
                        <div
                            class="group relative bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <span class="text-xs font-semibold uppercase tracking-wide text-indigo-500">Type</span>
                            <div class="mt-2 flex items-end justify-between">
                                <p class="text-2xl font-bold text-indigo-800">{{ $pet->pet_type }}</p>
                                <span class="text-indigo-300 group-hover:scale-110 transform transition">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div
                            class="group relative bg-gradient-to-br from-violet-50 to-white border border-violet-100 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <span class="text-xs font-semibold uppercase tracking-wide text-violet-500">Age</span>
                            <div class="mt-2 flex items-end justify-between">
                                <p class="text-2xl font-bold text-violet-800">{{ $pet->formatted_age }}</p>
                                <span class="text-violet-300 group-hover:scale-110 transform transition">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div
                            class="group relative bg-gradient-to-br from-fuchsia-50 to-white border border-fuchsia-100 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                            <span class="text-xs font-semibold uppercase tracking-wide text-fuchsia-500">Sex</span>
                            <div class="mt-2 flex items-end justify-between">
                                <p class="text-2xl font-bold text-fuchsia-800">{{ $pet->capitalized_sex }}</p>
                                <span class="text-fuchsia-300 group-hover:scale-110 transform transition">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M5 9l7-7 7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Sections -->
                    <div class="space-y-10">
                        <!-- Basic Info -->
                        <section>
                            <h2 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                                <span
                                    class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 mr-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0
                                        0116 0zm-7-4a1 1 0 11-2 0 1 1 0
                                        012 0zM9 9a1 1 0 000 2v3a1 1 0
                                        001 1h1a1 1 0 100-2v-3a1 1 0
                                        00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Basic Information
                            </h2>
                            <div
                                class="bg-white border border-gray-200 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6 shadow-sm">
                                <div>
                                    <p class="text-xs uppercase tracking-wide font-semibold text-gray-500">Pet Name</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $pet->pet_name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wide font-semibold text-gray-500">Breed</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $pet->pet_breed }}</p>
                                </div>
                            </div>
                        </section>

                        <!-- Health Info -->
                        <section>
                            <h2 class="flex items-center text-lg font-semibold text-gray-800 mb-4">
                                <span
                                    class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-amber-100 text-amber-600 mr-3">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36
                                        2.722-1.36 3.486 0l5.58 9.92c.75
                                        1.334-.213 2.98-1.742 2.98H4.42c-1.53
                                        0-2.493-1.646-1.743-2.98l5.58-9.92zM11
                                        13a1 1 0 11-2 0 1 1 0 012
                                        0zm-1-8a1 1 0 00-1 1v3a1 1 0
                                        002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                Health Information
                            </h2>
                            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                                <div>
                                    <p class="text-xs uppercase tracking-wide font-semibold text-gray-500">Known
                                        Allergies</p>
                                    <div class="mt-3">
                                        @if ($pet->allergies)
                                            <div class="relative rounded-xl bg-yellow-50 border border-yellow-200 p-5">
                                                <div class="flex items-start">
                                                    <span class="mt-0.5 mr-3 text-yellow-500">
                                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36
                                                            2.722-1.36 3.486 0l5.58 9.92c.75
                                                            1.334-.213 2.98-1.742 2.98H4.42c-1.53
                                                            0-2.493-1.646-1.743-2.98l5.58-9.92zM11
                                                            13a1 1 0 11-2 0 1 1 0 012
                                                            0zm-1-8a1 1 0 00-1 1v3a1 1 0
                                                            002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </span>
                                                    <p class="text-sm leading-relaxed text-yellow-900 font-medium">
                                                        {{ $pet->allergies }}
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic">No known allergies recorded.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                    <!-- Footer Actions -->
                    <div class="mt-12 flex flex-col sm:flex-row gap-4 sm:items-center justify-between">
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('pet.profile') }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium text-sm transition">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414
                                    0l-6-6a1 1 0 010-1.414l6-6a1 1 0
                                    011.414 1.414L5.414 9H17a1 1 0 110
                                    2H5.414l4.293 4.293a1 1 0 010
                                    1.414z" clip-rule="evenodd" />
                                </svg>
                                All Pets
                            </a>

                            <button type="button" onclick="openDiseaseModal()"
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm shadow transition md:hidden">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8
                                    0 000 16zM7 9a1 1 0 000 2h6a1 1 0
                                    100-2H7z" clip-rule="evenodd" />
                                </svg>
                                Disease Detection
                            </button>
                        </div>


                    </div>
                </div>
            </div>

            <!-- Disease Detection History -->
            <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0
                            002 2h8a2 2 0 002-2V7.414A2 2 0
                            0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2
                            10a1 1 0 10-2 0v3a1 1 0 102
                            0v-3zm4-1a1 1 0 011 1v3a1 1 0 11-2
                            0v-3a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Disease Detection History</h2>
                        <p class="text-sm text-amber-100">{{ $pet->pet_name }}'s previous scans</p>
                    </div>
                </div>

                <div class="p-6">
                    @if (isset($diseaseDetections) && count($diseaseDetections) > 0)
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($diseaseDetections as $d)
                                @php
                                    $conf = $d->confidence_score * 100;
                                    $badge =
                                        $conf > 70
                                            ? 'bg-red-100 text-red-700'
                                            : ($conf > 30
                                                ? 'bg-yellow-100 text-yellow-700'
                                                : 'bg-green-100 text-green-700');
                                @endphp
                                <div
                                    class="group relative flex flex-col rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white shadow-sm hover:shadow-md hover:border-indigo-200 transition overflow-hidden">
                                    <div class="relative h-36 bg-gray-100 overflow-hidden">
                                        <img src="{{ asset('storage/' . $d->image_path) }}" alt="Scan image"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        <div
                                            class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-xs font-semibold bg-black/50 text-white backdrop-blur">
                                            {{ $d->created_at->format('M d, Y') }}
                                        </div>
                                        <div
                                            class="absolute top-2 right-2 px-2 py-0.5 rounded-md text-xs font-semibold {{ $badge }}">
                                            {{ number_format($conf, 1) }}%
                                        </div>
                                    </div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <h3 class="font-semibold text-gray-800 text-sm line-clamp-1">
                                            {{ $d->primary_diagnosis }}</h3>
                                        <p class="text-xs text-gray-500 mt-1 mb-3 line-clamp-2">
                                            AI preliminary detection record.
                                        </p>
                                        <div class="mt-auto">
                                            <button type="button" onclick="openDetectionModal({{ $d->id }})"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm font-medium group">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000
                                                    4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943
                                                    5.522 3 10 3s8.268 2.943 9.542 7c-1.274
                                                    4.057-5.064 7-9.542 7S1.732 14.057.458
                                                    10zM14 10a4 4 0 11-8 0 4 4 0
                                                    018 0z" clip-rule="evenodd" />
                                                </svg>
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($diseaseDetections instanceof \Illuminate\Pagination\LengthAwarePaginator && $diseaseDetections->hasPages())
                            <div class="mt-8 border-t border-gray-200 pt-5">
                                {{ $diseaseDetections->links() }}
                            </div>
                        @endif
                    @else
                        <div class="py-14 text-center">
                            <div
                                class="mx-auto w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8
                                    0 000 16zM7 9a1 1 0 000 2h6a1 1 0
                                    100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No detections yet</h3>
                            <p class="text-gray-500 mb-5">Run your first image analysis to begin tracking.</p>
                            <button onclick="openDiseaseModal()" type="button"
                                class="inline-flex items-center px-5 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-medium shadow transition">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8
                                    0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0
                                    000 2h2v2a1 1 0 102 0v-2h2a1 1 0
                                    000-2h-2V7z" clip-rule="evenodd" />
                                </svg>
                                Perform Detection
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vet Diagnosed Conditions -->
            <div class="bg-white rounded-2xl shadow-xl ring-1 ring-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-6 flex items-center">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mr-4">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10
                            18.9l-4.95-4.95a7 7 0 010-9.9zM10
                            11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">Vet Diagnosed Conditions</h2>
                        <p class="text-sm text-blue-100">Professional reviews & status</p>
                    </div>
                </div>
                <div class="p-6">
                    @if (isset($vetDiseases) && count($vetDiseases) > 0)
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($vetDiseases as $vd)
                                <div
                                    class="group relative flex flex-col rounded-xl border border-gray-200 bg-gradient-to-br from-gray-50 to-white shadow-sm hover:shadow-md hover:border-blue-200 transition overflow-hidden">
                                    <div class="relative h-36 bg-gray-100 overflow-hidden">
    <img src="{{ asset('storage/' . $vd->image_path) }}"
        alt="Vet diagnosis image"
        class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
    <div class="absolute top-2 left-2 flex flex-col space-y-1">
        @if ($vd->is_critical)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-red-600 text-white shadow">
                Critical
            </span>
        @endif
        
        @if ($vd->has_zoonotic_risk)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-yellow-600 text-white shadow">
                Zoonotic Risk
            </span>
        @endif
    </div>
</div>
                                    <div class="p-4 flex flex-col flex-1">
                                        <h3 class="font-semibold text-gray-800 text-sm line-clamp-1">
                                            {{ $vd->vet_diagnosis ?? $vd->primary_diagnosis }}
                                        </h3>
                                        <p class="text-xs text-gray-500 mt-1 mb-3 line-clamp-2">
                                            @if ($vd->reviewed_at)
                                                Reviewed
                                                {{ \Carbon\Carbon::parse($vd->reviewed_at)->format('M d, Y') }}
                                            @else
                                                Submitted {{ $vd->created_at->format('M d, Y') }}
                                            @endif
                                        </p>
                                        <div class="mt-auto">
                                            <button type="button" onclick="openVetDiseaseModal({{ $vd->id }})"
                                                class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 12a2 2 0 100-4 2 2 0 000
                                                    4z" />
                                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943
                                                    5.522 3 10 3s8.268 2.943 9.542 7c-1.274
                                                    4.057-5.064 7-9.542 7S1.732 14.057.458
                                                    10zM14 10a4 4 0 11-8 0 4 4 0
                                                    018 0z" clip-rule="evenodd" />
                                                </svg>
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($vetDiseases instanceof \Illuminate\Pagination\LengthAwarePaginator && $vetDiseases->hasPages())
                            <div class="mt-8 border-t border-gray-200 pt-5">
                                {{ $vetDiseases->links() }}
                            </div>
                        @endif
                    @else
                        <div class="py-14 text-center">
                            <div
                                class="mx-auto w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10
                                    18.9l-4.95-4.95a7 7 0 010-9.9zM10
                                    11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">No vet diagnoses yet</h3>
                            <p class="text-gray-500">Awaiting professional review.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- Vet Disease Modal -->
    <div id="vetDiseaseModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center px-4 py-8 overflow-y-auto">
        <div
            class="bg-white rounded-2xl max-w-5xl w-full shadow-2xl  flex flex-col max-h-[92vh] animate-[fadeIn_.4s_ease]">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 flex items-center justify-between">
                <h3 id="vetDiseaseModalTitle" class="text-white font-semibold text-lg flex items-center space-x-2">
                    <span class="inline-flex">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10
                            18.9l-4.95-4.95a7 7 0 010-9.9zM10
                            11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span>Loading...</span>
                </h3>
                <button onclick="closeVetDiseaseModal()" class="text-white/90 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="vetDiseaseModalContent" class="flex-1 overflow-y-auto p-6">
                <div class="flex items-center justify-center py-12">
                    <svg class="w-10 h-10 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373
                        0 0 5.373 0 12h4z" />
                    </svg>
                </div>
            </div>
            <div class="border-t bg-gray-50 px-6 py-4 flex items-center justify-between">
                <button onclick="closeVetDiseaseModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium transition">
                    Close
                </button>

            </div>
        </div>
    </div>

    <!-- Disease Detection Modal -->
    <div id="diseaseModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center px-4 py-8">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-2xl  overflow-hidden animate-[fadeIn_.35s_ease]">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-semibold text-lg flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2
                        5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                        01.707.293l5.414 5.414a1 1 0
                        01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Pet Disease Detection
                </h3>
                <button onclick="closeDiseaseModal()" class="text-white/90 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-600 mb-5">
                    Upload a clear photo of the affected area for AI analysis. Results are preliminary and should be
                    confirmed by a veterinarian.
                </p>
                <form id="diseaseForm" method="POST" enctype="multipart/form-data"
                    action="{{ route('disease.analyze', $pet->id) }}" onsubmit="analyzeAndSubmit(event)">
                    @csrf
                    <input type="hidden" name="predictions_json" id="predictions_json">
                    <div class="space-y-5">
                        <div>
                            <div id="imagePreview"
                                class="relative w-full h-64 rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden text-gray-400">
                                <div class="flex flex-col items-center text-center px-4">
                                    <svg class="w-14 h-14 mb-3" fill="none" stroke="currentColor"
                                        stroke-width="1.3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7
                                              15V9a5 5 0 0110 0v6" />
                                    </svg>
                                    <p class="text-sm font-medium">Drag & Drop or Select an Image</p>
                                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-center">
                                <label for="imageUpload"
                                    class="cursor-pointer inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-medium text-sm transition">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2
                                        2v10a2 2 0 002 2h12a2 2 0
                                        002-2V5a2 2 0 00-2-2H4zm5
                                        10a1 1 0 102 0V9a1 1 0
                                        10-2 0v4zM9 7a1 1 0 102 0 1 1 0
                                        00-2 0z" clip-rule="evenodd" />
                                    </svg>
                                    Choose Image
                                </label>
                                <input id="imageUpload" name="disease_image" type="file" accept="image/*"
                                    class="hidden" required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex items-center justify-between pt-5 border-t border-gray-200">
                        <button type="button" onclick="closeDiseaseModal()"
                            class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
                            Cancel
                        </button>
                        <button id="analyzeButton" type="submit" disabled
                            class="inline-flex items-center px-6 py-2.5 rounded-lg bg-amber-500 disabled:opacity-50 disabled:cursor-not-allowed hover:bg-amber-600 text-white font-medium text-sm shadow transition">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8
                                0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1
                                0 000 2h2v2a1 1 0 102 0v-2h2a1 1 0
                                000-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Analyze Image
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Detection Results Modal -->
    <div id="detectionModal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center px-4 py-8 overflow-y-auto">
        <div
            class="bg-white rounded-2xl max-w-5xl w-full shadow-2xl 0 flex flex-col max-h-[92vh] animate-[fadeIn_.4s_ease]">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4 flex items-center justify-between">
                <h3 id="detectionModalTitle" class="text-white font-semibold text-lg flex items-center space-x-2">
                    <span>Loading...</span>
                </h3>
                <button onclick="closeDetectionModal()" class="text-white/90 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="detectionModalContent" class="flex-1 overflow-y-auto p-6">
                <div class="flex items-center justify-center py-12">
                    <svg class="w-10 h-10 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                </div>
            </div>
            <div class="border-t bg-gray-50 px-6 py-4 flex items-center justify-between">
                <button onclick="closeDetectionModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium transition">
                    Close
                </button>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script>
        // OPEN / CLOSE MODALS
        function openDiseaseModal() {
            document.getElementById('diseaseModal').classList.remove('hidden');
            document.getElementById('diseaseModal').classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeDiseaseModal() {
            const modal = document.getElementById('diseaseModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            const form = document.getElementById('diseaseForm');
            form.reset();
            document.getElementById('imagePreview').innerHTML = `
                <div class="flex flex-col items-center text-center px-4 text-gray-400">
                    <svg class="w-14 h-14 mb-3" fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 
                              15V9a5 5 0 0110 0v6"/>
                    </svg>
                    <p class="text-sm font-medium">Drag & Drop or Select an Image</p>
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                </div>`;
            const analyzeBtn = document.getElementById('analyzeButton');
            analyzeBtn.disabled = true;
            analyzeBtn.innerHTML = `
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 000 2h2v2a1 1 0 102 0v-2h2a1 1 0 000-2h-2V7z" clip-rule="evenodd"/>
                </svg>
                Analyze Image
            `;
        }

        function openDetectionModal(id) {
            const modal = document.getElementById('detectionModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            const content = document.getElementById('detectionModalContent');
            const title = document.getElementById('detectionModalTitle');


            title.innerHTML = 'Loading...';
            content.innerHTML = `<div class="flex items-center justify-center py-12">
                                    <svg class="w-10 h-10 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </div>`;

            fetch(`/pet/{{ $pet->id }}/disease/${id}/details`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    // Map short class names to full class names
                    const classNameMap = {
                        'Hypersensivi...': 'Hypersensivity Allergic dermatosis',
                        'Fungal Infec...': 'Fungal Infections',
                        'Bacterial de...': 'Bacterial dermatosis',
                        'Healthy': 'Healthy'
                    };

                    // Get full name for primary diagnosis
                    let primaryDiagnosis = data.primary_diagnosis;
                    if (classNameMap[primaryDiagnosis]) {
                        primaryDiagnosis = classNameMap[primaryDiagnosis];
                    }

                    title.innerHTML = `Detection Results: ${primaryDiagnosis}`;
                    const confidence = (data.confidence_score * 100).toFixed(1);
                    let barColor = 'bg-green-600';
                    let headerColor = 'bg-green-100 text-green-800';
                    if (data.confidence_score > 0.7) {
                        barColor = 'bg-red-600';
                        headerColor = 'bg-red-100 text-red-800';
                    } else if (data.confidence_score > 0.3) {
                        barColor = 'bg-yellow-600';
                        headerColor = 'bg-yellow-100 text-yellow-800';
                    }
                    const created = new Date(data.created_at).toLocaleString();

                    const isSmall = window.innerWidth < 768;
                    const layout = isSmall ? 'flex  flex-col space-y-8' : 'grid md:grid-cols-5 gap-8';

                    content.innerHTML = `
                <div class="${layout}">
                    <div class="${isSmall ? '' : 'md:col-span-2'}">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Uploaded Image</h4>
                        <div class="rounded-xl overflow-hidden bg-gray-100 ">
                            <img src="${data.image_url}" alt="Detection image" class="w-full h-auto object-cover max-h-80">
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Uploaded: ${created}</p>
                        <div class="mt-5 p-4 rounded-xl ${headerColor} shadow">
                            <p class="text-xs font-semibold uppercase tracking-wide mb-1">Primary Diagnosis</p>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-lg font-bold">${primaryDiagnosis}</span>
                                <span class="text-sm font-semibold">${confidence}%</span>
                            </div>
                            <div class="w-full h-2.5 bg-white/60 rounded-full overflow-hidden">
                                <div class="h-2.5 ${barColor} rounded-full" style="width:${confidence}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="${isSmall ? '' : 'md:col-span-3'}">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Detailed Probabilities</h4>
                        <div class="space-y-3 mb-6">
                            ${data.results.map(r => {
                                const pct = (r.probability * 100).toFixed(1);
                                let rc = 'bg-green-100 text-green-800';
                                let bc = 'bg-green-600';
                                if (r.probability > 0.7) { rc = 'bg-red-100 text-red-800'; bc = 'bg-red-600'; }
                                else if (r.probability > 0.3) { rc = 'bg-yellow-100 text-yellow-800'; bc = 'bg-yellow-600'; }
                                
                                // Get full class name
                                let className = r.className;
                                if (classNameMap[className]) {
                                    className = classNameMap[className];
                                }
                                
                                return `<div class="p-3 rounded-lg ${rc} shadow">
    <div class="flex items-center justify-between mb-1">
        <span class="font-medium text-sm">${className}</span>
        <span class="text-xs font-semibold">${pct}%</span>
    </div>
    <div class="w-full h-2 bg-white/60 rounded-full overflow-hidden">
        <div class="h-2 ${bc}" style="width:${pct}%"></div>
    </div>
</div>`;
                            }).join('')}
                        </div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Recommendations</h4>
                        <div class="rounded-xl bg-blue-50 border border-blue-200 p-4 text-sm leading-relaxed text-blue-900">
                            ${data.recommendation_html || `
                                        <p class="mb-2">Consult your veterinarian to confirm these AI-generated findings.</p>
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li>Monitor symptoms progression</li>
                                            <li>Prepare medical history for vet</li>
                                            <li>Schedule a follow-up scan if condition changes</li>
                                        </ul>
                                    `}
                        </div>
                        <div class="mt-6 pt-5 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
                            <span>ID: #${data.id}</span>
                            <span>Confidence: ${confidence}%</span>
                        </div>
                    </div>
                </div>
            `;

                })
                .catch(() => {
                    content.innerHTML = `
                <div class="p-6 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    Failed to load detection details. Please try again.
                </div>`;
                });
        }

        function closeDetectionModal() {
            const modal = document.getElementById('detectionModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        function openVetDiseaseModal(id) {
            const modal = document.getElementById('vetDiseaseModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');

            const content = document.getElementById('vetDiseaseModalContent');
            const title = document.getElementById('vetDiseaseModalTitle');
            const printBtn = document.getElementById('printVetDiseaseBtn');

            title.innerHTML = 'Loading...';
            content.innerHTML = `<div class="flex items-center justify-center py-12">
                <svg class="w-10 h-10 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </div>`;

            fetch(`/pet/{{ $pet->id }}/vet-disease/${id}/details`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    title.innerHTML = `Veterinary Diagnosis: ${data.vet_diagnosis || data.primary_diagnosis}`;
                    const created = new Date(data.created_at).toLocaleDateString();
                    const reviewed = data.reviewed_at ? new Date(data.reviewed_at).toLocaleDateString() : null;

                    const isSmall = window.innerWidth < 768;
                    const layout = isSmall ? 'flex flex-col space-y-8' : 'grid md:grid-cols-5 gap-8';

                    content.innerHTML = `
                <div class="${layout}">
                    <div class="${isSmall ? '' : 'md:col-span-2'}">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Reference Image</h4>
                        <div class="rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                            <img src="${data.image_url}" alt="Vet disease image" class="w-full h-auto object-contain max-h-80">
                        </div>
                        <div class="mt-4 p-4 rounded-xl bg-blue-50 border border-blue-200">
                            <p class="text-xs uppercase font-semibold tracking-wide text-blue-600 mb-2">Assessment</p>
                            <p class="text-lg font-bold text-blue-800 mb-1">${data.vet_diagnosis || data.primary_diagnosis}</p>
                            
                            <!-- Display Critical and Zoonotic Risk badges -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                ${data.is_critical ? 
                                    `<span class="inline-flex items-center px-2 py-1 rounded-md bg-red-100 text-red-700 text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Critical Condition
                                    </span>` 
                                    : ''
                                }
                                
                                <!-- Add Zoonotic Risk Badge -->
                                ${data.has_zoonotic_risk ? 
                                    `<span class="inline-flex items-center px-2 py-1 rounded-md bg-yellow-100 text-yellow-800 text-xs font-semibold">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                                        </svg>
                                        Zoonotic Risk
                                    </span>`
                                    : ''
                                }
                            </div>
                            <p class="mt-3 text-xs text-gray-500">Submitted: ${created}</p>
                            ${reviewed ? `<p class="text-xs text-gray-500">Reviewed: ${reviewed}</p>` : ''}
                        </div>
                    </div>
                    <div class="${isSmall ? '' : 'md:col-span-3'}">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Diagnosis Details</h4>
                        <div class="rounded-xl bg-gray-50 border border-gray-200 p-5 text-sm space-y-4">
                            ${data.vet_diagnosis ? `
                                    <div>
                                        <p class="font-semibold text-gray-700 mb-1">Diagnosis</p>
                                        <p class="text-gray-800 leading-relaxed">${data.vet_diagnosis}</p>
                                    </div>` : `<p class="italic text-gray-500">No veterinarian diagnosis provided yet.</p>`
                            }
                            ${data.vet_treatment ? `
                                    <div>
                                        <p class="font-semibold text-gray-700 mb-1">Treatment Plan</p>
                                        <p class="text-gray-800 leading-relaxed">${data.vet_treatment}</p>
                                    </div>` : ''
                            }
                        </div>

                        <!-- Add Zoonotic Risk Warning -->
                        ${data.has_zoonotic_risk ? `
                            <div class="mt-6">
                                <div class="rounded-xl bg-yellow-50 border border-yellow-300 p-5 shadow-sm">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="text-yellow-800 font-semibold mb-2">⚠️ Zoonotic Risk Warning</h5>
                                            <p class="text-yellow-700 text-sm mb-3">This condition can potentially spread from your pet to humans. Please take precautions.</p>
                                            ${data.zoonotic_precautions ? `
                                                <div class="bg-white/80 rounded-lg p-3 border border-yellow-200">
                                                    <p class="text-xs font-medium text-yellow-800 mb-1">Precaution Instructions:</p>
                                                    <p class="text-sm text-yellow-800">${data.zoonotic_precautions}</p>
                                                </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ` : ''}

                        ${data.vet_notes ? `
                                <h4 class="text-sm font-semibold text-gray-700 mt-6 mb-3">Veterinarian Notes</h4>
                                <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-5 text-sm text-gray-800 leading-relaxed">
                                    ${data.vet_notes}
                                </div>` : ''
                        }

                        <h4 class="text-sm font-semibold text-gray-700 mt-8 mb-3">AI Initial Assessment</h4>
                        <div class="space-y-3">
                            ${(data.results && Array.isArray(data.results) && data.results.length) ? data.results.map(r => {
                                const pct = (r.probability * 100).toFixed(1);
                                let rc = 'bg-green-100 text-green-800';
                                let bc = 'bg-green-600';
                                if (r.probability > 0.7) { rc = 'bg-red-100 text-red-800'; bc = 'bg-red-600'; }
                                else if (r.probability > 0.3) { rc = 'bg-yellow-100 text-yellow-800'; bc = 'bg-yellow-600'; }
                                return `
                                    <div class="p-3 rounded-lg ${rc} shadow">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="font-medium text-sm">${r.className}</span>
                                            <span class="text-xs font-semibold">${pct}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-white/60 rounded-full overflow-hidden">
                                            <div class="h-2 ${bc}" style="width:${pct}%"></div>
                                        </div>
                                    </div>
                                `;
                            }).join('') : `<p class="italic text-gray-500 text-sm">No AI assessment data.</p>`}
                        </div>

                        <div class="mt-6 pt-5 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
                            <span>Case ID: #${data.id}</span>
                            ${data.reviewed_by ? `<span>Reviewed by: Dr. ${data.reviewer_name || 'Unknown'}</span>` : ''}
                        </div>
                    </div>
                </div>
            `;
                        
                    })
                    .catch(() => {
                        content.innerHTML = ` <
                div class = "p-6 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm" >
                Failed to load vet diagnosis details.Please
                try again. <
                    /div>`;
                });
        }

        function closeVetDiseaseModal() {
            const modal = document.getElementById('vetDiseaseModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Image preview and Teachable Machine Logic
        const imageInput = document.getElementById('imageUpload');
        const preview = document.getElementById('imagePreview');
        const analyzeBtn = document.getElementById('analyzeButton');
        let selectedImageElement = null;

        if (imageInput) {
            imageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = ev => {
                        selectedImageElement = document.createElement('img');
                        selectedImageElement.src = ev.target.result;
                        selectedImageElement.className = 'w-full h-full object-cover';
                        preview.innerHTML = '';
                        preview.appendChild(selectedImageElement);
                        analyzeBtn.disabled = false;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `<div class="flex flex-col items-center text-center px-4 text-gray-400">
                        <svg class="w-14 h-14 mb-3" fill="none" stroke="currentColor" stroke-width="1.3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 15a4 4 0 004 4h10a4 4 0 004-4M7 
                                  15V9a5 5 0 0110 0v6"/>
                        </svg>
                        <p class="text-sm font-medium">Drag & Drop or Select an Image</p>
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                    </div>`;
                    analyzeBtn.disabled = true;
                    selectedImageElement = null;
                }
            });
        }

        // Teachable Machine Integration
        const URL = "https://teachablemachine.withgoogle.com/models/9nk8R6Zfk/";
        let model;
        let isModelLoaded = false;

        async function loadModel() {
            if (isModelLoaded) return;
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            try {
                model = await tmImage.load(modelURL, metadataURL);
                isModelLoaded = true;
            } catch (error) {
                console.error("Error loading model:", error);
                alert("Failed to load the analysis model. Please try again later.");
                throw error; // re-throw to stop execution
            }
        }

        async function analyzeAndSubmit(event) {
            event.preventDefault(); // Prevent normal form submission
            if (!selectedImageElement) {
                alert('Please select an image first.');
                return;
            }

            const form = document.getElementById('diseaseForm');
            const button = document.getElementById('analyzeButton');

            button.disabled = true;
            button.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Analyzing...
            `;

            try {
                await loadModel();
                const predictions = await model.predict(selectedImageElement);

                // Add predictions to a hidden input
                const predictionsInput = document.getElementById('predictions_json');
                predictionsInput.value = JSON.stringify(predictions);

                // Now submit the form
                form.submit();

            } catch (error) {
                console.error("Analysis failed:", error);
                alert("An error occurred during image analysis. Please try again.");
                // Re-enable button
                button.disabled = false;
                button.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 000 2h2v2a1 1 0 102 0v-2h2a1 1 0 000-2h-2V7z" clip-rule="evenodd"/>
                    </svg>
                    Analyze Image
                `;
            }
        }
    </script>
</x-app-layout>
