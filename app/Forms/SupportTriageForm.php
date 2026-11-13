<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\FileUpload;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Triage a support ticket: critical issues ask for an on-call phone number.
 */
class SupportTriageForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/support-triage.{$key}", $replace);

        return [
            Fieldset::make($t('ticket'))->columns(2)->fields([
                TextInput::make('requester_email')->label($t('requester_email'))->email()->required()->placeholder('customer@example.com'),
                Combobox::make('area')->label($t('area'))->required()->clearable()->options([
                    ['value' => 'billing', 'label' => $t('area_billing'), 'description' => $t('area_billing_description')],
                    ['value' => 'auth', 'label' => $t('area_auth'), 'description' => $t('area_auth_description')],
                    ['value' => 'api', 'label' => $t('area_api'), 'description' => $t('area_api_description')],
                    ['value' => 'other', 'label' => $t('area_other'), 'description' => $t('area_other_description')],
                ]),
                Radio::make('severity')->label($t('severity'))->options([
                    'low' => $t('severity_low'),
                    'medium' => $t('severity_medium'),
                    'high' => $t('severity_high'),
                    'critical' => $t('severity_critical'),
                ])->buttons()->default('medium')->columnSpan(2),
                TextInput::make('on_call_phone')->label($t('on_call_phone'))->tel()->required()->placeholder('+91 98765 43210')
                    ->visibleWhen('severity', 'critical')->clearWhenHidden()->columnSpan(2),
                Slider::make('affected_users')->label($t('affected_users'))->min(1)->max(500)->step(1)->default(10)->columnSpan(2),
            ]),
            Fieldset::make($t('details'))->fields([
                Textarea::make('steps')->label($t('steps'))->required()->rows(4)->autoResize(),
                TagsInput::make('labels')->label($t('labels'))->suggestions([
                    $t('label_bug'),
                    $t('label_regression'),
                    $t('label_billing'),
                    $t('label_login'),
                    $t('label_performance'),
                ])->maxTags(5),
                FileUpload::make('screenshots')->label($t('screenshots'))->image()->multiple()->maxFiles(3)->maxSize(2048),
                Toggle::make('escalate')->label($t('escalate'))->onLabel($t('yes'))->offLabel($t('no')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
