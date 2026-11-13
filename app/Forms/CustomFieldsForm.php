<?php

namespace App\Forms;

use App\Forms\Fields\CodeInput;
use App\Forms\Fields\QuantityStepper;
use App\Forms\Fields\Rating;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * Three custom fields (Rating, CodeInput, QuantityStepper) mixed with built-in ones.
 */
class CustomFieldsForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/custom-fields.{$key}", $replace);

        return [
            Fieldset::make($t('order'))->description($t('order_description'))->columns(2)->fields([
                Radio::make('ticket')->label($t('ticket'))->options([
                    ['value' => 'standard', 'label' => $t('ticket_standard'), 'description' => $t('ticket_standard_description')],
                    ['value' => 'vip', 'label' => $t('ticket_vip'), 'description' => $t('ticket_vip_description')],
                ])->default('standard')->columns(2)->columnSpan(2),
                QuantityStepper::make('tickets')->label($t('tickets'))->min(1)->max(10)->unit($t('tickets_unit'))->default(2)->required(),
                QuantityStepper::make('parking')->label($t('parking'))->min(0)->max(4)->unit($t('parking_unit')),
            ]),
            Fieldset::make($t('verify'))->description($t('verify_description'))->fields([
                TextInput::make('email')->label($t('email'))->email()->required()->placeholder('jane@example.com'),
                CodeInput::make('code')->label($t('code'))->length(6)->required()
                    ->help($t('code_help')),
            ]),
            Fieldset::make($t('feedback'))->description($t('feedback_description'))->fields([
                Rating::make('rating')->label($t('rating'))->stars(5)->required(),
                Textarea::make('comment')->label($t('comment'))->rows(3)->maxLength(200)->showCharacterCount()
                    ->visibleWhen('rating', '<=', 3)->help($t('comment_help')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
