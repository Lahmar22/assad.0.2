<?php

session_start();

if (!isset($_SESSION['id_admin'])) {
    header('Location: ../../index.php');
    exit();
}

require_once '../../Models/animal.php';
require_once '../../Models/admin.php';
require_once '../../Models/habitat.php';
require_once '../../Models/reservations.php';

$admin = new Admin();
$users = $admin->getAllUser();

$statistic = $admin->statisticUser();

foreach ($statistic as $row) {
    $roles[$row->role] = $row->total;
}

$guid = $roles['guid'];
$visiteur = $roles['visiteur'];

if (isset($_POST['filterPaysOrigin'], $_POST['filter_habitat'])) {
    $filterPaysOrigin = $_POST['filterPaysOrigin'];
    $filter_habitat = $_POST['filter_habitat'];
}

$animal = new Animal();
$animals = $animal->getAllAnimaux();

$habitat = new Habitat();
$habitats = $habitat->getAllHabitat();
$getNomHabitat = $habitat->selectNomHabitat();

$PayAnimal = $animal->getPaysOrigin();
$animalFilter = $animal->getAnimauxRecherche($filterPaysOrigin, $filter_habitat);

$reservation = new Reservations();
$reservations = $reservation->getAllReservation();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Management Platform</title>
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
            <button type="button" onclick="openModalAnimal()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Ajouter Animal
            </button>
            <button type="button" onclick="openModalHabitat()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Ajout Habitat
            </button>
            <button type="button" onclick="openModalMesReserver()" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition text-center">
                Liste Reservations
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

        </div>


        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Les Utilisateurs</h2>

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Id</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Prenom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($users as $u) { ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $u->id_user ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $u->nom ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $u->prenom ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $u->email ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium 
                                <?= $u->role === 'guid' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' ?>">
                                        <?= $u->role ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-700">
                                    <form action="../../controllers/updateStatut.php" method="POST">
                                        <input type="hidden" name="id_user" value="<?= $u->id_user ?>">

                                        <select name="statuse"
                                            onchange="this.form.submit()"
                                            class="px-3 py-1 rounded-md text-sm font-medium <?= $u->statuse === 'Activer' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">

                                            <option value="Activer" <?= $u->statuse === 'Activer' ? 'selected' : '' ?>>
                                                Activer
                                            </option>
                                            <option value="Désactiver" <?= $u->statuse === 'Désactiver' ? 'selected' : '' ?>>
                                                Désactiver
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="../../controllers/removeUser.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                        <input type="hidden" name="id" value="<?= $u->id_user ?>">
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
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Les Habitats</h2>

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Id</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Type Climat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Zone zoo</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($habitats as $h) { ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $h->id_habitat ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $h->nomHabitat ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $h->typeclimat ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $h->description ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $h->zonezoo ?></td>


                                <td class="flex gap-3 px-6 py-4 text-center">
                                    <form action="../../controllers/removeHabitat.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet habitat ?');">
                                        <input type="hidden" name="id" value="<?= $h->id_habitat ?>">
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                            Supprimer
                                        </button>
                                    </form>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition"
                                        type="button"
                                        onclick="openModalhabitatModify(this)"
                                        data-id-habitat="<?= $h->id_habitat ?>"
                                        data-nom-habitat="<?= $h->nomHabitat ?>"
                                        data-type-climat="<?= $h->typeclimat ?>"
                                        data-description="<?= $h->description ?>"
                                        data-zonezoo="<?= $h->zonezoo ?>">
                                        Modifier
                                    </button>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </section>
        <section class="mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Les Animaux</h2>

            <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Id</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Espèce</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Alimentation</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Pays Origine</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description Courte</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Habitat</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">

                        <?php if (count($animalFilter) > 0) {
                            foreach ($animalFilter as $af) { ?>
                                <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->id ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->nomAnimal ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->espèce ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->alimentation ?></td>
                                <td class="px-6 py-4 w-25">
                                    <img src="<?= $af->image ?>"
                                        alt="<?= $af->nomAnimal ?>"
                                        class="w-16 h-16 rounded-full object-cover border border-gray-300 shadow-sm">
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->paysorigine ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->descriptioncourte ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $af->nomHabitat ?></td>

                                <td class="flex gap-3 px-6 py-4 text-center">
                                    <form action="../../controllers/removeAnimal.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet Animal ?');">
                                        <input type="hidden" name="id" value="<?= $af->id ?>">
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                            Supprimer
                                        </button>
                                    </form>

                                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition"
                                        type="button"
                                        onclick="openModalAnimalModify(this)"
                                        data-id="<?= $af->id ?>"
                                        data-nom-animal="<?= $af->nomAnimal ?>"
                                        data-espece="<?= $af->espèce ?>"
                                        data-alimentation="<?= $af->alimentation ?>"
                                        data-image="<?= $af->image ?>"
                                        data-paysorigine="<?= $af->paysorigine ?>"
                                        data-descriptioncourte="<?= $af->descriptioncourte ?>"
                                        data-id-habitat="<?= $af->nomHabitat ?>">
                                        Modifier
                                    </button>

                                </td>
                            </tr>
                            <?php } ?>
                        <?php } else {
                            foreach ($animals as $a) { ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->id ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->nomAnimal ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->espèce ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->alimentation ?></td>
                                <td class="px-6 py-4 w-25">
                                    <img src="<?= $a->image ?>"
                                        alt="<?= $a->nomAnimal ?>"
                                        class="w-16 h-16 rounded-full object-cover border border-gray-300 shadow-sm">
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->paysorigine ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->descriptioncourte ?></td>
                                <td class="px-6 py-4 text-sm text-gray-700"><?= $a->nomHabitat ?></td>

                                <td class="flex gap-3 px-6 py-4 text-center">
                                    <form action="../../controllers/removeAnimal.php" method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cet Animal ?');">
                                        <input type="hidden" name="id" value="<?= $a->id ?>">
                                        <button
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                                            Supprimer
                                        </button>
                                    </form>

                                    <button class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg transition"
                                        type="button"
                                        onclick="openModalAnimalModify(this)"
                                        data-id="<?= $a->id ?>"
                                        data-nom-animal="<?= $a->nomAnimal ?>"
                                        data-espece="<?= $a->espèce ?>"
                                        data-alimentation="<?= $a->alimentation ?>"
                                        data-image="<?= $a->image ?>"
                                        data-paysorigine="<?= $a->paysorigine ?>"
                                        data-descriptioncourte="<?= $a->descriptioncourte ?>"
                                        data-id-habitat="<?= $a->nomHabitat ?>">
                                        Modifier
                                    </button>

                                </td>
                            </tr>
                        <?php } ?>
                        <?php } ?>


                    </tbody>
                </table>
            </div>

        </section>

        <section class="mb-8 mt-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">
                <svg class="w-6 h-6 inline-block mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Statistics
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Carnivore Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition border-t-4 border-red-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Visiteur</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">
                                <?php echo $visiteur ?? 0; ?>
                            </h4>
                        </div>

                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Percentage</span>
                            <span class="font-semibold text-red-600">
                                <?php echo number_format(($visiteur / ($visiteur + $guid)) * 100, 2, ',', ' ') ?? 0; ?>%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-500 h-2 rounded-full transition-all duration-500"
                                style="width: <?php echo ($visiteur / ($visiteur + $guid)) * 100 ?? 0; ?>%">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Herbivore Card -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition border-t-4 border-green-500">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Guid</p>
                            <h4 class="text-3xl font-bold text-gray-800 mt-1">
                                <?php echo $guid ?? 0; ?>
                            </h4>
                        </div>

                    </div>
                    <div class="mt-4">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600">Percentage</span>
                            <span class="font-semibold text-green-600">
                                <?php echo number_format(($guid / ($visiteur + $guid)) * 100, 2, ',', ' ') ?? 0; ?>%
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full transition-all duration-500"
                                style="width: <?php echo ($guid / ($visiteur + $guid)) * 100 ?? 0; ?>%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition border-t-4 border-green-500">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-4">

                            <div>
                                <p class="text-sm opacity-90 font-medium">Total</p>
                                <p class="text-3xl font-bold">
                                    <?= $guid + $visiteur ?? 0; ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-6 text-sm">
                            <div class="text-center">
                                <p class="opacity-90">Visiteur</p>
                                <p class="text-xl font-bold"><?php echo $visiteur ?? 0; ?></p>
                            </div>
                            <div class="text-center">
                                <p class="opacity-90">Guid</p>
                                <p class="text-xl font-bold"><?php echo $guid ?? 0; ?></p>
                            </div>

                        </div>
                    </div>
                </div>



            </div>

        </section>



    </main>

  

    <div id="addAnimal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <button type="button" onclick="closeModalAnimal()" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="addAnimal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="../../controllers/ajouterAnimal.php" method="POST">
                    <div class="space-y-4">
                        <div class="col-span-2">
                            <label for="nom" class="block mb-2.5 text-sm font-medium text-heading">Nom</label>
                            <input type="text" name="nom" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="espece" class="block mb-2.5 text-sm font-medium text-heading">Espèce</label>
                            <input type="text" name="espece" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="alimentation" class="block mb-2.5 text-sm font-medium text-heading">Alimentation</label>
                            <input type="text" name="alimentation" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="image" class="block mb-2.5 text-sm font-medium text-heading">Image</label>
                            <input
                                type="text"
                                name="image"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="paysorigine" class="block mb-2.5 text-sm font-medium text-heading">Pays Origine</label>
                            <input type="text" name="paysorigine" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="descriptioncourte" class="block mb-2.5 text-sm font-medium text-heading">Description Courte</label>
                            <input type="text" name="descriptioncourte" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>

                        <div>
                            <label for="habitat" class="block text-sm font-medium text-gray-700 mb-2">Habitat</label>
                            <select
                                name="habitat"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Select a habitat</option>
                                <option value="1">ddkljdklejdkl</option>
                               
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                        <button type="submit" class="inline-flex items-center  text-white bg-green-600  box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                            Ajout Animal
                        </button>
                        <button data-modal-hide="addAnimal" type="button" onclick="closeModalAnimal()" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="updateAnimal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                <h1>Modifier Animal</h1>
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <button type="button" onclick="closeModalAnimalModify()" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="addAnimal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="../../controllers/updateAnimal.php" method="POST">
                    <div class="space-y-4">
                        <input id="idAnimal" type="hidden" name="id">
                        <div class="col-span-2">
                            <label for="nom" class="block mb-2.5 text-sm font-medium text-heading">Nom</label>
                            <input id="nomAnimal" type="text" name="nom" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="espece" class="block mb-2.5 text-sm font-medium text-heading">Espèce</label>
                            <input id="espaceAnimal" type="text" name="espece" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="alimentation" class="block mb-2.5 text-sm font-medium text-heading">Alimentation</label>
                            <input id="AlimentationAnimal" type="text" name="alimentation" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="image" class="block mb-2.5 text-sm font-medium text-heading">Image</label>
                            <input
                                id="imageAnimal"
                                type="text"
                                name="image"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="paysorigine" class="block mb-2.5 text-sm font-medium text-heading">Pays Origine</label>
                            <input id="paysorigineAnimal" type="text" name="paysorigine" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="descriptioncourte" class="block mb-2.5 text-sm font-medium text-heading">Description Courte</label>
                            <input id="descriptioncourteAnimal" type="text" name="descriptioncourte" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>

                        <div>
                            <label for="habitat" class="block text-sm font-medium text-gray-700 mb-2">Habitat</label>
                            <select
                                name="habitat"
                                id="habitatAnimal"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Select a habitat</option>
                                <option value="1">jkhkdjhdjkh</option>


                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                        <button type="submit" class="inline-flex items-center  text-white bg-green-600  box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">

                            Modifier Animal
                        </button>
                        <button data-modal-hide="addAnimal" type="button" onclick="closeModalAnimalModify()" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="addHabitat" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <button type="button" onclick="closeModalHabitat()" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="addAnimal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="../../controllers/addHabitat.php" method="POST">
                    <div class="space-y-4">
                        <div class="col-span-2">
                            <label for="nomhabitat" class="block mb-2.5 text-sm font-medium text-heading">Nom Habitat</label>
                            <input type="text" name="nomhabitat" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div>
                            <label for="typeclimat" class="block text-sm font-medium text-gray-700 mb-2">Type Climat</label>
                            <input type="text" name="typeclimat" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">

                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea id="product-description" name="description" rows="3"
                                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                placeholder="Entrez la description ici..." required></textarea>
                        </div>
                        <div>
                            <label for="zonezoo" class="block text-sm font-medium text-gray-700 mb-2">zone zoo</label>
                            <input type="text" name="zonezoo" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">

                        </div>
                    </div>
                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                        <button type="submit" class="inline-flex items-center  text-white bg-green-600  box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            <svg class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                            Ajout Habitat
                        </button>
                        <button data-modal-hide="addAnimal" type="button" onclick="closeModalHabitat()" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modifierHabitat" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white border border-default rounded-base shadow-sm p-4 md:p-6">
                <div class="flex items-center justify-between border-b border-default pb-4 md:pb-5">
                    <button type="button" onclick="closeModalModifierHabitat()" class="text-body bg-transparent hover:bg-neutral-tertiary hover:text-heading rounded-base text-sm w-9 h-9 ms-auto inline-flex justify-center items-center" data-modal-hide="addAnimal">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="../../controllers/updateHabitat.php" method="POST">
                    <input id="idhabitat" name="id" type="hidden">
                    <div class="space-y-4">
                        <div class="col-span-2">
                            <label for="nomhabitat" class="block mb-2.5 text-sm font-medium text-heading">Nom Habitat</label>
                            <input id="nomHabitat" type="text" name="nomhabitat" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">
                        </div>
                        <div>
                            <label for="typeclimat" class="block text-sm font-medium text-gray-700 mb-2">Type Climat</label>
                            <input id="typeClimatHabitat" type="text" name="typeclimat" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">

                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-700">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                placeholder="Entrez la description ici..." required></textarea>
                        </div>
                        <div>
                            <label for="zonezoo" class="block text-sm font-medium text-gray-700 mb-2">zone zoo</label>
                            <input id="zonezoo" type="text" name="zonezoo" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body" required="">

                        </div>
                    </div>
                    <div class="flex items-center space-x-4 border-t border-default pt-4 md:pt-6">
                        <button type="submit" class="inline-flex items-center  text-white bg-green-600  box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">

                            Modifier Habitat
                        </button>
                        <button data-modal-hide="addAnimal" type="button" onclick="closeModalModifierHabitat()" class="text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">Cancel</button>
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
                        <?php if (count($reservations) > 0) {
                            foreach ($reservations as $r) { ?>
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

   
   

    <script>
        
        function openModalAnimal() {
            document.getElementById("addAnimal").classList.remove("hidden");
            document.getElementById("addAnimal").classList.add("block");


        }

        function closeModalAnimal() {
            document.getElementById("addAnimal").classList.remove("block");
            document.getElementById("addAnimal").classList.add("hidden");


        }

        function openModalHabitat() {
            document.getElementById("addHabitat").classList.remove("hidden");
            document.getElementById("addHabitat").classList.add("block");

        }

        function closeModalHabitat() {
            document.getElementById("addHabitat").classList.remove("block");
            document.getElementById("addHabitat").classList.add("hidden");

        }

        function openModalAnimalModify(button) {

            console.log(button.dataset);

            document.getElementById("idAnimal").value = button.dataset.id;
            document.getElementById("nomAnimal").value = button.dataset.nomAnimal;
            document.getElementById("espaceAnimal").value = button.dataset.espece;
            document.getElementById("AlimentationAnimal").value = button.dataset.alimentation;
            document.getElementById("imageAnimal").value = button.dataset.image;
            document.getElementById("paysorigineAnimal").value = button.dataset.paysorigine;
            document.getElementById("descriptioncourteAnimal").value = button.dataset.descriptioncourte;
            document.getElementById("habitatAnimal").value = button.dataset.idHabitat;


            document.getElementById("updateAnimal").classList.remove("hidden");
            document.getElementById("updateAnimal").classList.add("block");

        }


        function closeModalAnimalModify() {
            document.getElementById("updateAnimal").classList.remove("block");
            document.getElementById("updateAnimal").classList.add("hidden");

        }

        function openModalhabitatModify(button) {

            console.log(button.dataset);

            document.getElementById("idhabitat").value = button.dataset.idHabitat;
            document.getElementById("nomHabitat").value = button.dataset.nomHabitat;
            document.getElementById("typeClimatHabitat").value = button.dataset.typeClimat;
            document.getElementById("description").value = button.dataset.description;
            document.getElementById("zonezoo").value = button.dataset.zonezoo;



            document.getElementById("modifierHabitat").classList.remove("hidden");
            document.getElementById("modifierHabitat").classList.add("block");

        }


        function closeModalModifierHabitat() {
            document.getElementById("modifierHabitat").classList.remove("block");
            document.getElementById("modifierHabitat").classList.add("hidden");

        }

        function openModalMesReserver() {

            document.getElementById("mesReservation").classList.remove("hidden");
            document.getElementById("mesReservation").classList.add("block");
        }

        function closeModalMesReserver() {
            document.getElementById("mesReservation").classList.remove("block");
            document.getElementById("mesReservation").classList.add("hidden");
        }
    </script>
</body>

</html>