<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\TimePicker;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Plan an event session: room and meeting link depend on the format.
 */
class EventSessionForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/event-session.{$key}", $replace);

        return [
            Fieldset::make($t('session'))->columns(2)->fields([
                TextInput::make('title')->label($t('title'))->required()->placeholder($t('title_placeholder'))->columnSpan(2),
                DatePicker::make('dates')->label($t('dates'))->range()->required()->columnSpan(2),
                TimePicker::make('starts_at')->label($t('starts_at'))->minuteStep(15)->required()->clearable(),
                TimePicker::make('ends_at')->label($t('ends_at'))->minuteStep(15)->clearable(),
            ]),
            Fieldset::make($t('format_section'))->columns(2)->fields([
                Radio::make('format')->label($t('format'))->options([
                    ['value' => 'in_person', 'label' => $t('format_in_person'), 'description' => $t('format_in_person_description')],
                    ['value' => 'online', 'label' => $t('format_online'), 'description' => $t('format_online_description')],
                    ['value' => 'hybrid', 'label' => $t('format_hybrid'), 'description' => $t('format_hybrid_description')],
                ])->default('in_person')->columns(3)->columnSpan(2),
                Combobox::make('room')->label($t('room'))->options([
                    'Main hall' => $t('room_main_hall'),
                    'Workshop A' => $t('room_workshop_a'),
                    'Workshop B' => $t('room_workshop_b'),
                    'Studio' => $t('room_studio'),
                ])->required()
                    ->visibleWhen('format', 'in', ['in_person', 'hybrid'])->clearWhenHidden(),
                TextInput::make('meeting_link')->label($t('meeting_link'))->url()->required()->placeholder('https://meet.example.com/…')
                    ->visibleWhen('format', 'in', ['online', 'hybrid'])->clearWhenHidden(),
                Slider::make('capacity')->label($t('capacity'))->min(10)->max(300)->step(10)->default(50)->columnSpan(2),
                TagsInput::make('speakers')->label($t('speakers'))->placeholder($t('speakers_placeholder'))->reorderable()->columnSpan(2),
                Toggle::make('recorded')->label($t('recorded'))->onLabel($t('yes'))->offLabel($t('no')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
