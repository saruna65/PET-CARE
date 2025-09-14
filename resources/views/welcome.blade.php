<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Advanced pet infection detection and veterinary care services">

    <title>Pet Care - Infection Detection</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- TensorFlow and Teachable Machine libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <header class="bg-white dark:bg-gray-800 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <img src="{{ asset('Group63.png') }}" alt="PetCare Logo" class="h-10">
                </div>
                
                <!-- Main Navigation Links -->
                <div class="hidden space-x-6 sm:ml-6 sm:flex">
                    <a href="#features" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-600">
                        How It Works
                    </a>
                    <a href="#demo" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-600">
                        Try Demo
                    </a>
                    <a href="#pets" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-600">
                        Success Stories
                    </a>
                    <a href="#testimonials" class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 inline-flex items-center px-1 pt-1 border-b-2 border-transparent hover:border-indigo-600">
                        Testimonials
                    </a>
                </div>
            </div>

            <div class="flex items-center">
    @if (Route::has('login'))
        <div class="hidden space-x-4 sm:flex">
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ url('/dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                @elseif (auth()->user()->isVet())
                    <a href="{{ route('vet.dashboard') }}"
                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Vet
                        Dashboard</a>
                @else
                    <a href="{{ route('pet.profile') }}"
                        class="text-sm text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">My
                        Pets</a>
                @endif
            @else
                <!-- Fixed login button to match register button style but with different colors -->
                <a href="{{ route('login') }}"
                    class="text-sm px-4 py-2 border border-gray-300 rounded-md font-medium text-gray-700 hover:border-gray-400 hover:bg-gray-50 transition duration-150">
                    Log in
                </a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="text-sm px-4 py-2 bg-indigo-600 rounded-md font-medium text-white hover:bg-indigo-500 transition duration-150">
                        Register
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
        </div>
    </div>
</header>

        <!-- Hero Section -->
        <section class="relative bg-indigo-700 overflow-hidden">


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-32 relative">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl md:text-6xl">
                    Advanced Pet Infection Detection
                </h2>
                <p class="mt-6 max-w-md text-xl text-indigo-100">
                    Early detection saves lives. Our cutting-edge technology helps identify pet infections before
                    they become serious.
                </p>
                <div class="mt-10 flex space-x-4">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}"
                                class="inline-block bg-white py-3 px-6 border border-transparent rounded-md text-base font-medium text-indigo-700 hover:bg-indigo-50">
                                Admin Dashboard
                            </a>
                        @elseif (auth()->user()->isVet())
                            <a href="{{ route('vet.dashboard') }}"
                                class="inline-block bg-white py-3 px-6 border border-transparent rounded-md text-base font-medium text-indigo-700 hover:bg-indigo-50">
                                Vet Dashboard
                            </a>
                        @else
                            <a href="{{ route('pet.profile') }}"
                                class="inline-block bg-white py-3 px-6 border border-transparent rounded-md text-base font-medium text-indigo-700 hover:bg-indigo-50">
                                My Pets
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-block bg-white py-3 px-6 border border-transparent rounded-md text-base font-medium text-indigo-700 hover:bg-indigo-50">
                            Register Now
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-block bg-indigo-600 py-3 px-6 border border-transparent rounded-md text-base font-medium text-white hover:bg-indigo-500">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
            <!-- Hero image remains the same -->
            <div class="hidden md:block relative">
                <img src="https://images.pexels.com/photos/7210754/pexels-photo-7210754.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                    alt="Healthy pet with owner" 
                    class="rounded-lg shadow-2xl w-full object-cover h-80 lg:h-96">
                <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
                    <div class="flex items-center space-x-2 text-sm text-indigo-600 dark:text-indigo-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Early detection is key to pet health</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        <!-- AI Detection Demo Section -->
        <section class="py-16 bg-white dark:bg-gray-800" id="demo">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        Try Our AI Detection Technology
                    </h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                        Upload a photo of your pet to see our advanced infection detection in action
                    </p>
                </div>

                <div class="mt-12 flex flex-col items-center">
                    <div class="bg-gray-100 dark:bg-gray-700 p-8 rounded-lg shadow-md w-full max-w-lg">


                        <div class="flex flex-col items-center mb-6">
                            <label for="imageUpload" class="mb-4 text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select an image of your pet:
                            </label>
                            <input type="file" id="imageUpload" accept="image/*"
                                class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-medium
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100
                                          dark:file:bg-indigo-900 dark:file:text-indigo-300" />

                            <button type="button" onclick="analyzeImage()"
                                class="mt-4 px-6 py-3 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Analyze Image
                            </button>
                        </div>

                        <div id="image-display" class="flex justify-center mb-6">
                            <!-- Uploaded image will be shown here -->
                            <img id="selected-image" class="hidden max-h-64 rounded-lg shadow" />
                        </div>

                        <div id="label-container" class="space-y-2 bg-white dark:bg-gray-600 p-4 rounded-md"></div>

                        <p class="text-gray-500 dark:text-gray-400 text-sm text-center mt-4">
                            For accurate results, upload a clear image of the affected area
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Insert Pet Gallery Section between Features and Testimonials -->
        <section class="py-16 bg-gray-50 dark:bg-gray-900" id="pets">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        Pets We've Helped
                    </h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                        Meet some of the furry friends who benefited from early detection
                    </p>
                </div>

                <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-5">
                    <div class="group overflow-hidden rounded-lg shadow-lg">
                        <div class="overflow-hidden h-48">
                            <img src="https://images.pexels.com/photos/2253275/pexels-photo-2253275.jpeg?auto=compress&cs=tinysrgb&w=600"
                                alt="Golden retriever"
                                class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-3 bg-white dark:bg-gray-800">
                            <p class="font-medium text-gray-700 dark:text-gray-300">Max, Golden Retriever</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Allergic dermatosis detected early</p>
                        </div>
                    </div>

                    <div class="group overflow-hidden rounded-lg shadow-lg">
                        <div class="overflow-hidden h-48">
                            <img src="https://images.unsplash.com/photo-1592194996308-7b43878e84a6" alt="Tabby cat"
                                class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-3 bg-white dark:bg-gray-800">
                            <p class="font-medium text-gray-700 dark:text-gray-300">Luna, Tabby Cat</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Recovered from fungal infection</p>
                        </div>
                    </div>

                    <div class="group overflow-hidden rounded-lg shadow-lg">
                        <div class="overflow-hidden h-48">
                            <img src="https://images.unsplash.com/photo-1551717743-49959800b1f6" alt="Border collie"
                                class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-3 bg-white dark:bg-gray-800">
                            <p class="font-medium text-gray-700 dark:text-gray-300">Cooper, Border Collie</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Skin health monitoring</p>
                        </div>
                    </div>

                    <div class="group overflow-hidden rounded-lg shadow-lg">
                        <div class="overflow-hidden h-48">
                            <img src="https://images.unsplash.com/photo-1526336024174-e58f5cdd8e13" alt="Maine coon"
                                class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110">
                        </div>
                        <div class="p-3 bg-white dark:bg-gray-800">
                            <p class="font-medium text-gray-700 dark:text-gray-300">Bella, Maine Coon</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Bacterial infection treated</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                        Register to get started
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-12 bg-white dark:bg-gray-800" id="features">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        How It Works
                    </h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                        Our advanced system makes pet infection detection simple and accurate
                    </p>
                </div>

                <div class="mt-16 grid gap-8 md:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white text-center">Register Your
                            Pet
                        </h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-400 text-center">
                            Create a profile for your pet with breed, age, and medical history information.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white text-center">Upload Photos
                        </h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-400 text-center">
                            Upload clear photos of any concerning areas on your pet's skin, eyes, or other visible
                            symptoms.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex flex-col items-center">
                        <div class="flex items-center justify-center h-16 w-16 rounded-md bg-indigo-500 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <h3 class="mt-6 text-xl font-medium text-gray-900 dark:text-white text-center">Get Expert
                            Analysis</h3>
                        <p class="mt-2 text-base text-gray-500 dark:text-gray-400 text-center">
                            Our AI system analyzes the images and professional veterinarians review the results to
                            provide expert guidance.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-12 bg-gray-100 dark:bg-gray-700" id="testimonials">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                        Trusted by Pet Owners
                    </h2>
                    <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 mx-auto">
                        See what other pet owners are saying about our services
                    </p>
                </div>

                <div class="mt-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Testimonial 1 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">S</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Sarah T.</h4>
                                <p class="text-gray-500 dark:text-gray-400">Dog Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "The early detection system identified my dog's skin infection before it became serious. The
                            vet consultation was prompt and professional."
                        </p>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">M</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Michael R.</h4>
                                <p class="text-gray-500 dark:text-gray-400">Cat Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "I was concerned about a spot on my cat's ear. The analysis correctly identified it as a
                            simple irritation and saved me an expensive emergency vet visit."
                        </p>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                                <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">J</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">Jennifer K.</h4>
                                <p class="text-gray-500 dark:text-gray-400">Rabbit Owner</p>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">
                            "The platform is so easy to use, and the veterinarians are incredibly knowledgeable. They
                            detected an issue with my rabbit that my regular vet had missed."
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-indigo-700">
            <div
                class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 lg:py-16 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                        Ready to protect your pet's health?
                    </h2>
                    <p class="mt-3 max-w-3xl text-lg leading-6 text-indigo-200">
                        Join thousands of pet owners who use our infection detection platform.
                    </p>
                </div>
                <div class="mt-8 md:mt-0">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                                Admin Dashboard
                            </a>
                        @elseif (auth()->user()->isVet())
                            <a href="{{ route('vet.dashboard') }}"
                                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                                Vet Dashboard
                            </a>
                        @else
                            <a href="{{ route('pet.profile') }}"
                                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                                My Pets
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Get Started Today
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:order-2 space-x-6">
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-8 md:mt-0 md:order-1">
                        <p class="text-center text-base text-gray-500 dark:text-gray-400">&copy; {{ date('Y') }}
                            PetCare, Inc. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Teachable Machine Script -->
    <script type="text/javascript">
        // More API functions here:
        // https://github.com/googlecreativelab/teachablemachine-community/tree/master/libraries/image

        // the link to your model provided by Teachable Machine export panel
        const URL = "https://teachablemachine.withgoogle.com/models/9nk8R6Zfk/";

        let model, labelContainer, maxPredictions;
        let isModelLoaded = false;

        // Event listener for image upload
        document.getElementById('imageUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(event) {
                    const img = document.getElementById('selected-image');
                    img.src = event.target.result;
                    img.classList.remove('hidden');
                    // Clear previous results when a new image is selected
                    document.getElementById('label-container').innerHTML = '';
                };

                reader.readAsDataURL(file);
            }
        });

        // Load the image model
        async function loadModel() {
            if (isModelLoaded) {
                return true;
            }

            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";

            // Show loading indicator
            labelContainer = document.getElementById("label-container");
            labelContainer.innerHTML =
                '<div class="flex items-center justify-center py-4"><svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2 text-indigo-600 dark:text-indigo-400">Loading model...</span></div>';

            try {
                // Load the model
                model = await tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();
                isModelLoaded = true;
                labelContainer.innerHTML = ''; // Clear loading indicator
                return true;
            } catch (error) {
                labelContainer.innerHTML =
                    `<div class="text-red-500 text-center py-2">Error loading model: ${error.message}</div>`;
                console.error('Error loading model:', error);
                return false;
            }
        }

        // Analyze the uploaded image
        // Inside the analyzeImage function, update the prediction display code:

        // Analyze the uploaded image
        async function analyzeImage() {
            const imageUpload = document.getElementById('imageUpload');
            const selectedImage = document.getElementById('selected-image');

            if (imageUpload.files.length === 0) {
                alert('Please select an image first.');
                return;
            }

            // Load model if not already loaded
            const modelLoaded = await loadModel();
            if (!modelLoaded) return;

            // Show analyzing state
            labelContainer = document.getElementById("label-container");
            labelContainer.innerHTML =
                '<div class="flex items-center justify-center py-4"><svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="ml-2 text-indigo-600 dark:text-indigo-400">Analyzing...</span></div>';

            try {
                // Make prediction
                const prediction = await model.predict(selectedImage);

                // Clear analyzing indicator and prepare for results
                labelContainer.innerHTML = '';

                // Map short class names to full class names
                const classNameMap = {
                    'Hypersensivi...': 'Hypersensivity Allergic dermatosis',
                    'Fungal Infec...': 'Fungal Infections',
                    'Bacterial de...': 'Bacterial dermatosis',
                    'Healthy': 'Healthy'
                };

                // Convert prediction array with mapped class names
                const mappedPrediction = prediction.map(pred => {
                    return {
                        className: classNameMap[pred.className] || pred.className,
                        probability: pred.probability
                    };
                });

                // Sort predictions by probability in descending order
                mappedPrediction.sort((a, b) => b.probability - a.probability);

                // Display sorted results
                for (let i = 0; i < maxPredictions; i++) {
                    const pred = mappedPrediction[i];
                    const probability = (pred.probability * 100).toFixed(2);

                    // Color coding based on disease and probability
                    let bgColorClass = 'bg-indigo-50 dark:bg-indigo-900';
                    let textColorClass = 'text-indigo-700 dark:text-indigo-200';
                    let borderClass = '';

                    if (pred.probability > 0.7) {
                        if (pred.className !== 'Healthy') {
                            // High probability disease - red highlight
                            bgColorClass = 'bg-red-50 dark:bg-red-900';
                            textColorClass = 'text-red-700 dark:text-red-200';
                            borderClass = 'border-2 border-red-500';
                        } else {
                            // High probability healthy - green highlight
                            bgColorClass = 'bg-green-50 dark:bg-green-900';
                            textColorClass = 'text-green-700 dark:text-green-200';
                            borderClass = 'border-2 border-green-500';
                        }
                    } else if (pred.probability > 0.3) {
                        // Medium probability - yellow/orange highlight
                        bgColorClass = 'bg-amber-50 dark:bg-amber-900';
                        textColorClass = 'text-amber-700 dark:text-amber-200';
                    }

                    const resultDiv = document.createElement('div');
                    resultDiv.className =
                        `flex justify-between items-center py-2 px-4 ${bgColorClass} ${textColorClass} rounded-md font-medium my-1 ${borderClass}`;

                    const classNameSpan = document.createElement('span');
                    classNameSpan.textContent = pred.className;

                    const probabilitySpan = document.createElement('span');
                    probabilitySpan.className = 'font-bold';
                    probabilitySpan.textContent = `${probability}%`;

                    resultDiv.appendChild(classNameSpan);
                    resultDiv.appendChild(probabilitySpan);
                    labelContainer.appendChild(resultDiv);
                }

                // Add disclaimer text
                const disclaimer = document.createElement('p');
                disclaimer.className = 'text-gray-500 text-xs mt-4 text-center';
                disclaimer.textContent =
                    'This is a preliminary analysis only. Please consult a veterinarian for proper diagnosis.';
                labelContainer.appendChild(disclaimer);

            } catch (error) {
                labelContainer.innerHTML =
                    `<div class="text-red-500 text-center py-2">Error analyzing image: ${error.message}</div>`;
                console.error('Error analyzing image:', error);
            }
        }
    </script>

</body>

</html>
