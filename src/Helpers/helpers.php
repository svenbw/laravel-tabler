<?php

use Illuminate\Database\Eloquent\Model;
use League\Flysystem\FilesystemException;
use Svenbw\LaravelTabler\Services\Toast;

if (! function_exists('toast')) {
    function toast(?string $message = null, ?string $title = null): Toast
    {
        $toast = app('toast');

        if (! is_null($message)) {
            return $toast->success($message, $title);
        }

        return $toast;
    }
}

if (! function_exists('__wrap')) {
    /**
     * Translate the given message.
     *
     * @param  string|null  $key
     * @param  array  $replace
     * @param  string|null  $locale
     * @return string|array|null
     */
    function __wrap($key = null, $replace = [], $wrap = [], $locale = null)
    {
        if (is_null($key)) {
            return $key;
        }

        $replacesWrapped = [];
        foreach ($replace as $replaceKey => $replaceText) {
            if (array_key_exists($replaceKey, $wrap)) {
                $openTag = $wrap[$replaceKey];
                if (preg_match('/^(\S*)/', $openTag, $matches) === 1) {
                    $closeTag = $matches[1];
                } else {
                    $closeTag = $openTag;
                }
                $replacesWrapped[$replaceKey] = sprintf('<%s>%s</%s>', $openTag, $replaceText, $closeTag);
            } else {
                $replacesWrapped[$replaceKey] = $replaceText;
            }
        }

        return trans($key, $replacesWrapped, $locale);
    }
}

if (! function_exists('word_array_join')) {
    function word_array_join(array $words)
    {
        $lastWord = array_pop($words);
        if (! empty($words)) {
            return __('common.word_array_join_and', ['first' => implode(', ', $words), 'last' => $lastWord]);
        }

        return $lastWord;
    }
}

if (! function_exists('failureSummary')) {
    function failureSummary(Error|Exception|FilesystemException|null $ex): string
    {
        return (preg_split('#\r?\n#', $ex, 2) ?? [''])[0];
    }
}

if (! function_exists('oldSelect')) {
    function oldSelect(string $key, ?Model $model, string $modelClass, string $labelField = 'name', string $valueField = 'uuid')
    {
        $oldValue = old($key);

        if ($oldValue === '') {
            return null;
        }

        if ($oldValue) {
            $model = $modelClass::where($valueField, $oldValue)->first();

            return $model ? [$model->$valueField => $model->$labelField] : null;
        }

        if ($model) {
            return [$model->$valueField => $model->$labelField];
        }

        return null;
    }
}

if (! function_exists('selectOptions')) {
    function selectOptions(array $items)
    {
        $options = [];
        foreach ($items as $key => $item) {
            if ($item instanceof \BackedEnum) {
                $options[(string) $item->value] = method_exists($item, 'label') ? $item->label() : $item->name;
            } else {
                $options[(string) $item->value] = $item;
            }
        }

        return $options;
    }
}
