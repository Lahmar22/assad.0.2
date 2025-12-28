<?php
session_start();

require_once '../../Models/visiteGuid.php';
require_once '../../Models/commentaire.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: ../../index.php');
    exit();
}

$visiteGuid = new VisitesGuides();
$visiteGuides = $visiteGuid->getAllVisitesGuides();
$visiteGuidesIdTitre = $visiteGuid->getAllVisitesGuides();

$commentaire = new Commentaire();

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
                    <a href="home.php">
                        <img src="../../images/assad.png" alt="Logo"
                        class="w-20 h-20 object-contain rounded-full border-4 border-white shadow-md">
                    </a>
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


        


        <section class="mb-16">
    <!-- Title -->
    <h2 class="text-3xl font-extrabold text-gray-800 mb-10 flex items-center gap-3">
        <span class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">🗺️</span>
        Les Visites Guidées
    </h2>

    <!-- Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
        <?php foreach ($visiteGuides as $vd) { ?>
        <div class="bg-white rounded-3xl shadow-md hover:shadow-xl transition overflow-hidden border border-gray-100">

            <!-- Header -->
            <div class="p-6 bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 border-b">
                <h3 class="text-xl font-bold text-gray-800">
                    <?= htmlspecialchars($vd->titre) ?>
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    📅 <?= $vd->dateheure ?> &nbsp;•&nbsp; 🌍 <?= $vd->langue ?>
                </p>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-6">

                <!-- Info -->
                <div class="flex justify-between text-sm text-gray-600">
                    <span>👥 Capacité <b><?= $vd->capacite_max ?></b></span>
                    <span>⏱️ <?= $vd->duree ?></span>
                </div>

                <!-- Price & Status -->
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-extrabold text-indigo-600">
                        <?= $vd->prix ?> MAD
                    </span>

                    <span class="px-4 py-1.5 rounded-full text-xs font-semibold
                        <?= $vd->statut === 'Active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' ?>">
                        <?= $vd->statut ?>
                    </span>
                </div>

                <!-- Comments -->
                <div class="bg-gray-50 rounded-2xl p-4 space-y-4">
                    <h4 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                        💬 Avis des visiteurs
                    </h4>

                    <?php
                    $commentaires = $commentaire->getCommentaire($vd->id);

                    if (!empty($commentaires)) {
                        foreach ($commentaires as $c) {
                            ?>
                            <div class="bg-white rounded-2xl border border-gray-100 p-4">

                                <!-- Comment Header -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-500 text-white font-bold flex items-center justify-center">
                                            <?= strtoupper(substr($c->nom, 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800 text-sm">
                                                <?= htmlspecialchars($c->nom . ' ' . $c->prenom) ?>
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                <?= date('d M Y', strtotime($c->date_commentaire)) ?>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Stars -->
                                    <div class="text-yellow-400 text-sm">
                                        <?php for ($i = 1; $i <= 5; $i++) {
                                            echo $i <= $c->note ? '★' : '☆';
                                        } ?>
                                    </div>
                                </div>

                                <!-- Comment Text -->
                                <p class="text-gray-700 text-sm leading-relaxed italic">
                                    “<?= htmlspecialchars($c->texte) ?>”
                                </p>

                            </div>
                        <?php }
                    } else { ?>
                        <p class="text-center text-sm text-gray-400 italic">
                            Aucun commentaire pour cette visite
                        </p>
                    <?php } ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-4 bg-gray-50 border-t flex justify-between items-center">

                <!-- Status Update -->
                <form action="../../controllers/updateStatutVisitGuid.php" method="POST">
                    <input type="hidden" name="id_visiteGuid" value="<?= $vd->id ?>">
                    <select name="statut"
                        onchange="this.form.submit()"
                        class="text-xs font-semibold rounded-full px-4 py-1.5 cursor-pointer
                        <?= $vd->statut === 'Active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700' ?>">
                        <option value="Active" <?= $vd->statut === 'Active' ? 'selected' : '' ?>>Active</option>
                        <option value="Inactive" <?= $vd->statut === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </form>

                <!-- Delete -->
                <form action="../../controllers/removeVisitGuid.php" method="POST"
                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette visite guidée ?');">
                    <input type="hidden" name="id_visitGuid" value="<?= $vd->id ?>">
                    <button class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-5 py-2 rounded-xl transition">
                        Supprimer
                    </button>
                </form>
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
                <form action="../../controllers/createVisitGuid.php" method="POST" class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow">

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
            <form action="../../controllers/createParcourVisite.php" method="post" class="space-y-4">

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

                        <?php foreach ($visiteGuidesIdTitre as $vit) { ?>
                            <option value="<?= $vit->id ?>">
                                <?= $vit->titre ?>
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

        

        function openParcourModal() {
            document.getElementById("modalParcourVisite").classList.remove("hidden");
        }

        function closeParcourModal() {
            document.getElementById("modalParcourVisite").classList.add("hidden");
        }
    </script>
    

    


    
</body>

</html>