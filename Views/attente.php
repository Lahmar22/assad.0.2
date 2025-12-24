<?php 
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte désactivé</title>

    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md text-center">
        
        <!-- Icône -->
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            Compte désactivé
        </h1>

        <p class="text-gray-600 mb-4">
            Votre compte est actuellement <span class="font-semibold text-red-500">désactivé</span>.
        </p>

        <p class="text-gray-600 mb-6">
            Veuillez patienter jusqu’à l’activation de votre compte par un administrateur.
            Vous pourrez accéder à la plateforme une fois votre compte activé.
        </p>

        <div class="flex justify-center gap-4">
            <a href="../index.php"
               class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">
                Déconnexion
            </a>

            
        </div>

    </div>

</body>
</html>
