<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Login Form Side -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-md lg:w-96">
                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('Group63.png') }}" alt="PetCare Logo" class="h-16">
                </div>
                
                <div>
                    <h2 class="mt-2 text-3xl font-extrabold text-gray-800">Welcome back</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Sign in to access your account
                    </p>
                </div>

                <div class="mt-8">
                    <!-- Social Login Buttons -->
                    

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4 mt-6" :status="session('status')" />
                    
                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1">
                                <x-text-input id="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                                    placeholder="email@example.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between">
                                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-1">
                                <x-text-input id="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    type="password" name="password" required autocomplete="current-password"
                                    placeholder="••••••••" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            {{ __("Don't have an account?") }}
                            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Sign up now') }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Illustration Side -->
        <div class="hidden lg:block relative flex-1">
            <div class="absolute inset-0 h-full w-full object-cover bg-gradient-to-b from-indigo-100 via-blue-50 to-white">
                <div class="h-full flex flex-col justify-center items-center px-8">
                    <!-- SVG Illustration -->
                    <div class="max-w-md mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" class="w-full h-auto">
                            <!-- Pet owner with cat illustration -->
                            <style>
                                .pet-primary { fill: #6366f1; }
                                .pet-secondary { fill: #818cf8; }
                                .pet-accent { fill: #4f46e5; }
                                .pet-light { fill: #e0e7ff; }
                                .pet-dark { fill: #4338ca; }
                                .pet-white { fill: #ffffff; }
                                .pet-outline { fill: none; stroke: #4338ca; stroke-width: 2; stroke-linecap: round; }
                            </style>
                            <!-- Background -->
                            <circle cx="250" cy="250" r="200" class="pet-light" />
                            
                            <!-- Cat -->
                            <ellipse cx="300" cy="250" rx="40" ry="30" class="pet-secondary" />
                            <circle cx="300" cy="220" r="30" class="pet-secondary" />
                            <path d="M270 215 L 260 180 L 275 210" class="pet-secondary" />
                            <path d="M330 215 L 340 180 L 325 210" class="pet-secondary" />
                            <circle cx="285" cy="215" r="5" class="pet-dark" />
                            <circle cx="315" cy="215" r="5" class="pet-dark" />
                            <path d="M290 225 C 300 235, 300 235, 310 225" stroke="#4338ca" stroke-width="2" fill="none" />
                            
                            <!-- Person -->
                            <ellipse cx="200" cy="260" rx="45" ry="55" class="pet-white" />
                            <circle cx="200" cy="190" r="40" class="pet-white" />
                            <path d="M160 250 C 160 310, 240 310, 240 250" class="pet-white" />
                            
                            <!-- Hand petting cat -->
                            <path d="M235 235 C 250 230, 265 235, 280 240" stroke="#ffffff" stroke-width="8" fill="none" />
                            
                            <!-- Hearts -->
                            <path d="M260 180 C 265 160, 285 160, 290 180 L 275 200 Z" class="pet-primary" />
                            <path d="M320 190 C 325 170, 345 170, 350 190 L 335 210 Z" class="pet-primary" />
                            
                            <!-- Text -->
                            <text x="250" y="350" text-anchor="middle" font-family="Arial" font-size="16" font-weight="bold" fill="#4338ca">Welcome Back to Pet Care</text>
                        </svg>
                    </div>
                    
                    <!-- Quote Box -->
                    <div class="mt-10 max-w-md mx-auto bg-white rounded-lg shadow-lg p-6 transform hover:scale-105 transition-transform duration-300">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 text-indigo-500">
                                <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 32 32">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-base italic text-gray-600">We've been using Pet Care for all our veterinary needs. The platform makes it so easy to schedule appointments and keep track of our pets' health records.</p>
                                <div class="mt-3 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-medium">JD</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">John Doe</p>
                                        <p class="text-xs text-gray-500">Pet Owner, 2 Dogs & 1 Cat</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>