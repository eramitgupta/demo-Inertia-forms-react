<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\FileUpload;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * Kick off a client project: business details only show up for business clients.
 */
class ProjectKickoffForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/project-kickoff.{$key}", $replace);

        return [
            Fieldset::make($t('project'))->columns(2)->fields([
                TextInput::make('project_name')->label($t('project_name'))->required()->maxLength(80)->placeholder($t('project_name_placeholder')),
                TextInput::make('contact_email')->label($t('contact_email'))->email()->required(),
                Combobox::make('client_type')->label($t('client_type'))->options([
                    'personal' => $t('client_personal'),
                    'business' => $t('client_business'),
                ])->default('personal'),
                TextInput::make('company')->label($t('company'))->required()->visibleWhen('client_type', 'business')->clearWhenHidden(),
                TextInput::make('budget')->label($t('budget'))->number()->min(100)->prefix('$'),
                DatePicker::make('deadline')->label($t('deadline'))->minDate(now()->toDateString())->clearable(),
            ]),
            Fieldset::make($t('scope'))->fields([
                Radio::make('priority')->label($t('priority'))->options([
                    ['value' => 'low', 'label' => $t('priority_low'), 'description' => $t('priority_low_description')],
                    ['value' => 'high', 'label' => $t('priority_high'), 'description' => $t('priority_high_description')],
                ])->default('low')->columns(2),
                Combobox::make('stack')->label($t('stack'))->multiple()->searchable()->clearable()
                    ->options(['Laravel', 'Inertia', 'React', 'Vue', 'Svelte', 'Tailwind CSS']),
                CheckboxGroup::make('services')->label($t('services'))->options([
                    'design' => $t('service_design'),
                    'build' => $t('service_build'),
                    'hosting' => $t('service_hosting'),
                ])->buttons(),
                FileUpload::make('brief')->label($t('brief'))->accept(['pdf', 'docx'])->maxSize(2048)->help($t('brief_help')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
