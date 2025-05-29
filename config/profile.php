<?php

declare(strict_types=1);

return [
    'fields' => [
        'about' => [
            'label' => 'About',
            'type' => 'Textarea',
            'rules' => 'required',
        ],
        'occupation' => [
            'label' => 'What do you do for a living?',
            'type' => 'TextInput',
            'rules' => '',
        ],
    ],
];
