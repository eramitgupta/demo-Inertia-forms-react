<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Callout;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\OtpInput;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slug;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * A three-step wizard: each fieldset is a step, checked on the server before moving on.
 */
class OnboardingWizardForm extends Form
{
    protected bool $wizard = true;

    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/onboarding-wizard.{$key}", $replace);

        return [
            Fieldset::make($t('account'))->description($t('account_description'))->icon('user')->fields([
                TextInput::make('name')->label($t('name'))->required()->placeholder('Jane Example'),
                TextInput::make('email')->label($t('email'))->email()->required()->placeholder('jane@example.test'),
                TextInput::make('password')->label($t('password'))->password()->required()->minLength(8),
            ]),
            Fieldset::make($t('workspace'))->description($t('workspace_description'))->icon('briefcase')->columns(2)->fields([
                TextInput::make('workspace')->label($t('workspace_name'))->required()->placeholder('Acme Studio'),
                Slug::make('workspace_url')->label($t('workspace_url'))->from('workspace')->prefix('app.example.test/')->required(),
                Radio::make('team_size')->label($t('team_size'))->options(['1' => $t('team_size_solo'), '2-10' => '2–10', '11-50' => '11–50', '50+' => '50+'])
                    ->buttons()->default('2-10')->columnSpan(2),
            ]),
            Fieldset::make($t('verify'))->description($t('verify_description'))->icon('shield')->fields([
                Callout::make($t('callout_title'), $t('callout_body'))->info(),
                OtpInput::make('code')->label($t('code'))->length(6)->groupSize(3)->required()
                    ->rule('in:123456'),
            ]),
            Submit::make($t('submit'))->icon('check')->processingLabel($t('submitting')),
        ];
    }

    public function messages(): array
    {
        return ['code.in' => __('forms/onboarding-wizard.code_invalid')];
    }
}
