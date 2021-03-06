<?php return [
    'plugin'     => [
        'name'        => 'Ply',
        'description' => '',
    ],
    'components' => [
        'categories'    => [
            'name'        => 'GetPly Categories',
            'description' => 'Displays a collection of categories (themes).',
        ],
        'courses'       => [
            'name'        => 'GetPly Courses',
            'description' => 'Displays a collection of courses.',
        ],
        'units'         => [
            'name'        => 'GetPly Units',
            'description' => 'Displays a collection of units.',
        ],
        'learn'         => [
            'name'        => 'GetPly Learning',
            'description' => 'Displays vue component with cards',
        ],
        'course_create' => [
            'name'        => 'GetPly Course Create',
            'description' => 'Displays a form for course creation.',
        ],
        'course_upload' => [
            'name'        => 'GetPly Course Upload',
            'description' => 'Displays a form for course uploading.',
        ],
        'user_courses'  => [
            'name'        => 'GetPly User Courses',
            'description' => 'Displays a collection of user courses.',
        ],
    ],
    'properties' => [
        'category_slug_title'              => 'Category Slug Parameter',
        'category_slug_description'        => 'Name of variable, which contains category slug.',
        'category_slug_validation_message' => 'Category Slug parameter is required.',
        'course_slug_title'                => 'Course Slug Parameter',
        'course_slug_description'          => 'Name of variable, which contains course slug.',
        'course_slug_validation_message'   => 'Course Slug parameter is required.',
        'unit_slug_title'                  => 'Unit Slug Parameter',
        'unit_slug_description'            => 'Name of variable, which contains unit slug.',
        'user_id_title'                    => 'User ID Parameter',
        'user_id_description'              => 'Name of variable, which contains user id.',
        'show_subscriptions_title'         => 'Show subscriptions',
        'show_subscriptions_description'   => 'Shows subscriptions except author-courses',
    ],
];