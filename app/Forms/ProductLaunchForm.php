<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\ColorPicker;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\FileUpload;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Launch a product: pricing tier, channels and a press kit when press is picked.
 */
class ProductLaunchForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/product-launch.{$key}", $replace);

        return [
            Fieldset::make($t('product'))->columns(2)->fields([
                TextInput::make('product_name')->label($t('product_name'))->required()->placeholder($t('product_name_placeholder'))->clearable(),
                TextInput::make('price')->label($t('price'))->number()->min(0)->step('0.01')->prefix('$')->required(),
                Radio::make('tier')->label($t('tier'))->options([
                    'free' => $t('tier_free'),
                    'pro' => $t('tier_pro'),
                    'enterprise' => $t('tier_enterprise'),
                ])->buttons()->default('pro'),
                DatePicker::make('launch_date')->label($t('launch_date'))->required()->minDate(now()->toDateString())->clearable(),
                Textarea::make('tagline')->label($t('tagline'))->rows(2)->maxLength(120)->showCharacterCount()->columnSpan(2),
            ]),
            Fieldset::make($t('go_to_market'))->columns(2)->fields([
                CheckboxGroup::make('channels')->label($t('channels'))->options([
                    'email' => $t('channel_email'),
                    'blog' => $t('channel_blog'),
                    'social' => $t('channel_social'),
                    'press' => $t('channel_press'),
                ])->buttons()->required()->columnSpan(2),
                FileUpload::make('press_kit')->label($t('press_kit'))->accept(['pdf', 'zip'])->maxSize(5120)
                    ->visibleWhen('channels', 'contains', 'press')->columnSpan(2),
                ColorPicker::make('brand_color')->label($t('brand_color'))->swatches(['#4f46e5', '#0ea5e9', '#10b981', '#f59e0b', '#e11d48'])->default('#4f46e5'),
                Toggle::make('announce')->label($t('announce'))->onLabel($t('yes'))->offLabel($t('no'))->default(true),
            ]),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
