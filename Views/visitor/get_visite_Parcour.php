<?php 
require "../../Models/database.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $db = Database::connect();

    $sqlParcour = "SELECT titreetape, descriptionetape, ordreetape 
                   FROM etapesvisite 
                   WHERE id_visite = :id 
                   ORDER BY ordreetape ASC";

    $stmt = $db->prepare($sqlParcour);
    $stmt->execute(['id' => $id]);

    $resultParcour = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($resultParcour) > 0) {
        foreach ($resultParcour as $row) { ?>
            <li class="bg-green-50 p-4 rounded-xl shadow-md border-l-4 border-green-500 mb-4 transition-all duration-300">
                <div class="flex items-center mb-2">
                    <span class="bg-green-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold mr-3">
                        <?= htmlspecialchars($row['ordreetape']) ?>
                    </span>
                    <h3 class="text-xl font-semibold text-green-800">
                        <?= htmlspecialchars($row['titreetape']) ?>
                    </h3>
                </div>
                <p class="text-gray-700 pl-9">
                    <?= htmlspecialchars($row['descriptionetape']) ?>
                </p>
            </li>
        <?php }
    } else {
        echo "<p class='text-center text-gray-500 py-4'>Aucune étape pour ce parcours.</p>";
    }
}
?>
