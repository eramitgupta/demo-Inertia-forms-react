<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Checkbox;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\KeyValue;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Choose a plan: EU countries ask for a VAT number.
 */
class SubscriptionBillingForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/subscription-billing.{$key}", $replace);

        return [
            Fieldset::make($t('section_plan'))->columns(2)->fields([
                Radio::make('plan')->label($t('plan'))->options([
                    ['value' => 'starter', 'label' => $t('plan_starter'), 'description' => $t('plan_starter_description')],
                    ['value' => 'growth', 'label' => $t('plan_growth'), 'description' => $t('plan_growth_description')],
                    ['value' => 'scale', 'label' => $t('plan_scale'), 'description' => $t('plan_scale_description')],
                ])->default('growth')->columns(3)->columnSpan(2),
                Radio::make('cycle')->label($t('cycle'))->options(['monthly' => $t('cycle_monthly'), 'yearly' => $t('cycle_yearly')])
                    ->buttons()->default('yearly')->help($t('cycle_help')),
                Slider::make('seats')->label($t('seats'))->min(1)->max(100)->default(5),
                TextInput::make('coupon')->label($t('coupon'))->placeholder('LAUNCH20')->clearable(),
            ]),
            Fieldset::make($t('section_billing_details'))->columns(2)->fields([
                TextInput::make('billing_email')->label($t('billing_email'))->email()->required(),
                Combobox::make('country')->label($t('country'))->searchable()->required()->options([
                    'IN' => $t('country_in'),
                    'US' => $t('country_us'),
                    'GB' => $t('country_gb'),
                    'DE' => $t('country_de'),
                    'FR' => $t('country_fr'),
                    'NL' => $t('country_nl'),
                ]),
                TextInput::make('vat_number')->label($t('vat_number'))->required()->placeholder('DE123456789')
                    ->visibleWhen('country', 'in', ['DE', 'FR', 'NL'])->clearWhenHidden()->columnSpan(2),
                KeyValue::make('invoice_metadata')->label($t('invoice_metadata'))->keyPlaceholder('region')->valuePlaceholder('EMEA')
                    ->addActionLabel($t('add_metadata'))->maxItems(8)->default(['region' => 'EMEA', 'cost_center' => 'OPS-204'])
                    ->help($t('invoice_metadata_help'))->columnSpan(2),
                Toggle::make('auto_renew')->label($t('auto_renew'))->onLabel($t('on'))->offLabel($t('off'))->default(true),
                Checkbox::make('terms')->label($t('terms'))->rule('accepted'),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
