@props(['label', 'name', 'value' => '', 'col' => null, 'options' => null, 'optionGroups' => null, 'multiple' => false, 'allowEmpty' => false, 'note', 'url' => null])
@php
	$wireModel = $attributes->wire('model');
	$cols = is_string($col) ? join(' ', array_map(fn($col) => 'col-'.$col, explode(' ', $col))) : '';
	$id = str_replace('[]','', $name);
	$isInvalid = isset($errors) && $errors->has($id);
	$alpineOn = $attributes->whereStartsWith(['x-on:', '@']);
	$attributes = $attributes->except(array_keys($alpineOn->all()));
@endphp
<div @class(['mb-3', $cols])>
	<label @class(['form-label', 'required' => $attributes->has('required')]) for={{ $id }}>{{ $label }}</label>
	<div @class(['is-invalid' => $isInvalid]) {{ $alpineOn }}>
		<div
			wire:ignore
			@if($wireModel->directive)
				x-data="{ modelValue: @entangle($wireModel), select: null }"
			@else
				x-data="{ modelValue: @js($value), select: null} "
			@endif
			x-init="
				const renderTemplates = {
					option: function(data, escape) {
						return `<div>
							${data.icon ? `<i class='${escape(data.icon)} me-2'></i>` : ''}
							<span>${escape(data.text)}</span>
						</div>`;
					},
					item: function(data, escape) {
						return `<div>
							${data.icon ? `<i class='${escape(data.icon)} me-2'></i>` : ''}
							${escape(data.text)}
						</div>`;
					}
				};

			@if($url !== null)
				const options = {
					valueField: 'value',
					labelField: 'text',
					searchField: 'text',
					allowEmptyOption: @js($allowEmpty),
					maxItems: {{ $multiple ? 'null' : 1}},
					render: renderTemplates,
					load: function(query, callback) {
						axios.post('{{ $url }}', { data: { query: query } })
						.then(response => response.data)
						.then(data => {
							callback(data.data);
						}).catch(() => {
							callback();
						});
					}
				}
			@else
				const options = {
					create: true,
					allowEmptyOption: @js($allowEmpty),
					render: renderTemplates,
				}
			@endisset

				select = new TomSelect($refs.select, options);

			@if($wireModel->directive)
				select.on('change', (value) => {
					$wire.set('{{ $wireModel->value }}', value);
				})
			@endif

			@if($multiple)
				select.setValue(JSON.parse(JSON.stringify(modelValue)))
			@elseif($url !== null)
				const entries = Object.entries(modelValue)
				if (entries.length > 0) {
					const [uuid, label] = entries[0]
					select.addOption({value: uuid, text: label})
					select.setValue(uuid)
				}
			@else
				if(modelValue !== null) {
					if (typeof modelValue !== 'object') {
						select.setValue(modelValue)
					} else {
						const entries = Object.entries(modelValue)
						if (entries.length > 0) {
							const [uuid, label] = entries[0]
							select.addOption({value: uuid, text: label})
							select.setValue(uuid)
						}
					}
				} else {
					select.clear();
				}
			@endif
		">
			<select
				x-ref="select"
				@if($multiple)
					multiple="multiple" 
				@endif
				name="{{ $name }}"
				id="{{ $id }}"
				@class(['is-invalid' => $isInvalid])
				@if($attributes->has('readonly')) readonly @endif
			>
				@if(isset($optionGroups) && is_array($optionGroups))
					@foreach($optionGroups as $group)
						<optgroup label="{{ $group['name'] }}">
							@foreach($group['options'] as $val => $opt)
								<option value="{{ $val }}" 
									@if(is_scalar($value) && (string) $value === (string) $val) selected @endif
									@if(is_array($opt) && array_key_exists('icon', $opt))
									data-icon="{{ $opt['icon'] }}"
									@endif>
									{{ is_array($opt) ? $opt['text'] : $opt }}
								</option>
							@endforeach
						</optgroup>
					@endforeach
				@elseif($options && is_array($options))
					@foreach($options as $val => $opt)
						<option value="{{ $val }}" 
							@if(is_scalar($value) && (string) $value === (string) $val) selected @endif
							@if(is_array($opt) && array_key_exists('icon', $opt))
							data-icon="{{ $opt['icon'] }}"
							@endif>
							{{ is_array($opt) ? $opt['text'] : $opt }}
						</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>
	@if($isInvalid)
		<div class="invalid-feedback">{{ join(',', $errors->get($id)) }}</div>
	@endif
	@isset($note)
		<span class="text-muted">{{ $note }}</span>
	@endisset
</div>
