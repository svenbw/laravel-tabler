<?php

namespace Svenbw\LaravelTabler\View\Components\Form;

use Illuminate\View\Component;

class Card extends Component
{
    protected function getTabs(array $slots): array
    {
        $tabSlots = array_filter($slots, fn ($slot) => str_starts_with($slot, 'cardTab'), ARRAY_FILTER_USE_KEY);
        if (empty($tabSlots)) {
            return [];
        }

        $activeTab = null;
        $tabs = [];
        foreach ($tabSlots as $key => $tabSlot) {
            $attributes = $tabSlot->attributes;
            $tabData = [
                'slot' => $key,
                'text' => $attributes['text'],
                'active' => false,
            ];

            if ($activeTab === null) {
                $activeTab = $key;
            } elseif ($attributes->get('active')) {
                $activeTab = $key;
            }

            if ($attributes->has('ref')) {
                $tabData['ref'] = $attributes['ref'];
            } else {
                $tabData['ref'] = $key;
            }

            $tabs[$key] = $tabData;
        }

        $tabs[$activeTab]['active'] = true;

        return array_values($tabs);
    }

    public function render()
    {
        return function (array $data) {
            $tabs = $this->getTabs($data['__laravel_slots']);

            return view('tabler::components.form.card', array_merge($this->data(), [
                'tabs' => $tabs,
                'showTabs' => $tabs && (count($tabs) > 1),
            ]));
        };
    }
}
