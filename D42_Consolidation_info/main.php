<?php

require_once 'GameMaster.php';
require_once 'Rencontre.php';

$gm = new GameMaster();

// Liste des rencontres avec leur difficulté (seuil de fumble différent)
$scenario = [
    new Rencontre("Gobelin", 20.0),
    new Rencontre("Troll", 25.0),
    new Rencontre("Golem", 30.0),
    new Rencontre("Nécromancien", 35.0),
    new Rencontre("Dragon", 40.0),
];

$echecsConsecutifs = 0;
$echecsTotal = 0;

foreach ($scenario as $index => $rencontre) {
    echo PHP_EOL . "🗡️ Rencontre " . ($index + 1) . " : " . $rencontre->nom . PHP_EOL;

    $resultat = $gm->resoudreRencontre($rencontre);

    if ($resultat === ResultatStatut::FUMBLE) {
        exit("💀 Fumble ! Le groupe meurt.");
    }

    if ($resultat === ResultatStatut::ECHEC) {
        $echecsConsecutifs++;
        $echecsTotal++;
        echo "❌ Échec ! ($echecsConsecutifs consécutifs / $echecsTotal cumulés)\n";

        if ($echecsConsecutifs >= 2) {
            exit("💀 2 échecs consécutifs. Le groupe meurt.");
        }

        if ($echecsTotal >= 4) {
            exit("💀 4 échecs cumulés. Le groupe meurt.");
        }

        echo "🔁 On retente la rencontre...\n";
        continue; // on relance la même rencontre
    }

    if ($resultat === ResultatStatut::REUSSITE) {
        echo "✅ Succès ! On passe à la suite.\n";
        $echecsConsecutifs = 0;
    }

    if ($resultat === ResultatStatut::REUSSITE_CRITIQUE) {
        echo "✨ Réussite critique ! Potion trouvée 💊\n";
        $echecsConsecutifs = 0;
        if ($echecsTotal > 0) {
            $echecsTotal--;
            echo "🎁 Potion utilisée : échecs cumulés = $echecsTotal\n";
        }
    }
}
