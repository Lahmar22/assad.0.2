<?php
session_start();
require_once '../../Models/animal.php';
require_once '../../Models/visiteGuid.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../index.php");
    exit();
}

$animal = new Animal();
$animals = $animal->getAllAnimaux();

$visiteGuid = new VisitesGuides();
$visiteGuides = $visiteGuid->getAllVisitesGuides();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guid | Animal Management Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <button type="button" onclick="openModalVisiteGuid()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Créer Visite Guidée
            </button>
            <button type="button" onclick="openModalMesReserver()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Liste Reservations
            </button>

            <button type="button" onclick="openParcourModal()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Créer visite guidée (parcours)
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
                <?= strtoupper(substr($_SESSION['nom'], 0, 1)) . strtoupper(substr($_SESSION['prenom'], 0, 1))  ?>
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

        </div>


        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Les Visites Guidées</h2>

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Id</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Titre</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date Heure</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Langue</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Capacite</th>

                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Durée</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Prix</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Statut</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach($visiteGuides as $vd) { ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->id ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->titre ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->dateheure ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->langue?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->capacite_max ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->duree ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $vd->prix ?> MAD</td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <form action="../controller/update_statusVisiteGuid.php" method="POST">
                                        <input type="hidden" name="id_visiteGuid" value="<?= $vd->id ?>">

                                        <select name="statut"
                                            onchange="this.form.submit()"
                                            class="px-3 py-1 rounded-md text-sm font-medium <?= $vd->statut === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">

                                            <option value="Active" <?= $vd->statut === 'Active' ? 'selected' : '' ?>>
                                                Activer
                                            </option>
                                            <option value="Inactive" <?= $vd->statut === 'Inactive' ? 'selected' : '' ?>>
                                                Désactiver
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="../controller/deleteVisiteGuid.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet visite guidee ?');">
                                        <input type="hidden" name="id" value="<?= $vd->id ?>">
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </section>


        <section class="py-10">
            <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">
                🐾 Les Animaux
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
                <?php foreach ($animals as $a) { ?>
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
            </div>
        </section>

    </main>
    <div id="addVisiteGuid" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                Créer Visite Guidée
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <button type="button" onclick="closeModalVisiteGuid()" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="addAnimal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="../controller/creatVisiteGuid.php" method="POST" class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow">

                    <!-- Titre -->
                    <div class="mb-4">
                        <label for="titre" class="block font-semibold mb-1">Titre</label>
                        <input type="text" id="titre" name="titre" required
                            class="w-full px-3 py-2 border rounded">
                    </div>

                    <!-- Date et heure -->
                    <div class="mb-4">
                        <label for="dateheure" class="block font-semibold mb-1">Date & Heure</label>
                        <input type="datetime-local" id="dateheure" name="dateheure" required
                            class="w-full px-3 py-2 border rounded">
                    </div>

                    <!-- Langue -->
                    <div class="mb-4">
                        <label for="langue" class="block font-semibold mb-1">Langue</label>
                        <select id="langue" name="langue" required
                            class="w-full px-3 py-2 border rounded">
                            <option value="">-- Sélectionner --</option>
                            <option value="Français">Français</option>
                            <option value="Anglais">Anglais</option>
                            <option value="Arabe">Arabe</option>
                            <option value="Espagnol">Espagnol</option>
                        </select>
                    </div>

                    <!-- Capacité max -->
                    <div class="mb-4">
                        <label for="capacite_max" class="block font-semibold mb-1">Capacité maximale</label>
                        <input type="number" id="capacite_max" name="capacite_max" min="1" required
                            class="w-full px-3 py-2 border rounded">
                    </div>

                    <!-- Durée -->
                    <div class="mb-4">
                        <label for="duree" class="block font-semibold mb-1">Durée (minutes)</label>
                        <input type="number" id="duree" name="duree" min="1" required
                            class="w-full px-3 py-2 border rounded">
                    </div>

                    <!-- Prix -->
                    <div class="mb-4">
                        <label for="prix" class="block font-semibold mb-1">Prix (MAD)</label>
                        <input type="number" step="0.01" id="prix" name="prix" required
                            class="w-full px-3 py-2 border rounded">
                    </div>

                    <!-- Bouton -->
                    <div class="flex gap-3">
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                            Créer la visite guidée
                        </button>
                        <button data-modal-hide="addAnimal" type="button" onclick="closeModalVisiteGuid ()" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>

                    </div>

                </form>


            </div>
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
                    📋 List Réservations
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
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php if ($resultMesReservation->num_rows > 0) {
                            while ($row = $resultMesReservation->fetch_assoc()) { ?>
                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-4 py-3 font-medium">
                                        <?= htmlspecialchars($row["titre"]) ?>
                                    </td>

                                    <td class="px-4 py-3">
                                        <?= htmlspecialchars($row["nom"] . ' ' . $row["prenom"]) ?>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <?= $row["nbpersonnes"] ?>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <?= $row["datereservation"] ?>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <?= $row["dateVG"] ?>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <?= $row["timeVG"] ?>
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    <?= $row["statut"] === 'active'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' ?>">
                                            <?= ucfirst($row["statut"]) ?>
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <?= $row["duree"] ?>
                                    </td>

                                    <td class="px-4 py-3 text-center font-semibold text-green-600">
                                        <?= $row["prix"] * $row["nbpersonnes"] ?> MAD
                                    </td>



                                </tr>
                            <?php }
                        } else { ?>
                            <td colspan="10" class=" text-xl px-4 py-3 text-center">🚫 Aucune réservation trouvée</td>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- MODAL BACKDROP -->
    <div id="modalParcourVisite"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <!-- MODAL BOX -->
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 relative">

            <!-- CLOSE BUTTON -->
            <button onclick="closeParcourModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl">
                &times;
            </button>

            <!-- TITLE -->
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Create Guided Visit Route
            </h2>

            <!-- FORM -->
            <form action="../controller/createParcourVisite.php" method="post" class="space-y-4">

                <!-- TITRE ETAPE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Étape Title
                    </label>
                    <input type="text" name="titreetape" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- DESCRIPTION ETAPE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Step Description
                    </label>
                    <textarea name="descriptionetape" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                </div>

                <!-- ORDRE ETAPE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Step Order
                    </label>
                    <input type="number" name="ordreetape" min="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                           focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>

                <!-- ID VISITE -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Select Visit
                    </label>

                    <select name="id_visite" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
               focus:outline-none focus:ring-2 focus:ring-green-500">

                        <option value="">-- Choose a visit --</option>

                        <?php while ($visite = $visites->fetch_assoc()) { ?>
                            <option value="<?= $visite['id'] ?>">
                                <?= $visite['titre'] ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeParcourModal()"
                        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                        Cancel
                    </button>

                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-green-600 hover:bg-green-700
                           text-white font-semibold">
                        Create
                    </button>
                </div>

            </form>
        </div>
    </div>


    <script>
        function openModalVisiteGuid() {
            document.getElementById("addVisiteGuid").classList.remove("hidden");
            document.getElementById("addVisiteGuid").classList.add("block");


        }

        function closeModalVisiteGuid() {
            document.getElementById("addVisiteGuid").classList.remove("block");
            document.getElementById("addVisiteGuid").classList.add("hidden");


        }

        function openModalMesReserver() {

            document.getElementById("mesReservation").classList.remove("hidden");
            document.getElementById("mesReservation").classList.add("block");
        }

        function closeModalMesReserver() {
            document.getElementById("mesReservation").classList.remove("block");
            document.getElementById("mesReservation").classList.add("hidden");
        }

        function openParcourModal() {
            document.getElementById("modalParcourVisite").classList.remove("hidden");
        }

        function closeParcourModal() {
            document.getElementById("modalParcourVisite").classList.add("hidden");
        }
    </script>
</body>

</html>