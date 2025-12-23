<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSAD | Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            transition: opacity 0.25s ease;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center font-sans">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-10 w-full max-w-md relative">

            <!-- Logo -->
            <div class="flex justify-center -mt-16 mb-6">
                <img src="images/assad.png" alt="Logo" class="w-32 h-32 object-contain rounded-full border-4 border-white shadow-lg">
            </div>

            <!-- Title -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800">Welcome to ASSAD</h1>
                <p class="text-gray-500 mt-2">Sign in to your account</p>
            </div>

            <!-- Form -->
            <form action="controller/login.php" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" placeholder="you@example.com"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent shadow-sm transition" required>
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent shadow-sm transition" required>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-opacity-50 transition duration-200">
                    Sign In
                </button>
            </form>

            <!-- Signup link -->
            <p class="text-center text-gray-500 text-sm mt-6">
                Don't have an account?
                <button onclick="toggleModal('signup-modal')" class="text-indigo-600 font-semibold hover:underline">
                    Sign up
                </button>
            </p>


        </div>
    </div>



    <div id="signup-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <!-- Background overlay -->
            <div onclick="toggleModal('signup-modal')" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Centering trick -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-2xl shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative">

                <!-- Close button -->
                <div class="absolute top-4 right-4">
                    <button type="button" onclick="toggleModal('signup-modal')" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex justify-center -mt-16 mb-6">
                    <img src="images/assad.png" alt="Logo" class="w-32 h-32 object-contain rounded-full border-4 border-white shadow-lg">
                </div>

                <!-- Modal content -->
                <div class="px-6 pb-6">
                    <h3 class="text-center text-2xl font-semibold text-gray-900 mb-4" id="modal-title">
                        Create an Account
                    </h3>

                    <form action="controller/inscription.php" method="POST" class="space-y-4">
                        <div>
                            <label for="nom" class="block text-gray-700 font-medium mb-1">Nom</label>
                            <input type="text" name="nom" placeholder="Doe" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm transition">
                        </div>

                        <div>
                            <label for="prenom" class="block text-gray-700 font-medium mb-1">Prenom</label>
                            <input type="text" name="prenom" placeholder="John" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm transition">
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" name="email" placeholder="john@example.com" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm transition">
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                            <input type="password" name="password" placeholder="••••••••" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm transition">
                        </div>

                        <div>
                            <label for="role" class="block text-gray-700 font-medium mb-1">Role</label>
                            <select name="role" id="role" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 shadow-sm transition">
                                <option value="">Select Role</option>
                                <option value="visiteur">Visiteur</option>
                                <option value="guid">Guid</option>
                            </select>
                        </div>

                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById(modalID + "-backdrop").classList.toggle("flex");
        }
    </script>
</body>

</html>