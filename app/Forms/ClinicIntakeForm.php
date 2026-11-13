<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Checkbox;
use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Patient intake: insurance details appear only when the patient is insured.
 */
class ClinicIntakeForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/clinic-intake.{$key}", $replace);

        return [
            Fieldset::make($t('section_patient'))->columns(2)->fields([
                TextInput::make('patient_name')->label($t('patient_name'))->required()->placeholder('Jane Doe'),
                DatePicker::make('birthday')->label($t('birthday'))->required()->maxDate(today()->toDateString()),
                TextInput::make('phone')->label($t('phone'))->tel()->required(),
                Combobox::make('reason')->label($t('reason'))->required()->options([
                    ['value' => 'checkup', 'label' => $t('reason_checkup'), 'description' => $t('reason_checkup_description')],
                    ['value' => 'follow_up', 'label' => $t('reason_follow_up'), 'description' => $t('reason_follow_up_description')],
                    ['value' => 'new_issue', 'label' => $t('reason_new_issue'), 'description' => $t('reason_new_issue_description')],
                ]),
            ]),
            Fieldset::make($t('section_symptoms'))->columns(2)->fields([
                CheckboxGroup::make('symptoms')->label($t('symptoms'))->options([
                    'fever' => $t('symptom_fever'),
                    'cough' => $t('symptom_cough'),
                    'headache' => $t('symptom_headache'),
                    'fatigue' => $t('symptom_fatigue'),
                    'nausea' => $t('symptom_nausea'),
                ])->inline()->columnSpan(2),
                Slider::make('pain_level')->label($t('pain_level'))->min(0)->max(10)->default(0)->columnSpan(2),
                TagsInput::make('allergies')->label($t('allergies'))->suggestions([
                    $t('allergy_penicillin'),
                    $t('allergy_peanuts'),
                    $t('allergy_latex'),
                    $t('allergy_pollen'),
                ])->columnSpan(2),
                DatePicker::make('appointment_at')->label($t('appointment_at'))->withTime()->minDate(now()->toDateString())->clearable(),
                Toggle::make('insured')->label($t('insured'))->onLabel($t('yes'))->offLabel($t('no')),
                TextInput::make('insurance_number')->label($t('insurance_number'))->required()->visibleWhen('insured', 'truthy')->clearWhenHidden()->columnSpan(2),
            ]),
            Checkbox::make('consent')->label($t('consent'))->rule('accepted'),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
