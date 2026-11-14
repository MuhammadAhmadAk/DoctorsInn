<?php

return [
    'roles' => [
        'instructor' => 'Instructor',
        'staff' => 'Staff',
        'admin' => 'Administrator',
    ],

    'permissions' => [
        'cms' => 'Website CMS',
        'courses' => 'Courses & Lectures',
        'tests' => 'Mock Tests',
        'library' => 'E-Library',
        'blogs' => 'Blog Posts',
        'students' => 'Students',
        'enrollments' => 'Enrollments & Payments',
        'settings' => 'Settings',
        'staff' => 'Staff Access',
    ],

    'role_defaults' => [
        'instructor' => ['courses', 'tests', 'enrollments'],
        'staff' => ['students', 'enrollments', 'library'],
    ],
];
