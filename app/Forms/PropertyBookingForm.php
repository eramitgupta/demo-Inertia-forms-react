<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\TimePicker;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Book a stay: pet details show up when pets are coming along.
 */
class PropertyBookingForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/property-booking.{$key}", $replace);

        return [
            Fieldset::make($t('section_stay'))->columns(2)->fields([
                Combobox::make('property')->label($t('property'))->required()->options([
                    ['value' => 'lake_house', 'label' => $t('property_lake_house'), 'description' => $t('property_lake_house_description')],
                    ['value' => 'city_loft', 'label' => $t('property_city_loft'), 'description' => $t('property_city_loft_description')],
                    ['value' => 'forest_cabin', 'label' => $t('property_forest_cabin'), 'description' => $t('property_forest_cabin_description')],
                ])->columnSpan(2),
                DatePicker::make('stay')->label($t('stay'))->range()->required()->minDate(now()->toDateString())->columnSpan(2),
                TimePicker::make('arrival')->label($t('arrival'))->minuteStep(30)->minTime('14:00')->maxTime('22:00')->clearable(),
                Slider::make('guests')->label($t('guests'))->min(1)->max(8)->default(2),
            ]),
            Fieldset::make($t('section_extras'))->columns(2)->fields([
                Radio::make('bed_setup')->label($t('bed_setup'))->options(['double' => $t('bed_double'), 'twin' => $t('bed_twin')])->buttons()->default('double'),
                CheckboxGroup::make('extras')->label($t('extras'))->options([
                    'breakfast' => $t('extra_breakfast'),
                    'pickup' => $t('extra_pickup'),
                    'late_checkout' => $t('extra_late_checkout'),
                ])->buttons(),
                Toggle::make('pets')->label($t('pets'))->onLabel($t('yes'))->offLabel($t('no')),
                TextInput::make('pet_details')->label($t('pet_details'))->placeholder($t('pet_details_placeholder'))->required()
                    ->visibleWhen('pets', 'truthy')->clearWhenHidden(),
                Textarea::make('requests')->label($t('requests'))->rows(3)->maxLength(300)->showCharacterCount()->columnSpan(2),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
