<?php
session_start();

require_once '../../Models/animal.php';
require_once '../../Models/habitat.php';
require_once '../../Models/visiteGuid.php';
require_once '../../Models/reservations.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: ../../index.php');
    exit();
}

$nameVisite_guid = $_POST['nameVisite_guid'];
$filterPaysOrigin = $_POST['filterPaysOrigin'];
$filter_habitat = $_POST['filter_habitat'];

$animal = new Animal();
$animals = $animal->getAllAnimaux();
$animalFilter = $animal->getAnimauxRecherche($filterPaysOrigin, $filter_habitat);
$PayAnimal = $animal->getPaysOrigin();

$habitat = new Habitat();
$getNomHabitat = $habitat->selectNomHabitat();

$visiteGuid = new VisitesGuides();
$visiteGuides = $visiteGuid->getAllVisitesGuidesDis();
$visiteGuidRecherche = $visiteGuid->getVisitesGuidesRecherche($nameVisite_guid);
$visitGuidDejaParcour = $visiteGuid->getVisiteGuidDejaParcour($_SESSION['id_user']);

$reservation = new Reservations();
$reservations = $reservation->getAllReservationByIdUser($_SESSION['id_user']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visiteur | Animal Platform</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100">

    <button
        id="mobile-menu-btn"
        class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg hover:bg-green-700 transition"
        aria-label="Toggle navigation menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>


    <aside
        id="sidebar"
        class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg flex flex-col z-40
           transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <div class="p-6 border-b bg-white shadow-sm rounded-b-lg">
            <div class="flex justify-center items-center gap-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <img src="../../images/assad.png" alt="Logo"
                        class="w-20 h-20 object-contain rounded-full border-4 border-white shadow-md">
                </div>

                <!-- Title -->
                <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                    ASSAD
                </h1>
            </div>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <button type="button" onclick="openModalMesReserver()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Mes réservations
            </button>

            <button type="button" onclick="openModalAssadAtlass()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Asaad – Lion des Atlas
            </button>
            <button type="button"
                onclick="openModalGuidParcouru()"
                class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Visites guidées déjà parcourues
            </button>



        </nav>

        <div class="p-4 border-t border-gray-700">
            <a href="../../controllers/Logout.php"
                class="flex items-center gap-3 px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 transition">
                🚪 <span>Déconnexion</span>
            </a>
        </div>
    </aside>


    <main class="pt-24 lg:ml-64 p-4 lg:p-8">
        <div class="bg-white shadow-md rounded-lg p-6 mb-6 flex items-center gap-4">
            <!-- Avatar -->
            <div class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center text-xl font-bold">
                <?= strtoupper(substr($_SESSION['nom'], 0, 1)) . strtoupper(substr($_SESSION['prenom'], 0, 1)) ?>
            </div>

            <!-- Texte -->
            <div>
                <h1 class="text-xl font-semibold text-gray-800">
                    Bonjour, Mr
                    <span class="text-green-600">
                        <?= $_SESSION['nom'] ?> <?= $_SESSION['prenom'] ?>
                    </span>
                </h1>
                <p class="text-sm text-gray-500">
                    Bienvenue sur votre espace ASSAD
                </p>
            </div>
        </div>

        <div id="filter" class="flex flex-col lg:flex-row gap-6 mb-8">

            <!-- Filter Form -->
            <form action="home.php" method="POST"
                class="flex flex-col lg:flex-row gap-4 bg-white p-4 rounded-lg shadow-md w-full">

                <!-- Alimentaire -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sélectionner une Pays d’origine
                    </label>
                    <select name="filterPaysOrigin"
                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Tout</option>
                        <?php foreach ($PayAnimal as $pa) { ?>
                            <option value="<?= $pa->paysorigine ?>"><?= $pa->paysorigine ?></option>
                        <?php } ?>

                    </select>
                </div>

                <!-- Habitat -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Sélectionner un habitat
                    </label>
                    <select name="filter_habitat"
                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <option value="">Tout</option>
                        <?php foreach ($getNomHabitat as $nh) { ?>
                            <option value="<?= $nh->nomHabitat ?>"><?= $nh->nomHabitat ?></option>
                        <?php } ?>

                    </select>
                </div>

                <!-- Reset -->
                <div class="flex items-end">
                    <button type="submit"
                        class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Reset
                    </button>
                </div>
            </form>

            <!-- Search Visit -->
            <form action="home.php" method="POST" class="bg-white p-6 rounded-xl shadow-lg w-full lg:w-1/3">
                <h2 class="text-xl font-bold text-center mb-4">Rechercher une visite</h2>
                <input type="text"
                    name="nameVisite_guid"
                    placeholder="Nom de la visite..."
                    class="w-full px-4 py-2 border rounded-lg mb-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">
                    Rechercher
                </button>
            </form>
        </div>


        <section class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                <?php if (count($visiteGuidRecherche) > 0) {
                    foreach ($visiteGuidRecherche as $vd) { ?>
                    <div class="max-w-md rounded-2xl overflow-hidden shadow-lg bg-white hover:shadow-xl transition">

                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-green-300 p-4 text-white">
                            <h3 class="text-xl font-bold"><?= $vd->titre ?></h3>
                            <p class="text-sm opacity-90">Une expérience unique</p>
                        </div>

                        <!-- Body -->
                        <div class="p-5 space-y-2 text-gray-700">

                            <div class="flex justify-between">
                                <span>📅 Date</span>
                                <span class="font-semibold"><?= $vd->date_seulement ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span>⏰ Début</span>
                                <span class="font-semibold"><?= $vd->time_seulement ?></span>
                            </div>

                            <div class="flex justify-between">
                                <span>⏳ Durée</span>
                                <span class="font-semibold"><?= $vd->duree ?></span>
                            </div>

                            <div class="flex justify-between">
                                <span>🌍 Langue</span>
                                <span class="font-semibold"><?= $vd->langue ?></span>
                            </div>

                            <div class="flex justify-between">
                                <span>👥 Places restantes</span>
                                <span class="font-semibold text-green-600"><?= $vd->capacite_max ?></span>
                            </div>

                            <hr>

                            <!-- Prix -->
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-green-600"><?= $vd->prix ?></span>
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                    Disponible
                                </span>
                            </div>

                        </div>

                        <!-- Footer -->
                        <div class="flex gap-4 p-4">
                            <!-- Bouton Réserver -->
                            <button type="button"
                                onclick="openModalReserver(this)"
                                data-id="<?= $vd->id ?>"
                                class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 rounded-2xl shadow-md hover:from-white hover:to-white hover:text-green-600 hover:scale-105 transform transition-all duration-300">
                                Réserver maintenant
                            </button>

                            <!-- Bouton Voir Parcour -->
                            <button type="button"
                                onclick="openModalParcour(this)"
                                data-id="<?= $vd->id ?>"
                                class="flex-1 border-2 border-green-600 text-green-600 font-semibold py-3 rounded-2xl hover:bg-green-600 hover:text-white hover:scale-105 transform transition-all duration-300">
                                Voir Parcour
                            </button>
                        </div>

                    </div>

                <?php }
                } else { ?>
                    <?php foreach ($visiteGuides as $vd) { ?>
                        <div class="max-w-md rounded-2xl overflow-hidden shadow-lg bg-white hover:shadow-xl transition">

                        <!-- Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-green-300 p-4 text-white">
                        <h3 class="text-xl font-bold"><?= $vd->titre ?></h3>
                        <p class="text-sm opacity-90">Une expérience unique</p>
                        </div>

                        <!-- Body -->
                        <div class="p-5 space-y-2 text-gray-700">

                        <div class="flex justify-between">
                        <span>📅 Date</span>
                        <span class="font-semibold"><?= $vd->date_seulement ?></span>
                        </div>
                        <div class="flex justify-between">
                        <span>⏰ Début</span>
                        <span class="font-semibold"><?= $vd->time_seulement ?></span>
                        </div>

                        <div class="flex justify-between">
                        <span>⏳ Durée</span>
                        <span class="font-semibold"><?= $vd->duree ?></span>
                        </div>

                        <div class="flex justify-between">
                        <span>🌍 Langue</span>
                        <span class="font-semibold"><?= $vd->langue ?></span>
                        </div>

                        <div class="flex justify-between">
                            <span>👥 Places restantes</span>
                            <span class="font-semibold text-green-600"><?= $vd->capacite_max ?></span>
                        </div>

                        <hr>

                        <!-- Prix -->
                        <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-green-600"><?= $vd->prix ?></span>
                        <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">
                        Disponible
                        </span>
                        </div>

                        </div>

                        <!-- Footer -->
                        <div class="flex gap-4 p-4">
                        <!-- Bouton Réserver -->
                        <button type="button"
                        onclick="openModalReserver(this)"
                        data-id="<?= $vd->id ?>"
                        class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 rounded-2xl shadow-md hover:from-white hover:to-white hover:text-green-600 hover:scale-105 transform transition-all duration-300">
                        Réserver maintenant
                        </button>

                        <!-- Bouton Voir Parcour -->
                        <button type="button"
                        onclick="openModalParcour(this)"
                        data-id="<?= $vd->id ?>"
                        class="flex-1 border-2 border-green-600 text-green-600 font-semibold py-3 rounded-2xl hover:bg-green-600 hover:text-white hover:scale-105 transform transition-all duration-300">
                        Voir Parcour
                        </button>
                        </div>

                        </div>

                    <?php } ?>
                    <?php } ?>
            </div>


        </section>





        <section class="py-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
                🐾 Les Animaux
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <?php if (count($animalFilter) > 0) {
                    foreach ($animalFilter as $af) { ?>
                        <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">

                        <!-- Image -->
                        <div class="relative">
                            <img src="<?= $af->image ?>"
                                class="w-full h-52 object-cover group-hover:scale-110 transition duration-500">

                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>

                            <!-- Animal name on image -->
                            <h3 class="absolute bottom-3 left-3 text-white text-xl font-bold">
                                <?= $af->nomAnimal ?>
                            </h3>
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                    <?= $af->espèce ?>
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm">
                                <span class="font-semibold">Habitat :</span> <?= $af->nomHabitat ?>
                            </p>

                            <p class="text-gray-600 text-sm">
                                <span class="font-semibold">Pays d’origine :</span> <?= $af->paysorigine ?>
                            </p>
                        </div>
                    </div>
                    <?php } ?>

                
                <?php } else {
                    foreach ($animals as $a) { ?>
                    <div
                        class="group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2">

                        <!-- Image -->
                        <div class="relative">
                            <img src="<?= $a->image ?>"
                                class="w-full h-52 object-cover group-hover:scale-110 transition duration-500">

                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>

                            <!-- Animal name on image -->
                            <h3 class="absolute bottom-3 left-3 text-white text-xl font-bold">
                                <?= $a->nomAnimal ?>
                            </h3>
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                    <?= $a->espèce ?>
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm">
                                <span class="font-semibold">Habitat :</span> <?= $a->nomHabitat ?>
                            </p>

                            <p class="text-gray-600 text-sm">
                                <span class="font-semibold">Pays d’origine :</span> <?= $a->paysorigine ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
                <?php } ?>
            </div>
        </section>


    </main>

    <div id="reservationModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">


        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">


            <button onclick="closeModalReserver()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl">
                &times;
            </button>

            <h2 class="text-2xl font-bold mb-4 text-center">Réserver une visite</h2>

            <form method="post" action="../../controllers/reservation.php">
                <input id="id_visiteGuid" type="hidden" name="id_visiteGuid">
                <input type="hidden" name="id_user" value="<?= $_SESSION['id_user'] ?>">

                <div class="mb-4">
                    <label class="block mb-1 font-medium">Nombre de personnes</label>
                    <input type="number"
                        name="nbpersonnes"
                        min="1"
                        required
                        class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Confirmer
                </button>

            </form>
        </div>
    </div>

    <div id="mesReservation"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50">

        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative animate-fade-in">

            <!-- Close Button -->
            <button onclick="closeModalMesReserver()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">
                &times;
            </button>

            <!-- Header -->
            <div class="border-b px-6 py-4">
                <h2 class="text-2xl font-bold text-gray-800 text-center">
                    📋 Mes réservations
                </h2>
            </div>

            <!-- Content -->
            <div class="p-6 overflow-x-auto max-h-[70vh]">

                <table class="min-w-full text-sm border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Titre</th>
                            <th class="px-4 py-3 text-left font-semibold">Utilisateur</th>
                            <th class="px-4 py-3 text-center font-semibold">Personnes</th>
                            <th class="px-4 py-3 text-center font-semibold">Réservé le</th>
                            <th class="px-4 py-3 text-center font-semibold">Date visite</th>
                            <th class="px-4 py-3 text-center font-semibold">Heure</th>
                            <th class="px-4 py-3 text-center font-semibold">Statut</th>
                            <th class="px-4 py-3 text-center font-semibold">Durée</th>
                            <th class="px-4 py-3 text-center font-semibold">Total</th>
                            <th class="px-4 py-3 text-center font-semibold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php foreach ($reservations as $r) { ?>
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-3 font-medium">
                                    <?= htmlspecialchars($r->titre) ?>
                                </td>

                                <td class="px-4 py-3">
                                    <?= htmlspecialchars($r->nom . ' ' . $r->prenom) ?>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <?= $r->nbpersonnes ?>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <?= $r->datereservation ?>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <?= $r->dateVG ?>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <?= $r->timeVG ?>
                                </td>

                                <!-- Status Badge -->
                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    <?= $r->statut === 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' ?>">
                                        <?= ucfirst($r->statut) ?>
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <?= $r->duree ?>
                                </td>

                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    <?= $r->prix * $r->nbpersonnes ?> MAD
                                </td>

                                <!-- Action -->
                                <td class="px-4 py-3 text-center">
                                    <form action="../../controllers/annulerReservation.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                        <input type="hidden" name="id" value="<?= $r->id ?>">
                                        <input type="hidden" name="idvisite" value="<?= $r->idvisite ?>">
                                        <input type="hidden" name="nbrPersonne" value="<?= $r->nbpersonnes ?>">
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-semibold transition">
                                            ❌ Annuler
                                        </button>
                                    </form>
                                </td>

                            </tr>

                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div id="assadAtlass" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 hidden">

        <div class="absolute inset-0 bg-gray-900 bg-opacity-80 backdrop-blur-sm transition-opacity" onclick="closeModalAssadAtlass()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col md:flex-row transform transition-all scale-100">

            <button onclick="closeModalAssadAtlass()" class="absolute top-4 right-4 z-10 p-2 bg-white/80 hover:bg-white text-gray-800 rounded-full transition-colors shadow-sm backdrop-blur-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="w-full md:w-1/2 h-64 md:h-auto relative">
                <img src="https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?q=80&w=800&auto=format&fit=crop"
                    alt="Lion de l'Atlas"
                    class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent md:hidden"></div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center">

                <div class="flex items-center space-x-2 mb-3">
                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        Asaad
                    </span>
                    <span class="text-gray-400 text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                        </svg>
                        Afrique du Nord
                    </span>
                </div>

                <h2 class="text-3xl font-extrabold text-gray-900 mb-4 font-serif">
                    Lion de l'Atlas
                </h2>

                <p class="text-gray-600 mb-8 leading-relaxed text-justify text-sm md:text-base">
                    Emblème majestueux du Royaume, le Lion de l’Atlas est le trésor vivant des montagnes marocaines. Reconnaissable à sa crinière sombre et imposante unique au monde, ce prédateur légendaire incarne depuis des siècles la force, la noblesse et l'identité souveraine du Maroc.
                </p>

                <div class="grid grid-cols-2 gap-4">

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wide">Espèce</p>
                        <div class="flex items-center mt-1">
                            <span class="text-lg mr-2">🐾</span>
                            <span class="text-gray-800 font-semibold text-sm">Lion de l’Atlas</span>
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wide">Origine</p>
                        <div class="flex items-center mt-1">
                            <span class="text-lg mr-2">🌍</span>
                            <span class="text-gray-800 font-semibold text-sm">Afrique du Nord (maroc)</span>
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wide">Alimentation</p>
                        <div class="flex items-center mt-1">
                            <span class="text-lg mr-2">🥩</span>
                            <span class="text-gray-800 font-semibold text-sm">Carnivore</span>
                        </div>
                    </div>

                    <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wide">Habitat</p>
                        <div class="flex items-center mt-1">
                            <span class="text-lg mr-2">🏜️</span>
                            <span class="text-gray-800 font-semibold text-sm">Savanes</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div id="modalParcour" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl p-6 relative">
            <button onclick="closeModalParcour()"
                class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-3xl font-bold transition-transform hover:scale-110">
                &times;
            </button>


            <h2 class="text-3xl font-extrabold mb-6 text-center text-green-700">Étapes du Parcours</h2>


            <ul id="parcourList" class="space-y-4 max-h-96 overflow-y-auto px-2">

            </ul>
        </div>
    </div>

    <div id="modalGuidParcouru"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">

        <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
                <h2 class="text-xl font-bold text-gray-800">
                    🗺️ Visites guidées déjà parcourues
                </h2>
                <button onclick="closeModalGuidParcouru()"
                    class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">

                <!-- ONE VISITE CARD -->
                <?php foreach ($visitGuidDejaParcour as $v) { ?>
                    <div class="border rounded-xl p-5 shadow-sm hover:shadow-md transition">

                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <?= $v->titre ?>
                            </h3>
                            <span class="text-sm text-gray-500">
                                📅 <?= $v->dateheure ?>
                            </span>
                            
                        </div>
                        <!-- Comment form -->
                        <form action="../../controllers/addComment.php" method="POST" class="mt-4">
                            <input type="hidden" name="id_visite" value="<?= $v->visite_id ?>">
                            <input type="hidden" name="id_user" value="<?= $v->id_user ?>">
                            <div class="mb-4">
                            <label class="block mb-1 font-medium">Note (1-5)</label>
                            <input type="number"
                                name="note"
                                min="1"
                                required
                                class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
                            </div>

                            <textarea name="commentaire" rows="3"
                                class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:outline-none"
                                placeholder="Ajoutez votre commentaire sur cette visite..."></textarea>

                            <button type="submit"   
                                class="mt-3 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                                Ajouter commentaire
                            </button>
                        </form>
                    </div>
                <?php } ?>

            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t bg-gray-50 text-right">
                <button onclick="closeModalGuidParcouru()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                    Fermer
                </button>
            </div>
        </div>
    </div>

    

    <script>
        function openModalReserver(button) {

            document.getElementById("id_visiteGuid").value = button.dataset.id;


            document.getElementById("reservationModal").classList.remove("hidden");
            document.getElementById("reservationModal").classList.add("block");
        }

        function closeModalReserver() {
            document.getElementById("reservationModal").classList.remove("block");
            document.getElementById("reservationModal").classList.add("hidden");
        }

        function openModalMesReserver() {

            document.getElementById("mesReservation").classList.remove("hidden");
            document.getElementById("mesReservation").classList.add("block");
        }

        function closeModalMesReserver() {
            document.getElementById("mesReservation").classList.remove("block");
            document.getElementById("mesReservation").classList.add("hidden");
        }

        function openModalAssadAtlass() {

            document.getElementById("assadAtlass").classList.remove("hidden");
            document.getElementById("assadAtlass").classList.add("block");
        }

        function closeModalAssadAtlass() {
            document.getElementById("assadAtlass").classList.remove("block");
            document.getElementById("assadAtlass").classList.add("hidden");
        }

        function openModalParcour(button) {

            const visiteId = button.getAttribute('data-id');
            const modal = document.getElementById('modalParcour');
            const content = document.getElementById('parcourList');

            modal.classList.remove('hidden');
            content.innerHTML = "Chargement...";


            fetch(`get_visite_Parcour.php?id=${visiteId}`)
                .then(response => response.text())
                .then(data => {
                    content.innerHTML = data;
                })
                .catch(error => {
                    content.innerHTML = "Erreur lors du chargement.";
                    console.error('Error:', error);
                });
        }

        function closeModalParcour() {
            document.getElementById('modalParcour').classList.add('hidden');
        }

        function openModalGuidParcouru() {
            document.getElementById('modalGuidParcouru').classList.remove('hidden');
        }

        function closeModalGuidParcouru() {
            document.getElementById('modalGuidParcouru').classList.add('hidden');
        }

        setTimeout(() => {
            const alert = document.querySelector('#msg');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
        setTimeout(() => {
            const alert = document.querySelector('#msgCommentaire');
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s';
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>
</body>

</html>
