<?php

/*
 * This file is part of the CLIENTXCMS project.
 * This file is the property of the CLIENTXCMS association. Any unauthorized use, reproduction, or download is prohibited.
 * For more information, please consult our support: clientxcms.com/client/support.
 * Year: 2024
 */
return [
    'transfer_title' => 'Transférer des fonds',
    'credit_title' => 'Créditer des fonds',
    'invoice' => [
        'add_credit' => 'Ajout de :amount crédits',
    ],
    'recipient' => 'Destinataire',
    'transfer' => [
        'not_enough_funds' => 'Vous n\'avez pas assez de fonds pour effectuer ce transfert',
        'max_amount' => 'Le montant maximum de transfert est de :amount',
        'min_amount' => 'Le montant minimum de transfert est de :amount',
        'already_pending' => 'Un transfert est déjà en attente. Veuillez patienter avant d\'en effectuer un autre',
        'recipient_not_found' => 'Le destinataire n\'a pas été trouvé',
        'min_invoice' => 'Vous devez ajouter au moins :amount à votre compte pour effectuer un transfert',
        'title' => 'Transférer des fonds',
        'description' => 'Transférer des fonds entre deux comptes',
        'recipient' => 'E-mail du compte destinataire',
        'btn' => 'Transférer',
        'cancel' => 'Le transfert a été annulé',
        'success' => 'Transfert effectué avec succès. Vous pouvez annuler ce transfert dans les :minutes minutes.',
    ],
    'card' => [
        'title' => 'Créditer mon compte',
        'description' => 'Créditer votre compte pour effectuer des achats sur notre plateforme',
        'amount' => 'Montant à créditer',
        'gateway' => 'Moyen de paiement',
        'currentbalance' => 'Solde actuel',
        'next_balance' => 'Prochain solde',
        'error' => 'Impossible de créditer votre compte. Aucun moyen de paiement n\'est disponible. Veuillez contacter le support.',
    ],
    'transfer_table' => [
        'title' => 'Historique des transferts',
    ],
    'admin' => [
        'transfers' => [
            'title' => 'Transferts de fonds',
            'transferred_at' => 'Transférer à',
            'subtitle' => 'Retrouvez ici la liste des transferts de fonds effectués',
        ],
        'settings' => [
            'title' => 'Paramètres Fonds',
            'subtitle' => 'Gérez les paramètres de l\'extension Fonds, y compris les montants minimum et maximum, ainsi que les transferts entre comptes.',
            'success' => 'Paramètres enregistrés avec succès',
            'fields' => [
                'max_amount' => 'Montant maximum',
                'min_amount' => 'Montant minimum',
                'for_add_credit' => 'Pour l\'ajout de crédit',
                'for_transfer' => 'Pour les transferts entre comptes',
                'minutes_delay' => 'Délai de transferts (en minutes)',
                'minutes_delay_description' => 'Délai de transfert entre les comptes',
                'min_invoice' => 'Dépôt minimum pour pouvoir effectuer un transfert',
                'min_invoice_description' => 'Montant ajouté au compte pour pouvoir effectuer un transfert. 0 pour désactiver',
                'authorize_between_accounts' => 'Autoriser les transferts entre les comptes',
            ],
        ],
    ],
];
