<?php

namespace Svenbw\LaravelTabler\Helpers;

class Form
{
    public static function colClass(?string $col): string
    {
        if ($col === null || trim($col) === '') {
            return '';
        }

        $parts = array_filter(
            explode(' ', $col),
            fn (string $part) => preg_match('/^((sm|md|lg|xl|xxl)(-(\d{1,2}|auto))?|\d{1,2}|auto)$/', $part) === 1
        );

        return implode(' ', array_map(fn (string $part) => 'col-'.$part, $parts));
    }

    public static function id(string $name, mixed $value = null): string
    {
        $id = trim(preg_replace('/[^A-Za-z0-9_-]+/', '-', $name), '-');

        if ($value !== null && (string) $value !== '') {
            $id .= '-'.trim(preg_replace('/[^A-Za-z0-9_-]+/', '-', (string) $value), '-');
        }

        return $id;
    }

    public static function errorKey(string $name): string
    {
        $name = preg_replace('/\[\]$/', '', $name);

        return preg_replace('/\[(.*?)\]/', '.$1', $name);
    }

    public static function margin(?string $class, string $default = 'mb-3'): ?string
    {
        return preg_match('/(^|\s)m[tbyx]?-/', (string) $class) === 1 ? null : $default;
    }
}
