<?php

namespace App\Forms;

use Erag\InertiaForms\Fields\Composer;
use Erag\InertiaForms\Fields\Field;
use Erag\InertiaForms\Fields\Fieldset;
use Erag\InertiaForms\Fields\Text;
use Erag\InertiaForms\Form;

/**
 * A chat-style reply box: Enter sends, Shift+Enter adds a line, files can be attached.
 */
class SupportChatForm extends Form
{
    protected bool $resetOnSuccess = true;

    /**
     * @return array<int, Field|Fieldset>
     */
    public function fields(): array
    {
        $t = fn (string $key, array $replace = []): string => __("forms/support-chat.{$key}", $replace);

        return [
            Text::make($t('intro')),
            Composer::make('reply')->label($t('reply'))->required()->placeholder($t('reply_placeholder'))
                ->accept(['png', 'jpg', 'pdf'])->maxFiles(3)->maxSize(4096)->maxLength(2000)
                ->quickReplies([$t('quick_thanks'), $t('quick_screenshot'), $t('quick_fixed')]),
        ];
    }
}
