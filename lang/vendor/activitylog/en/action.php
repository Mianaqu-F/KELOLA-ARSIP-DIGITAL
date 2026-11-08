<?php

return [
    'modal' => [
        'heading'     => 'User Activity Log',
        'description' => 'Track all user activities',
        'tooltip'     => 'User Activities',
    ],
        'event' => [
        'created' => 'Dibuat',
        'updated' => 'Diubah',
        'deleted' => 'Dihapus',
        'restored' => 'Dipulihkan',
    ],
    'view'                => 'View',
    'edit'                => 'Edit',
    'restore'             => 'Restore',
    'restore_soft_delete' => [
        'label'             => 'Restore Model',
        'modal_heading'     => 'Restore Deleted Model',
        'modal_description' => 'This will restore the model that was deleted (soft delete).',
    ],
];
