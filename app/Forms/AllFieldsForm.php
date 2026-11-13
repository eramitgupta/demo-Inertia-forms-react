<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Callout;
use Erag\InertiaForms\Fields\Checkbox;
use Erag\InertiaForms\Fields\CheckboxGroup;
use Erag\InertiaForms\Fields\ColorPicker;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\FileUpload;
use Erag\InertiaForms\Fields\Hidden;
use Erag\InertiaForms\Fields\KeyValue;
use Erag\InertiaForms\Fields\Link;
use Erag\InertiaForms\Fields\OtpInput;
use Erag\InertiaForms\Fields\Radio;
use Erag\InertiaForms\Fields\Repeater;
use Erag\InertiaForms\Fields\Slider;
use Erag\InertiaForms\Fields\Slug;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\TagsInput;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Fields\TimePicker;
use Erag\InertiaForms\Fields\Toggle;
use Erag\InertiaForms\Form;

/**
 * Every field type and its main options on one page.
 *
 * All copy comes from lang/{locale}/demo.php, so the form follows the language
 * picked in the header. The text the components add themselves (buttons,
 * placeholders, calendar names) comes from lang/{locale}/forms-ui.php.
 */
class AllFieldsForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key): string => __("demo.all_fields.{$key}");

        return [
            Fieldset::make($t('text_inputs'))->description($t('text_inputs_description'))->columns(2)->fields([
                TextInput::make('full_name')->label($t('full_name'))->required()->placeholder('Jane Doe')->clearable(),
                TextInput::make('email')->label($t('email'))->email()->placeholder('jane@example.com'),
                TextInput::make('password')->label($t('password'))->password()->minLength(8),
                TextInput::make('phone')->label($t('phone'))->tel()->placeholder('+91 98765 43210'),
                TextInput::make('website')->label($t('website'))->url()->prefix('https://'),
                TextInput::make('price')->label($t('price'))->number()->min(0)->step('0.01')->prefix('$')->suffix('USD'),
                Textarea::make('about')->label($t('about'))->rows(3)->autoResize()->maxLength(200)->showCharacterCount()->columnSpan(2),
            ]),
            Fieldset::make($t('selects'))->description($t('selects_description'))->columns(2)->fields([
                Combobox::make('plan')->label($t('plan'))->clearable()->options([
                    ['value' => 'free', 'label' => $t('plan_free'), 'description' => $t('plan_free_description')],
                    ['value' => 'pro', 'label' => $t('plan_pro'), 'description' => $t('plan_pro_description')],
                    ['value' => 'enterprise', 'label' => $t('plan_enterprise'), 'description' => $t('plan_enterprise_description')],
                ]),
                Combobox::make('country')->label($t('country'))->searchable()->clearable()->options([
                    'IN' => $t('country_in'),
                    'US' => $t('country_us'),
                    'GB' => $t('country_gb'),
                    'DE' => $t('country_de'),
                    'JP' => $t('country_jp'),
                ]),
                Combobox::make('frameworks')->label($t('frameworks'))->multiple()->searchable()->clearable()
                    ->options(['Laravel', 'Inertia', 'Vue', 'React', 'Svelte', 'Tailwind CSS'])->columnSpan(2),
                KeyValue::make('headers')->label($t('headers'))->keyLabel($t('header'))->keyPlaceholder('Accept')
                    ->valuePlaceholder('application/json')->addActionLabel($t('add_header'))->columnSpan(2),
                TagsInput::make('keywords')->label($t('keywords'))->suggestions(['laravel', 'inertia', 'forms', 'tailwind'])
                    ->maxTags(6)->reorderable()->columnSpan(2),
            ]),
            Fieldset::make($t('choices'))->description($t('choices_description'))->columns(2)->fields([
                Radio::make('shipping')->label($t('shipping'))->options([
                    ['value' => 'standard', 'label' => $t('shipping_standard'), 'description' => $t('shipping_standard_description')],
                    ['value' => 'express', 'label' => $t('shipping_express'), 'description' => $t('shipping_express_description')],
                ])->default('standard')->columns(2)->columnSpan(2),
                Radio::make('size')->label($t('size'))->options(['S', 'M', 'L', 'XL'])->buttons()->default('M'),
                Radio::make('contact_by')->label($t('contact_by'))
                    ->options(['email' => $t('contact_email'), 'phone' => $t('contact_phone'), 'none' => $t('contact_none')])->inline(),
                CheckboxGroup::make('channels')->label($t('channels'))
                    ->options(['email' => $t('channel_email'), 'sms' => $t('channel_sms'), 'push' => $t('channel_push')])->buttons(),
                CheckboxGroup::make('days')->label($t('days'))->options([
                    'mon' => $t('day_mon'),
                    'tue' => $t('day_tue'),
                    'wed' => $t('day_wed'),
                    'thu' => $t('day_thu'),
                    'fri' => $t('day_fri'),
                ])->inline(),
                Toggle::make('notifications')->label($t('notifications'))->onLabel($t('on'))->offLabel($t('off'))->default(true),
                Checkbox::make('newsletter')->label($t('newsletter')),
            ]),
            Fieldset::make($t('dates'))->description($t('dates_description'))->columns(2)->fields([
                DatePicker::make('start_date')->label($t('start_date'))->minDate(now()->toDateString())->clearable(),
                DatePicker::make('meeting_at')->label($t('meeting'))->withTime()->clearable(),
                DatePicker::make('stay')->label($t('stay'))->range()->firstDayOfWeek(1)->columnSpan(2),
                TimePicker::make('opens_at')->label($t('opens_at'))->minuteStep(15)->clearable(),
                TimePicker::make('duration')->label($t('duration'))->withSeconds()->clearable(),
            ]),
            Fieldset::make($t('colors'))->columns(2)->fields([
                ColorPicker::make('brand_color')->label($t('brand_color'))
                    ->swatches(['#4f46e5', '#0ea5e9', '#10b981', '#f59e0b', '#e11d48', '#9333ea'])
                    ->default('#7c3aed')->clearable(),
                Slider::make('volume')->label($t('volume'))->min(0)->max(100)->step(5)->suffix('%')->default(40),
                FileUpload::make('photo')->label($t('photo'))->image()->maxSize(2048),
                FileUpload::make('attachments')->label($t('attachments'))->multiple()->maxFiles(3)->accept(['pdf', 'docx'])->maxSize(4096),
            ]),
            Fieldset::make($t('links'))->description($t('links_description'))->columns(2)->fields([
                TextInput::make('page_title')->label($t('page_title'))->placeholder($t('page_title_placeholder')),
                Slug::make('page_slug')->label($t('page_slug'))->from('page_title')->prefix('example.test/'),
                Link::make('homepage')->label($t('homepage'))->placeholder('example.test'),
                OtpInput::make('pin')->label($t('pin'))->length(4)->password(),
                Repeater::make('contacts')->label($t('contacts'))->itemLabel($t('contact'))->titleFrom('name')->columns(2)->columnSpan(2)->fields([
                    TextInput::make('name')->label($t('name'))->required(),
                    TextInput::make('email')->label($t('email'))->email(),
                ]),
                Callout::make($t('callout_title'), $t('callout_body'))->info(),
            ]),
            Checkbox::make('terms')->label($t('terms'))->rule('accepted'),
            Hidden::make('source')->default('all-fields-demo'),
            Submit::make($t('submit'))->processingLabel($t('submitting')),
        ];
    }
}
