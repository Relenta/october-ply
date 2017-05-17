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
        'learn' => [
            'name' => 'GetPly Учебная зона',
            'description' => 'Выводит vue компонент с карточками.'
        ],
        'course_create' => [
            'name' => 'GetPly Создание курса',
            'description' => 'Отображает форму создания курса.',
        ],
        'course_upload' => [
            'name' => 'GetPly Загрузка курса',
            'description' => 'Отображает форму загрузки курса.',
        ],
        'user_courses' => [
            'name' => 'GetPly Пользовательские курсы',
            'description' => 'Отображает коллекцию курсов пользователя.',
        ],
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
        'user_id_title' => 'Идентификатор пользователя',
        'user_id_description' => 'Имя переменной, которая содержит идентификатор пользователя.',
    ]
];