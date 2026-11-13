<?php

return [

    'fields' => [

        'blocks' => [
            'type_attribute' => 'bloktype van :label',
            'item_field_attribute' => ':field (:block :position)',
        ],

        'repeater' => [
            'item' => 'Item',
        ],

        'combobox' => [
            'invalid' => 'De gekozen :attribute is ongeldig.',
        ],

        'composer' => [
            'required' => 'Schrijf een bericht of voeg een bestand toe.',
            'attachments_attribute' => 'bijlagen van :label',
            'attachment_attribute' => 'bijlage van :label',
        ],

        'key_value' => [
            'key' => 'Sleutel',
            'value' => 'Waarde',
            'cell_attribute' => ':label :column (rij :position)',
            'required' => 'Het veld :attribute heeft minstens één item nodig.',
            'key_required_with' => 'Het veld :attribute is verplicht als er een waarde is ingevuld.',
            'key_distinct' => ':attribute wordt meer dan één keer gebruikt.',
        ],

        'link' => [
            'scheme_required' => ':attribute moet beginnen met :scheme.',
            'scheme_not_allowed' => ':attribute moet :schemes gebruiken.',
            'scheme_separator' => ' of ',
            'invalid' => ':attribute moet een geldige URL zijn.',
            'label_attribute' => 'tekst van :label',
            'target_attribute' => 'doel van :label',
        ],

        'otp' => [
            'size' => ':attribute moet :length tekens zijn.',
            'alphanumeric' => ':attribute mag alleen letters en cijfers bevatten.',
            'numeric' => ':attribute mag alleen cijfers bevatten.',
        ],

        'slug' => [
            'format_lowercase_dashes' => ':attribute mag alleen kleine letters, cijfers en enkele streepjes bevatten.',
            'format_lowercase_underscores' => ':attribute mag alleen kleine letters, cijfers en enkele underscores bevatten.',
            'format_dashes' => ':attribute mag alleen letters, cijfers en enkele streepjes bevatten.',
            'format_underscores' => ':attribute mag alleen letters, cijfers en enkele underscores bevatten.',
        ],

    ],

];
