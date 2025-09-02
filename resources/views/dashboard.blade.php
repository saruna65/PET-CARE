<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900">Image Recognition</h3>
                        <div class="mt-3">
                            <input type="file" id="imageUpload" accept="image/*" class="mb-4">
                            <button type="button" id="predictButton"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md disabled:bg-blue-300" disabled>
                                Analyze Image
                            </button>

                            <div class="mt-4">
                                <div id="imagePreview" class="mt-2" style="max-width: 300px; max-height: 300px;">
                                </div>
                                <div id="label-container" class="mt-4"></div>
                                <div id="loading" class="hidden mt-4">Analyzing image...</div>

                                <!-- Recommendations Section -->
                                <div id="recommendations-container" class="mt-6 hidden">
                                    <h4 class="text-lg font-medium text-gray-800">Recommendations</h4>
                                    <div id="recommendation-content" class="mt-2 p-4 border rounded-lg bg-blue-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@teachablemachine/image@latest/dist/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
        // The link to your model provided by Teachable Machine export panel
        const URL = "https://teachablemachine.withgoogle.com/models/9nk8R6Zfk/";
        let model, maxPredictions;
        let imageDisplay = null;
        let modelLoaded = false;
        const imageUpload = document.getElementById('imageUpload');
        const predictButton = document.getElementById('predictButton');
        const imagePreview = document.getElementById('imagePreview');
        const labelContainer = document.getElementById('label-container');
        const loadingIndicator = document.getElementById('loading');
        const recommendationsContainer = document.getElementById('recommendations-container');
        const recommendationContent = document.getElementById('recommendation-content');

        // Recommendation database
        const recommendations = {
            "Hypersensivity Allergic dermatosis": `
                <div class="text-red-800 font-medium mb-2">Hypersensitivity/Allergic Dermatosis Detected</div>
                <p class="mb-2">Your pet appears to have signs of allergic dermatosis. Here are some recommendations:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Schedule a veterinary visit as soon as possible to confirm diagnosis</li>
                    <li>Try to identify and remove potential allergens from your pet's environment</li>
                    <li>Consider hypoallergenic pet food recommended by your veterinarian</li>
                    <li>Avoid using harsh chemical cleaners around your home</li>
                    <li>Regular bathing with vet-recommended medicated shampoo may help</li>
                    <li>Do not use human medications without veterinary guidance</li>
                </ul>
            `,
            "Fungal Infections": `
                <div class="text-red-800 font-medium mb-2">Fungal Infection Detected</div>
                <p class="mb-2">Your pet appears to have signs of a fungal infection. Here are some recommendations:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Visit your veterinarian for proper diagnosis and treatment</li>
                    <li>Keep the affected areas clean and dry</li>
                    <li>Your vet may prescribe antifungal medications, shampoos or creams</li>
                    <li>Follow the complete treatment course, even if symptoms improve</li>
                    <li>Disinfect bedding, brushes and other items your pet frequently uses</li>
                    <li>Some fungal infections can spread to humans, so practice good hygiene</li>
                    <li>Consider isolating your pet from other animals until the infection clears</li>
                </ul>
            `,
            "Bacterial dermatosis": `
                <div class="text-red-800 font-medium mb-2">Bacterial Dermatosis Detected</div>
                <p class="mb-2">Your pet appears to have signs of bacterial skin infection. Here are some recommendations:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Consult with your veterinarian for proper diagnosis and treatment</li>
                    <li>Antibiotics are typically needed and must be prescribed by a professional</li>
                    <li>Keep the affected area clean using a gentle antiseptic solution recommended by your vet</li>
                    <li>Prevent your pet from scratching, licking, or biting the affected areas</li>
                    <li>Complete the full course of antibiotics even if symptoms improve</li>
                    <li>Check for underlying causes like allergies or parasites</li>
                    <li>Regular bathing with medicated shampoos may be recommended</li>
                </ul>
            `,
            "Healthy": `
                <div class="text-green-800 font-medium mb-2">No Issues Detected - Healthy Skin</div>
                <p class="mb-2">Great news! Your pet's skin appears healthy. Here are some tips to maintain skin health:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Continue regular grooming and bathing with pet-appropriate products</li>
                    <li>Maintain a balanced diet with proper nutrition</li>
                    <li>Schedule regular check-ups with your veterinarian</li>
                    <li>Use parasite prevention as recommended by your vet</li>
                    <li>Monitor for any changes in skin appearance or behavior</li>
                    <li>Provide fresh water and a clean living environment</li>
                </ul>
            `
        };

        // Initialize the model
        async function init() {
            // Load model
            loadingIndicator.classList.remove('hidden');
            loadingIndicator.textContent = 'Loading model...';
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";

            try {
                model = await tmImage.load(modelURL, metadataURL);
                maxPredictions = model.getTotalClasses();

                // Clear and create label elements properly
                labelContainer.innerHTML = '';
                for (let i = 0; i < maxPredictions; i++) {
                    const element = document.createElement("div");
                    element.className = "prediction-item"; // Add a class for styling
                    labelContainer.appendChild(element);
                }

                // Set model loaded flag
                modelLoaded = true;
                console.log("Model loaded successfully");

                // Enable predict button if image is already uploaded
                if (imageDisplay) {
                    predictButton.disabled = false;
                }

                loadingIndicator.classList.add('hidden');
            } catch (error) {
                console.error('Error loading model:', error);
                loadingIndicator.textContent = 'Error loading model. Please try again later.';
                loadingIndicator.classList.add('text-red-500');
            }
        }

        // Predict function for uploaded image
        async function predict() {
            if (!model || !imageDisplay) {
                console.error("Model or image not ready");
                return;
            }

            loadingIndicator.textContent = "Analyzing image...";
            loadingIndicator.classList.remove('hidden');
            predictButton.disabled = true;

            // Hide recommendations while processing
            recommendationsContainer.classList.add('hidden');

            try {
                // Run prediction on the displayed image
                const predictions = await model.predict(imageDisplay);

                // Make sure the label container has the correct number of children
                if (labelContainer.children.length !== maxPredictions) {
                    labelContainer.innerHTML = '';
                    for (let i = 0; i < maxPredictions; i++) {
                        const element = document.createElement("div");
                        element.className = "prediction-item";
                        labelContainer.appendChild(element);
                    }
                }

                // Find the highest probability prediction
                let highestProb = 0;
                let highestProbClass = "";

                // Display results - use children instead of childNodes
                for (let i = 0; i < maxPredictions; i++) {
                    const classPrediction =
                        predictions[i].className + ": " +
                        (predictions[i].probability * 100).toFixed(2) + "%";

                    // Use children instead of childNodes to avoid text nodes
                    labelContainer.children[i].innerHTML = classPrediction;

                    // Add styling based on probability
                    const prob = predictions[i].probability;
                    labelContainer.children[i].className =
                        "prediction-item py-1 px-2 my-1 rounded " +
                        (prob > 0.7 ? "bg-green-100" :
                            prob > 0.3 ? "bg-yellow-100" : "bg-gray-100");

                    // Track highest probability for recommendations
                    if (prob > highestProb) {
                        highestProb = prob;
                        highestProbClass = predictions[i].className;
                    }
                }

                // Show recommendations based on highest probability class
                if (highestProb > 0.5) { // Only show recommendations if we're reasonably confident
                    recommendationContent.innerHTML = recommendations[highestProbClass] ||
                        '<p>No specific recommendations available. Please consult your veterinarian.</p>';
                    recommendationsContainer.classList.remove('hidden');
                }

                console.log("Prediction completed successfully");
            } catch (error) {
                console.error('Prediction error:', error);
                labelContainer.innerHTML = '<div class="text-red-500">Error analyzing image: ' + error.message +
                    '</div>';
            } finally {
                loadingIndicator.classList.add('hidden');
                predictButton.disabled = false;
            }
        }

        // Handle file selection
        imageUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Clear previous results
            labelContainer.innerHTML = '';
            recommendationsContainer.classList.add('hidden');

            const reader = new FileReader();
            reader.onload = function(event) {
                // Create and display the image
                imagePreview.innerHTML = '';
                imageDisplay = document.createElement('img');
                imageDisplay.src = event.target.result;
                imageDisplay.style.maxWidth = '100%';
                imageDisplay.style.maxHeight = '300px';

                // Make sure image is fully loaded before using it for prediction
                imageDisplay.onload = function() {
                    console.log("Image fully loaded");
                };

                imagePreview.appendChild(imageDisplay);

                // Only enable the predict button if the model is loaded
                if (modelLoaded) {
                    console.log("Image loaded and model is ready");
                    predictButton.disabled = false;
                } else {
                    console.log("Image loaded but waiting for model");
                    loadingIndicator.textContent = "Image loaded. Waiting for model to complete loading...";
                    loadingIndicator.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(file);
        });

        // Add event listener to predict button
        predictButton.addEventListener('click', predict);

        // Start model initialization immediately
        init();
    </script>

</x-app-layout>
