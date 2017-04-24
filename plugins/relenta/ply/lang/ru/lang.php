<?php return [
    'plugin' => [
        'name' => 'Ply',
        'description' => ''
    ],
    'components' => [
        'categories' => [
            'name' => 'GetPly Категории',
            'description' => 'Выводит коллекцию категорий (тем).'
        ],
        'courses' => [
            'name' => 'GetPly Курсы',
            'description' => 'Выводит коллекцию курсов.'
        ],
        'units' => [
            'name' => 'GetPly Разделы',
            'description' => 'Выводит коллекцию разделов (если таковых нет - загружает компонент Карточки).'
        ],
        'cards' => [
            'name' => 'GetPly Карточки',
            'description' => 'Выводит список карточек.'
        ],
        'course_update' => [
            'name' => 'GetPly Обновление курса',
            'description' => 'Отображает форму обновления курса.',
        ]
    ],
    'properties' => [
        'category_slug_title' => 'Slug Категории',
        'category_slug_description' => 'Имя переменной, которая содержит slug категории.',
        'category_slug_validation_message' => 'Slug категории обязателен к заполнению.',
        'course_slug_title' => 'Slug Курса',
        'course_slug_description' => 'Имя переменной, которая содержит slug курса.',
        'course_slug_validation_message' => 'Slug курса обязателен к заполнению.',
        'unit_slug_title' => 'Slug Раздела',
        'unit_slug_description' => 'Имя переменной, которая содержит slug раздела.',
    ]
];