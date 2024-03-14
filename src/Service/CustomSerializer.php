<?php

namespace App\Service;

class CustomSerializer
{
    public function serializeCommandes($commandes)
    {
        $commandesData = [];

        // Iterate through each Commande
        foreach ($commandes as $commande) {
            // Access the Chantier of each Commande
            $chantier = $commande->getChantier();
            $conducteur = $commande->getConducteur();

            // Serialize each Commande with minimal Chantier data to avoid back-reference
            $commandesData[] = [
                'id' => $commande->getId(),
                'date' => $commande->getDateCde(),
                'poids' => $commande->getPoidsTotMat(),
                'initiales' => $conducteur->getFirstname() . ' ' . $conducteur->getLastname(),
                'erplocations' => $commande->getNumErpLocation(),
                'motif' => $commande->getMotif(),

                // Include other necessary properties of Commande
                'chantier' => [
                    'id' => $chantier->getIdChantier(),
                    'name' => $chantier->getNomChantier(),
                    'adresse' => $chantier->getAdresse(),
                    'ville' => $chantier->getVille(),
                    'codechantier' => $commande->getChantier()->getNumChantier(),

                    // Include other necessary properties of Chantier as needed
                ],
                'conducteur' => [
                    'id' => $conducteur->getId(),
                    'pseudo' => $conducteur->getPseudo(),
                    'name' => $conducteur->getFirstname() . ' ' . $conducteur->getLastname(),


                    // Include other necessary properties of Chantier as needed
                ]
            ];
        }

        return $commandesData;
    }
}
