<?php

return [
    'home' => 'Take me home',
    'codes' => [
        'default' => [
            'title' => 'Something went wrong',
            'message' => 'An error occurred. Please try again later.',
        ],
        '401' => [
            'title' => 'You are not signed in',
            'message' => 'Sign in to see this page.',
        ],
        '403' => [
            'title' => 'Access denied',
            'message' => 'You are not allowed to see this page.',
        ],
        '404' => [
            'title' => 'Page not found',
            'message' => 'This page does not exist.',
        ],
        '405' => [
            'title' => 'Not possible',
            'message' => 'This action is not possible on this page.',
        ],
        '410' => [
            'title' => 'No longer available',
            'message' => 'This page is no longer available.',
        ],
        '419' => [
            'title' => 'Page expired',
            'message' => 'The page was open too long. Go back, refresh the page and try again.',
        ],
        '429' => [
            'title' => 'Too many attempts',
            'message' => 'There were too many requests in a short time. Please wait a while and try again.',
        ],
        '500' => [
            'title' => 'Something went wrong',
            'message' => 'An unexpected error occurred. Please try again later.',
        ],
        '503' => [
            'title' => 'Under maintenance',
            'message' => 'We are working on the application. Please try again in a few minutes.',
        ],
    ],
];
