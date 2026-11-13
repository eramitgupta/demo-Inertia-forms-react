<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * Open a role: office location only matters when the role is not remote.
 */
class HiringPipelineForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/hiring-pipeline.{$key}", $replace);

        return [
            Fieldset::make($t('section_role'))->columns(2)->fields([
                TextInput::make('role_title')->label($t('role_title'))->required()->placeholder($t('role_title_placeholder')),
                Combobox::make('department')->label($t('department'))->required()->options([
                    'Engineering' => $t('department_engineering'),
                    'Design' => $t('department_design'),
                    'Product' => $t('department_product'),
                    'Marketing' => $t('department_marketing'),
                    'Support' => $t('department_support'),
                ]),
                Radio::make('employment')->label($t('employment'))->options([
                    'full_time' => $t('employment_full_time'),
                    'part_time' => $t('employment_part_time'),
                    'contract' => $t('employment_contract'),
                ])->buttons()->default('full_time')->columnSpan(2),
                TextInput::make('salary_min')->label($t('salary_min'))->number()->min(0)->prefix('$')->suffix($t('per_year')),
                TextInput::make('salary_max')->label($t('salary_max'))->number()->min(0)->prefix('$')->suffix($t('per_year')),
            ]),
            Fieldset::make($t('section_location'))->columns(2)->fields([
                Radio::make('workplace')->label($t('workplace'))->options([
                    ['value' => 'remote', 'label' => $t('workplace_remote'), 'description' => $t('workplace_remote_description')],
                    ['value' => 'hybrid', 'label' => $t('workplace_hybrid'), 'description' => $t('workplace_hybrid_description')],
                    ['value' => 'onsite', 'label' => $t('workplace_onsite'), 'description' => $t('workplace_onsite_description')],
                ])->default('remote')->columns(3)->columnSpan(2),
                Combobox::make('office')->label($t('office'))->required()->searchable()->options([
                    'Bengaluru' => $t('office_bengaluru'),
                    'Berlin' => $t('office_berlin'),
                    'London' => $t('office_london'),
                    'New York' => $t('office_new_york'),
                    'Singapore' => $t('office_singapore'),
                ])->visibleWhen('workplace', '!=', 'remote')->clearWhenHidden(),
                DatePicker::make('start_date')->label($t('start_date'))->minDate(now()->toDateString())->clearable(),
            ]),
            Fieldset::make($t('section_pipeline'))->fields([
                Combobox::make('skills')->label($t('skills'))->multiple()->searchable()->clearable()->options([
                    'PHP' => 'PHP',
                    'Laravel' => 'Laravel',
                    'Inertia' => 'Inertia',
                    'React' => 'React',
                    'Vue' => 'Vue',
                    'SQL' => 'SQL',
                    'Testing' => $t('skill_testing'),
                    'AWS' => 'AWS',
                ]),
                TagsInput::make('stages')->label($t('stages'))->reorderable()->default(['Screening', 'Technical interview', 'Team interview', 'Offer'])
                    ->help($t('stages_help')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
