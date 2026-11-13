<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Block;
use Erag\InertiaForms\Fields\Blocks;
use Erag\InertiaForms\Fields\Callout;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Heading;
use Erag\InertiaForms\Fields\Link;
use Erag\InertiaForms\Fields\Repeater;
use Erag\InertiaForms\Fields\Separator;
use Erag\InertiaForms\Fields\Slug;
use Erag\InertiaForms\Fields\Submit;
use Erag\InertiaForms\Fields\Text;
use Erag\InertiaForms\Fields\Textarea;
use Erag\InertiaForms\Fields\TextInput;
use Erag\InertiaForms\Form;

/**
 * A landing page editor: blocks, a repeater, links, display helpers
 * and two submit actions (save draft / publish).
 */
class LandingPageForm extends Form
{
    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/landing-page.{$key}", $replace);

        return [
            Fieldset::make($t('page'))->columns(2)->fields([
                Heading::make($t('page_details'))->level(3),
                Text::make($t('page_details_text')),
                TextInput::make('title')->label($t('title'))->required()->placeholder($t('title_placeholder')),
                Slug::make('slug')->label($t('slug'))->from('title')->prefix('example.test/')->required(),
                Link::make('cta')->label($t('cta'))->withLabel(placeholder: $t('cta_placeholder'))->withTarget()
                    ->requireScheme()->allowedSchemes('https')->columnSpan(2),
                Textarea::make('intro')->label($t('intro'))->rows(4)->autoResize()->maxLength(600)->showCharacterCount()->columnSpan(2),
            ]),
            Fieldset::make($t('content'))->fields([
                Blocks::make('sections')->label($t('sections'))->addActionLabel($t('add_section'))->blocks([
                    Block::make('hero')->label($t('hero'))->description($t('hero_description'))->titleFrom('headline')->fields([
                        TextInput::make('headline')->label($t('headline'))->required(),
                        Textarea::make('summary')->label($t('summary'))->rows(3),
                    ]),
                    Block::make('quote')->label($t('quote'))->description($t('quote_description'))->icon('Q')->columns(2)->fields([
                        Textarea::make('quote')->label($t('quote'))->required()->columnSpan(2),
                        TextInput::make('author')->label($t('author'))->required(),
                        TextInput::make('company')->label($t('company')),
                    ]),
                ])->default([['type' => 'hero', 'data' => ['headline' => $t('default_headline'), 'summary' => $t('default_summary')]]]),
                Separator::make()->spacing('sm'),
                Repeater::make('faq')->label($t('faq'))->itemLabel($t('question'))->titleFrom('question')->maxItems(8)->fields([
                    TextInput::make('question')->label($t('question'))->required(),
                    Textarea::make('answer')->label($t('answer'))->rows(2)->required(),
                ])->default([['question' => $t('default_question'), 'answer' => $t('default_answer')]]),
                Callout::make($t('callout_title'), $t('callout_body'))->warning(),
            ]),
            Submit::make($t('save_draft'))->secondary()->intent('draft'),
            Submit::make($t('publish'))->icon('send', 'right')->intent('publish')->processingLabel($t('publishing')),
        ];
    }
}
