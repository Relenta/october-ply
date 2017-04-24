<?php return [
    'plugin' => [
        'name' => 'Ply',
        'description' => ''
    ],
    'components' => [
        'categories' => [
            'name' => 'GetPly Categories',
            'description' => 'Displays a collection of categories (themes).'
        ],
        'courses' => [
            'name' => 'GetPly Courses',
            'description' => 'Displays a collection of courses.'
        ],
        'units' => [
            'name' => 'GetPly Units',
            'description' => 'Displays a collection of units (if no units - loads cards component).'
        ],
        'cards' => [
            'name' => 'GetPly Cards',
            'description' => 'Displays a collection of cards.'
        ],
        'course_update' => [
            'name' => 'GetPly Course Update',
            'description' => 'Displays a form with course.',
        ]
    ],
    'properties' => [
        'category_slug_title' => 'Category Slug Parameter',
        'category_slug_description' => 'Name of variable, which contains category slug.',
        'category_slug_validation_message' => 'Category Slug parameter is required.',
        'course_slug_title' => 'Course Slug Parameter',
        'course_slug_description' => 'Name of variable, which contains course slug.',
        'course_slug_validation_message' => 'Course Slug parameter is required.',
        'unit_slug_title' => 'Unit Slug Parameter',
        'unit_slug_description' => 'Name of variable, which contains unit slug.',
    ]
];