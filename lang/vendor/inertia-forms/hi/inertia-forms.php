<?php

return [
    'fields' => [
        'blocks' => [
            'type_attribute' => ':label ब्लॉक का प्रकार',
            'item_field_attribute' => ':field (:block :position)',
        ],
        'repeater' => [
            'item' => 'आइटम',
        ],
        'combobox' => [
            'invalid' => 'चुना गया :attribute सही नहीं है।',
        ],
        'composer' => [
            'required' => 'कोई संदेश लिखें या फ़ाइल जोड़ें।',
            'attachments_attribute' => ':label के अटैचमेंट',
            'attachment_attribute' => ':label का अटैचमेंट',
        ],
        'key_value' => [
            'key' => 'कुंजी',
            'value' => 'मान',
            'cell_attribute' => ':label :column (पंक्ति :position)',
            'required' => ':attribute में कम से कम एक प्रविष्टि होनी चाहिए।',
            'key_required_with' => 'मान भरने पर :attribute भरना ज़रूरी है।',
            'key_distinct' => ':attribute एक से ज़्यादा बार इस्तेमाल हुआ है।',
        ],
        'link' => [
            'scheme_required' => ':attribute :scheme से शुरू होना चाहिए।',
            'scheme_not_allowed' => ':attribute में :schemes होना चाहिए।',
            'scheme_separator' => ' या ',
            'invalid' => ':attribute एक सही URL होना चाहिए।',
            'label_attribute' => ':label का टेक्स्ट',
            'target_attribute' => ':label कहाँ खुले',
        ],
        'otp' => [
            'size' => ':attribute :length अक्षरों का होना चाहिए।',
            'alphanumeric' => ':attribute में सिर्फ़ अक्षर और अंक हो सकते हैं।',
            'numeric' => ':attribute में सिर्फ़ अंक हो सकते हैं।',
        ],
        'slug' => [
            'format_lowercase_dashes' => ':attribute में सिर्फ़ छोटे अक्षर, अंक और एक-एक डैश हो सकते हैं।',
            'format_lowercase_underscores' => ':attribute में सिर्फ़ छोटे अक्षर, अंक और एक-एक अंडरस्कोर हो सकते हैं।',
            'format_dashes' => ':attribute में सिर्फ़ अक्षर, अंक और एक-एक डैश हो सकते हैं।',
            'format_underscores' => ':attribute में सिर्फ़ अक्षर, अंक और एक-एक अंडरस्कोर हो सकते हैं।',
        ],
    ],
];
