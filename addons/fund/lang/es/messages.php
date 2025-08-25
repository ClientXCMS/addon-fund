<?php

return [
  'transfer_title' => 'Transferir fondos',
  'credit_title' => 'Acreditación de fondos',
  'invoice' => [
    'add_credit' => 'Añadidos :amount créditos',
  ],
  'recipient' => 'Destinatario',
  'transfer' => [
    'not_enough_funds' => 'No tienes fondos suficientes para realizar esta transferencia',
    'max_amount' => 'El importe máximo de la transferencia es :amount',
    'min_amount' => 'El monto mínimo de transferencia es :amount',
    'min_invoice' => 'Debes agregar al menos :amount a tu cuenta para realizar una transferencia',
    'title' => 'Transferir fondos',
    'description' => 'Transferir fondos entre dos cuentas',
    'recipient' => 'Correo electrónico de la cuenta del destinatario',
    'btn' => 'Transferencia',
    'cancel' => 'La transferencia ha sido cancelada',
    'success' => 'La transferencia se ha completado con éxito. Puede cancelar esta transferencia en :minutes minutos.',
    'already_pending' => 'Ya está pendiente una transferencia. Por favor, espere antes de hacer otro',
    'recipient_not_found' => 'No se encontró al destinatario',
  ],
  'card' => [
    'title' => 'Depositar fondos en mi cuenta',
    'description' => 'Acreditar su cuenta para realizar compras en nuestra plataforma',
    'amount' => 'Importe a acreditar',
    'gateway' => 'Forma de pago',
    'currentbalance' => 'Saldo actual',
    'error' => 'No se puede acreditar su cuenta. No hay ningún método de pago disponible. Póngase en contacto con el servicio de asistencia.',
  ],
  'transfer_table' => [
    'title' => 'Historial de transferencias',
  ],
  'admin' => [
    'transfers' => [
      'title' => 'Transferencias de fondos',
      'transferred_at' => 'Transferir a',
      'subtitle' => 'Encuentre aquí la lista de transferencias de fondos realizadas',
    ],
    'settings' => [
      'title' => 'Configuración de fondos',
      'subtitle' => 'Administración de la configuración de la extensión de fondos',
      'success' => 'Ajustes guardados con éxito',
      'fields' => [
        'max_amount' => 'Montante máximo',
        'min_amount' => 'Cantidad mínima',
        'for_add_credit' => 'Para agregar crédito',
        'for_transfer' => 'Para transferencias entre cuentas',
        'minutes_delay' => 'Tiempo de transferencia (en minutos)',
        'minutes_delay_description' => 'Tiempo de transferencia entre cuentas',
        'min_invoice' => 'Depósito mínimo para poder realizar una transferencia',
        'min_invoice_description' => 'El importe añadido a la cuenta para poder realizar una transferencia. 0 para deshabilitar',
        'authorize_between_accounts' => 'Permitir transferencias entre cuentas',
      ],
    ],
  ],
];
