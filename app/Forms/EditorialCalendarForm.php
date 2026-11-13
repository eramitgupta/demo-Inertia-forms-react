<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Block;
use Erag\InertiaForms\Fields\Blocks;
use Erag\InertiaForms\Fields\ColorPicker;
use Erag\InertiaForms\Fields\Combobox;
use Erag\InertiaForms\Fields\DatePicker;
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
 * Schedule an article: the publish time is only needed once it is scheduled.
 */
class EditorialCalendarForm extends Form
{
    /**
     * Demo authors. In an app this would be a query, e.g.
     * `User::where('name', 'like', "%{$search}%")->limit(20)->get()`.
     *
     * @var array<int, array{id: int, name: string, email: string}>
     */
    public const AUTHORS = [
        ['id' => 1, 'name' => 'Avery Stone', 'email' => 'avery@example.test'],
        ['id' => 2, 'name' => 'Rowan Example', 'email' => 'rowan@example.test'],
        ['id' => 3, 'name' => 'Morgan Vale', 'email' => 'morgan@example.test'],
        ['id' => 4, 'name' => 'Casey Example', 'email' => 'casey@example.test'],
        ['id' => 5, 'name' => 'Skyler Example', 'email' => 'skyler@example.test'],
        ['id' => 6, 'name' => 'Aisha Khan', 'email' => 'aisha@example.test'],
        ['id' => 7, 'name' => 'Ben Carter', 'email' => 'ben@example.test'],
        ['id' => 8, 'name' => 'Chen Wei', 'email' => 'chen@example.test'],
        ['id' => 9, 'name' => 'Diego Ruiz', 'email' => 'diego@example.test'],
        ['id' => 10, 'name' => 'Emma Novak', 'email' => 'emma@example.test'],
    ];

    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/editorial-calendar.{$key}", $replace);

        return [
            Fieldset::make($t('article'))->columns(2)->fields([
                TextInput::make('headline')->label($t('headline'))->required()->maxLength(90)->placeholder($t('headline_placeholder'))->columnSpan(2),
                Combobox::make('author')->label($t('author'))->required()->clearable()->placeholder($t('author_placeholder'))
                    ->searchUsing(fn (string $search): array => $this->authorOptions(
                        fn (array $author): bool => $search === '' || str_contains(strtolower($author['name'].' '.$author['email']), strtolower($search)),
                    ))
                    ->selectedOptionsUsing(fn (array $ids): array => $this->authorOptions(
                        fn (array $author): bool => in_array((string) $author['id'], array_map('strval', $ids), true),
                    )),
                Radio::make('section')->label($t('section'))->options(['news' => $t('section_news'), 'guides' => $t('section_guides'), 'opinion' => $t('section_opinion')])->buttons()->default('guides'),
                Textarea::make('summary')->label($t('summary'))->rows(3)->autoResize()->maxLength(200)->showCharacterCount()->columnSpan(2),
            ]),
            Fieldset::make($t('body'))->fields([
                Blocks::make('body')->label($t('body_outline'))->addActionLabel($t('add_block'))->maxItems(12)
                    ->blocks([
                        Block::make('section')->label($t('block_section'))->description($t('block_section_description'))->titleFrom('heading')->fields([
                            TextInput::make('heading')->label($t('heading'))->required()->maxLength(90),
                            Textarea::make('summary')->label($t('summary'))->rows(2)->autoResize(),
                        ]),
                        Block::make('quote')->label($t('block_quote'))->description($t('block_quote_description'))->icon('Q')->columns(2)->fields([
                            Textarea::make('text')->label($t('quote'))->required()->rows(2)->columnSpan(2),
                            TextInput::make('author')->label($t('author'))->required(),
                            TextInput::make('source')->label($t('source'))->placeholder($t('source_placeholder')),
                        ]),
                        Block::make('image')->label($t('block_image'))->description($t('block_image_description'))->icon('I')->fields([
                            FileUpload::make('file')->label($t('file'))->image()->maxSize(3072),
                            TextInput::make('caption')->label($t('caption')),
                        ]),
                    ])
                    ->default([
                        ['type' => 'section', 'data' => ['heading' => $t('default_heading')]],
                        ['type' => 'quote', 'data' => ['text' => $t('default_quote'), 'author' => 'Aisha Khan']],
                    ]),
            ]),
            Fieldset::make($t('publishing'))->columns(2)->fields([
                Combobox::make('status')->label($t('status'))->options([
                    ['value' => 'draft', 'label' => $t('status_draft'), 'description' => $t('status_draft_description')],
                    ['value' => 'review', 'label' => $t('status_review'), 'description' => $t('status_review_description')],
                    ['value' => 'scheduled', 'label' => $t('status_scheduled'), 'description' => $t('status_scheduled_description')],
                ])->default('draft'),
                DatePicker::make('publish_at')->label($t('publish_at'))->withTime()->required()->minDate(now()->toDateString())
                    ->visibleWhen('status', 'scheduled')->clearWhenHidden(),
                TagsInput::make('tags')->label($t('tags'))->suggestions(['laravel', 'inertia', $t('tag_tutorial'), $t('tag_release')])->reorderable()->maxTags(5)->columnSpan(2),
                FileUpload::make('cover_image')->label($t('cover_image'))->image()->maxSize(3072),
                ColorPicker::make('accent')->label($t('accent'))->swatches(['#4f46e5', '#0f766e', '#b45309', '#be123c'])->default('#0f766e'),
                Slider::make('word_target')->label($t('word_target'))->min(300)->max(3000)->step(100)->default(1200)->columnSpan(2),
                Toggle::make('featured')->label($t('featured'))->onLabel($t('yes'))->offLabel($t('no')),
            ]),
            Submit::make($t('submit'))->processingLabel($t('saving')),
        ];
    }

    /**
     * Authors matching the filter, as select options with the email as description.
     *
     * @param  callable(array{id: int, name: string, email: string}): bool  $filter
     * @return array<int, array{value: int, label: string, description: string}>
     */
    protected function authorOptions(callable $filter): array
    {
        return array_values(array_map(
            fn (array $author): array => ['value' => $author['id'], 'label' => $author['name'], 'description' => $author['email']],
            array_filter(self::AUTHORS, $filter),
        ));
    }
}
