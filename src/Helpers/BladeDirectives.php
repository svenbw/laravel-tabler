<?php

namespace Svenbw\LaravelTabler\Helpers;

class BladeDirectives
{
    // HasDeleteDialog Trait
    public static function ifDeleteDialog(): string
    {
        return <<<'EOT'
            <?php if(isset($deleteItem) && is_array($deleteItem)): ?>
EOT;
    }

    // HasDeleteDialog Trait
    public static function endifDeleteDialog(): string
    {
        return <<<'EOT'
            <?php endif; ?>
EOT;
    }

    public static function deleteDialogAttribute(string $expression): string
    {
        return <<<EOT
            <?php echo ((isset(\$deleteItem) && is_array(\$deleteItem) && array_key_exists($expression, \$deleteItem)) ? \$deleteItem[$expression] : '') ?>
EOT;
    }

    public static function appVersion(): string
    {
        return <<<EOT
            <?php echo \Svenbw\LaravelTabler\Services\VersionService::make()->generateVersion(); ?>
EOT;
    }

    public static function appYear(): string
    {
        return <<<EOT
            <?php echo \Svenbw\LaravelTabler\Services\VersionService::make()->year(); ?>
EOT;
    }

    public static function disabled(string $expression): string
    {
        return <<<EOT
            <?php if ($expression) { echo ' disabled '; } ?>
EOT;
    }
}
