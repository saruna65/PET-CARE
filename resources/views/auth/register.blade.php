<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex">
        <!-- Registration Form Side -->
        <div class="flex-1 flex flex-col justify-center py-4 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-md lg:w-96">
                
                
                <div>
                    <h2 class="mt-0 text-3xl font-extrabold text-gray-800">Create your account</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        Join our community of pet lovers and veterinarians
                    </p>
                </div>

                <div class="mt-8">
                    
                    
                    <!-- Registration Form -->
                    <div class="mt-6">
                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" class="block text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="name" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                                        placeholder="John Doe" />
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                        type="email" name="email" :value="old('email')" required autocomplete="username" 
                                        placeholder="email@example.com" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Role Selection -->
                            <div>
                                <x-input-label for="role" :value="__('I am a')" class="block text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <div class="flex space-x-4">
                                        <label class="flex-1 relative bg-white border rounded-md shadow-sm p-4 flex cursor-pointer focus:outline-none border-gray-200" :class="{ 'border-indigo-500 ring-2 ring-indigo-500': selectedRole === 'pet_owner' }">
                                            <input type="radio" name="role" value="pet_owner" class="sr-only" id="role-pet-owner" {{ old('role', 'pet_owner') == 'pet_owner' ? 'checked' : '' }}>
                                            <div class="flex-1 flex">
                                                <div class="flex flex-col">
                                                    <span id="pet-owner-label" class="block text-sm font-medium text-gray-900">Pet Owner</span>
                                                    <span id="pet-owner-description" class="mt-1 flex items-center text-xs text-gray-500">Manage pets & book appointments</span>
                                                </div>
                                            </div>
                                            <div class="h-5 w-5 text-indigo-600 border-gray-300" aria-hidden="true">
                                                <svg class="h-5 w-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" x-show="selectedRole === 'pet_owner'">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </label>

                                        
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="password" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        type="password" name="password" required autocomplete="new-password"
                                        placeholder="••••••••" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-gray-700" />
                                <div class="mt-1">
                                    <x-text-input id="password_confirmation" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        type="password" name="password_confirmation" required autocomplete="new-password"
                                        placeholder="••••••••" />
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <!-- Terms & Privacy Policy -->
                            <div class="flex items-center">
                                <input id="terms" name="terms" type="checkbox" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="terms" class="ml-2 block text-sm text-gray-900">
                                    I agree to the <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Terms</a> and <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                </label>
                            </div>

                            <div>
                                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Create Account
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Sign in
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
                    <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('Group63.png') }}" alt="PetCare Logo" class="h-16">
                </div>
                    <!-- 3D Illustration -->
                    <img src="https://cdn.dribbble.com/users/1731254/screenshots/17395913/media/73971568c226253c0eb874518202408b.png" alt="Pet Care Illustration" class="max-w-md mx-auto">
                    
                    <!-- Testimonial/Feature Cards -->
                    <div class="mt-10 max-w-md mx-auto space-y-4">
                        <div class="bg-white rounded-lg shadow-lg p-5 transform hover:scale-105 transition-transform duration-300">
                            <div class="flex items-start">
                                <!-- Icon -->
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">Trusted by Pet Owners</h3>
                                    <p class="mt-1 text-sm text-gray-500">"Finding the right vet for my dog has never been easier. Highly recommended!"</p>
                                    <p class="mt-2 text-xs font-medium text-gray-700">— Sarah M., Pet Owner</p>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role radio button enhancement
            const petOwnerRadio = document.getElementById('role-pet-owner');
            const vetRadio = document.getElementById('role-vet');
            
            petOwnerRadio.addEventListener('change', function() {
                highlightSelectedRole();
            });
            
            vetRadio.addEventListener('change', function() {
                highlightSelectedRole();
            });
            
            function highlightSelectedRole() {
                const petOwnerLabel = petOwnerRadio.parentElement;
                const vetLabel = vetRadio.parentElement;
                
                if (petOwnerRadio.checked) {
                    petOwnerLabel.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
                    vetLabel.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
                } else {
                    vetLabel.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500');
                    petOwnerLabel.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500');
                }
            }
            
            // Initialize the selected state
            highlightSelectedRole();
        });
    </script>
</x-guest-layout>