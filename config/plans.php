<?php

return [
    'limit_labels' => [
        'services' => 'Serviços',
        'staff' => 'Funcionários',
        'appointments_per_month' => 'Agendamentos por mês',
        'storage_mb' => 'Armazenamento (MB)',
        'customers' => 'Clientes',
    ],
    'free' => [
        'name' => 'Free',
        'price' => 0,
        'currency' => 'BRL',
        'limits' => [
            'services' => 4,
            'staff' => 1,
            'appointments_per_month' => 10,
            'storage_mb' => 20,
            'customers' => 5,
        ],
        'features' => [
            'Agenda básica',
            'Página Bio pública',
            'Relatórios simples',
        ],
    ],
    'premium' => [
        'name' => 'Premium',
        'price' => 75.9,
        'currency' => 'BRL',
        'limits' => [
            'services' => 30,
            'staff' => 5,
            'appointments_per_month' => 100,
            'storage_mb' => 2048,
        ],
        'features' => [
            'Tudo do Free',
            'Lembretes por e-mail',
            'Relatórios avançados',
        ],
    ],
    'master' => [
        'name' => 'Master',
        'price' => 135.9,
        'currency' => 'BRL',
        'limits' => [
            'services' => 999,
            'staff' => 50,
            'appointments_per_month' => 1000,
            'storage_mb' => 10240,
        ],
        'features' => [
            'Tudo do Premium',
            'Suporte prioritário',
            'APIs e integrações',
        ],
    ],
];


