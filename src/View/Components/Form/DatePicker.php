<?php

namespace Svenbw\LaravelTabler\View\Components\Form;

use DateTimeInterface;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;
use Svenbw\LaravelTabler\Helpers\Form;
use Svenbw\LaravelTabler\Helpers\WireModelEntangler;
use Svenbw\LaravelTabler\Tabler;

class DatePicker extends Component
{
    public string $id;

    public string $format;

    public ?string $displayFormat;

    public function __construct(
        public string $name,
        public Htmlable|string|null $label = null,
        ?string $id = null,
        public mixed $value = null,
        public ?string $placeholder = null,
        public int|string|null $tabindex = null,
        public ?string $col = null,
        public bool $readonly = false,
        public bool $disabled = false,
        ?string $format = null,
        public bool $enableTime = false,
        public bool $noCalendar = false,
        public bool $time24hr = true,
        public string $mode = 'single',
        public bool $icon = true,
        ?string $displayFormat = null,
        public Htmlable|string|null $hint = null,
        public mixed $minDate = null,
        public mixed $maxDate = null,
        public mixed $disable = null,
        public ?string $locale = null,
    ) {
        $this->id = $id ?? $name.'_'.uniqid();
        $this->format = $format ?? Tabler::dateFormat();

        if ($this->value instanceof DateTimeInterface) {
            $this->value = $this->value->format($this->format);
        }

        if ($displayFormat === null && ! $noCalendar) {
            $displayFormat = Tabler::localeDateFormat();
            if ($enableTime) {
                $displayFormat .= $time24hr ? ' H:i' : ' h:i K';
            }
        }
        $this->displayFormat = $displayFormat;
    }

    public function errorKey(): string
    {
        return Form::errorKey($this->name);
    }

    public function cols(): string
    {
        return Form::colClass($this->col);
    }

    public function config(): array
    {
        $options = [
            'dateFormat' => $this->format,
            'enableTime' => $this->enableTime,
            'noCalendar' => $this->noCalendar,
            'time_24hr' => $this->time24hr,
            'mode' => $this->mode,
        ];
        if ($this->displayFormat) {
            $options['altInput'] = true;
            $options['altFormat'] = $this->displayFormat;
        }

        return [
            'value' => $this->value,
            'locale' => $this->locale ?? app()->getLocale(),
            'options' => $options + array_filter([
                'minDate' => $this->minDate,
                'maxDate' => $this->maxDate,
                'disable' => $this->disable,
            ], fn ($value) => $value !== null),
        ];
    }

    public function xData(): HtmlString
    {
        return WireModelEntangler::make($this->attributes)->xData('datePicker', $this->config());
    }

    public function render()
    {
        return view('tabler::components.form.date-picker');
    }
}
