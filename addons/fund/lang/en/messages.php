<?php

return [
    'transfer_title' => 'Transfer funds',
    'credit_title' => 'Crediting funds',
    'invoice' => [
        'add_credit' => 'Added :amount credits',
    ],
    'recipient' => 'Addressee',
    'transfer' => [
        'not_enough_funds' => 'You don\'t have enough funds to make this transfer',
        'max_amount' => 'The maximum transfer amount is :amount',
        'min_amount' => 'The minimum transfer amount is :amount',
        'min_invoice' => 'You must add at least :amount to your account to make a transfer',
        'title' => 'Transfer funds',
        'description' => 'Transfer funds between two accounts',
        'recipient' => 'Recipient Account Email',
        'btn' => 'Transfer',
        'cancel' => 'The transfer has been cancelled',
        'success' => 'Transfer completed successfully. You can cancel this transfer within :minutes minutes.',
    ],
    'card' => [
        'title' => 'Fund my account',
        'description' => 'Crediting your account to make purchases on our platform',
        'amount' => 'Amount to be credited',
        'gateway' => 'Payment method',
        'currentbalance' => 'Current Balance',
        'error' => 'Unable to credit your account. No payment method is available. Please contact support.',
    ],
    'transfer_table' => [
        'title' => 'Transfer history',
    ],
    'admin' => [
        'transfers' => [
            'title' => 'Transfers of funds',
            'transferred_at' => 'Transfer to',
            'subtitle' => 'Find here the list of transfers of funds made',
        ],
        'settings' => [
            'title' => 'Funds Settings',
            'subtitle' => 'Managing Fund Extension Settings',
            'success' => 'Successfully saved settings',
            'fields' => [
                'max_amount' => 'Montant maximum',
                'min_amount' => 'Minimum amount',
                'for_add_credit' => 'For adding credit',
                'for_transfer' => 'For transfers between accounts',
                'minutes_delay' => 'Transfer time (in minutes)',
                'minutes_delay_description' => 'Transfer time between accounts',
                'min_invoice' => 'Minimum deposit to be able to make a transfer',
                'min_invoice_description' => 'The amount added to the account to be able to make a transfer. 0 to disable',
                'authorize_between_accounts' => 'Allow transfers between accounts',
            ],
        ],
    ],
];
