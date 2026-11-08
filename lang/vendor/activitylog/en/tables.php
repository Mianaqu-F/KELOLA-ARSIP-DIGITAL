<?php

return [
    'columns' => [
        'log_name' => [
            'label' => 'Tipe',
        ],
        'event' => [
            'label' => 'Aktivitas',
        ],
        'subject_type' => [
            'label'        => 'Data',
            'soft_deleted' => ' (Soft Deleted)',
            'deleted'      => ' (Deleted)',
        ],
        'causer' => [
            'label' => 'Pengguna',
        ],
        'properties' => [
            'label' => 'Perubahan',
        ],
        'created_at' => [
            'label' => 'Waktu',
        ],
    ],
    'filters' => [
        'created_at' => [
            'label'                   => 'Logged at',
            'created_from'            => 'Created from ',
            'created_from_indicator'  => 'Created from  : :created_from',
            'created_until'           => 'Created until ',
            'created_until_indicator' => 'Created until  : :created_until',
        ],
        'event' => [
            'label' => 'Event',
        ],
        'log_name' => [
            'label' => 'Log name',
        ],
    ],
];
