<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\ColorPicker;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * Plan a marketing campaign: audiences, flight dates, channels and UTM tags.
 */
class CampaignPlanForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/campaign-plan.{$key}", $replace);

        return [
            Fieldset::make($t('section_campaign'))->columns(2)->fields([
                TextInput::make('campaign_name')->label($t('campaign_name'))->required()->placeholder($t('campaign_name_placeholder'))->clearable(),
                Radio::make('goal')->label($t('goal'))->options([
                    'awareness' => $t('goal_awareness'),
                    'leads' => $t('goal_leads'),
                    'sales' => $t('goal_sales'),
                ])->buttons()->default('leads'),
                Combobox::make('audiences')->label($t('audiences'))->multiple()->searchable()->clearable()->required()
                    ->options([
                        'New visitors' => $t('audience_new_visitors'),
                        'Returning customers' => $t('audience_returning_customers'),
                        'Newsletter subscribers' => $t('audience_newsletter_subscribers'),
                        'Trial users' => $t('audience_trial_users'),
                        'Churned users' => $t('audience_churned_users'),
                    ])->columnSpan(2),
                DatePicker::make('flight')->label($t('flight'))->range()->required()->columnSpan(2),
            ]),
            Fieldset::make($t('section_budget'))->columns(2)->fields([
                TextInput::make('budget')->label($t('budget'))->number()->min(0)->prefix('$')->suffix('USD')->required(),
                Slider::make('daily_cap')->label($t('daily_cap'))->min(0)->max(100)->step(5)->suffix('%')->default(25),
                CheckboxGroup::make('channels')->label($t('channels'))->options([
                    'search' => $t('channel_search'),
                    'social' => $t('channel_social'),
                    'display' => $t('channel_display'),
                    'email' => $t('channel_email'),
                    'video' => $t('channel_video'),
                ])->buttons()->columnSpan(2),
                TagsInput::make('utm_tags')->label($t('utm_tags'))->suggestions(['autumn', 'sale', 'retargeting', 'brand'])
                    ->maxTags(6)->columnSpan(2),
                ColorPicker::make('creative_color')->label($t('creative_color'))->swatches(['#e11d48', '#f59e0b', '#10b981', '#0ea5e9', '#7c3aed'])->default('#e11d48'),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
