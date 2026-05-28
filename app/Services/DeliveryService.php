<?php

namespace App\Services;

class DeliveryService
{
    /**
     * Calculer les frais de livraison selon la commune/city
     */
    public function calculateDeliveryFee(string $location, float $orderTotal): int
    {
        $deliveryZones = [
            // Communes d'Abidjan
            'plateau' => 1500,
            'cocody' => 1500,
            'yopougon' => 2000,
            'abobo' => 2500,
            'attécoubé' => 2000,
            'bassam' => 3000,
            'bingerville' => 3000,
            'koumassi' => 2000,
            'marcory' => 1500,
            'port-bouët' => 2500,
            'treichville' => 1500,
            'songon' => 3000,
            
            // Villes de l'intérieur
            'bouaké' => 5000,
            'korhogo' => 6000,
            'san-pédro' => 7000,
            'yamoussoukro' => 4000,
            'daloa' => 5000,
            'man' => 6000,
            'duékoué' => 6000,
            'abengourou' => 5000,
            'bondoukou' => 6000,
            'other' => 8000,
        ];

        $location = strtolower(trim($location));
        $fee = $deliveryZones[$location] ?? $deliveryZones['other'];

        // Livraison gratuite pour commandes > 500 000 FCFA
        if ($orderTotal >= 500000) {
            return 0;
        }

        return $fee;
    }

    /**
     * Obtenir la liste des zones de livraison
     */
    public function getDeliveryZones(): array
    {
        return [
            'abidjan' => [
                'plateau' => 'Plateau',
                'cocody' => 'Cocody',
                'yopougon' => 'Yopougon',
                'abobo' => 'Abobo',
                'attécoubé' => 'Attécoubé',
                'bassam' => 'Grand-Bassam',
                'bingerville' => 'Bingerville',
                'koumassi' => 'Koumassi',
                'marcory' => 'Marcory',
                'port-bouët' => 'Port-Bouët',
                'treichville' => 'Treichville',
                'songon' => 'Songon',
            ],
            'interieur' => [
                'bouaké' => 'Bouaké',
                'korhogo' => 'Korhogo',
                'san-pédro' => 'San-Pédro',
                'yamoussoukro' => 'Yamoussoukro',
                'daloa' => 'Daloa',
                'man' => 'Man',
                'duékoué' => 'Duékoué',
                'abengourou' => 'Abengourou',
                'bondoukou' => 'Bondoukou',
            ],
        ];
    }

    /**
     * Formater le prix en FCFA
     */
    public function formatPrice(int $price): string
    {
        return number_format($price, 0, ',', ' ') . ' FCFA';
    }
}
