<?php

$_tables = [
    'albums' => 'rudolf_albums',
    'articles' => 'rudolf_articles',
    'categories' => 'rudolf_categories',
    'galleries' => 'rudolf_galleries',
    'menu' => 'rudolf_menu',
    'menu_types' => 'rudolf_menu_types',
    'pages' => 'rudolf_pages',
    'users' => 'rudolf_users',
];

$_fields = [
    $_tables['albums'] => [
        //'id' 			=> ['int', 		11	],
        'category_id' => ['int',        11],
        'title' => ['varchar',    128],
        'author' => ['varchar',    64],
        'date' => ['datetime'],
        'added_by' => ['int',        11],
        'added' => ['datetime'],
        'modified' => ['datetime'],
        'modified_by' => ['int',        11],
        'views' => ['int',        11],
        'slug' => ['varchar',    128],
        'album' => ['varchar',    128],
        'thumb' => ['varchar',    128],
        'photos' => ['int',        11],
        'published' => ['tinyint',    1],
    ],
    $_tables['articles'] => [
        //'id' 			=> ['int', 		11	],
        'category_id' => ['int',        11],
        'title' => ['varchar',    128],
        'keywords' => ['varchar',    255],
        'description' => ['varchar',    255],
        'content' => ['text'],
        'author' => ['varchar',    64],
        'date' => ['datetime'],
        'added_by' => ['int',        11],
        'added' => ['datetime'],
        'modified' => ['datetime'],
        'modified_by' => ['int',        11],
        'views' => ['int',        11],
        'slug' => ['varchar',    128],
        'album' => ['varchar',    128],
        'thumb' => ['varchar',    128],
        'photos' => ['int',        10],
        'published' => ['tinyint',    1],
    ],
    $_tables['categories'] => [
        //'id' 			=> ['int', 		11	],
        'title' => ['varchar',    128],
        'keywords',
        'description',
        'slug' => ['varchar',    128],
        'parent_id' => ['int',        11],
        'type',
    ],
    $_tables['galleries'] => [
        //'id' 			=> ['int', 		11	],
        'title' => ['varchar',    128],
        'slug' => ['varchar',    128],
        'added_by',
        'added',
        'modified',
        'modified_by',
        'thumb_width',
        'thumb_height',
    ],
    $_tables['menu'] => [
        //'id' 			=> ['int', 		11	],
        'menu_type',
        'title' => ['varchar',    128],
        'caption',
        'parent_id' => ['int',        11],
        'position',
        'type',
        'module_name',
        'slug' => ['varchar',    128],
    ],
    $_tables['menu_types'] => [
        //'id' 			=> ['int', 		11	],
        'menu_type',
        'title' => ['varchar',    128],
        'description' => ['varchar',    255],
    ],
    $_tables['pages'] => [
        //'id' 			=> ['int', 		11	],
        'parent_id' => ['int',        11],
        'title' => ['varchar',    128],
        'keywords' => ['varchar',    255],
        'description' => ['varchar',    255],
        'content' => ['text'],
        'added_by' => ['int',        11],
        'added' => ['datetime'],
        'modified' => ['datetime'],
        'modified_by' => ['int',        11],
        'views' => ['int',        11],
        'slug' => ['varchar',    128],
        'published' => ['tinyint',    1],
    ],
    $_tables['users'] => [
        //'id' 			=> ['int', 		11	],
        'nick',
        'first_name',
        'surname',
        'email',
        'password',
        'isactive',
        'dt',
    ],
];
