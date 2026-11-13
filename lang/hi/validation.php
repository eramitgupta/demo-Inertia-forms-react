<?php

// The most used validation messages. Anything missing falls back to English.

return [
    'accepted' => ':attribute स्वीकार करना ज़रूरी है।',
    'email' => ':attribute एक सही ईमेल पता होना चाहिए।',
    'required' => ':attribute भरना ज़रूरी है।',
    'url' => ':attribute एक सही URL होना चाहिए।',
    'numeric' => ':attribute एक संख्या होनी चाहिए।',
    'in' => 'चुना गया :attribute सही नहीं है।',
    'image' => ':attribute एक तस्वीर होनी चाहिए।',
    'mimes' => ':attribute इनमें से किसी प्रकार की फ़ाइल होनी चाहिए: :values।',
    'date' => ':attribute सही तारीख़ नहीं है।',
    'after_or_equal' => ':attribute, :date या उसके बाद की तारीख़ होनी चाहिए।',
    'integer' => ':attribute पूरी संख्या होनी चाहिए।',
    'digits' => ':attribute में :digits अंक होने चाहिए।',
    'required_if' => 'जब :other :value हो, तब :attribute भरना ज़रूरी है।',
    'between' => [
        'numeric' => ':attribute :min और :max के बीच होना चाहिए।',
        'string' => ':attribute में :min से :max अक्षर होने चाहिए।',
        'array' => ':attribute में :min से :max आइटम होने चाहिए।',
        'file' => ':attribute :min से :max किलोबाइट के बीच होनी चाहिए।',
    ],
    'min' => [
        'numeric' => ':attribute कम से कम :min होना चाहिए।',
        'string' => ':attribute में कम से कम :min अक्षर होने चाहिए।',
        'array' => ':attribute में कम से कम :min आइटम होने चाहिए।',
        'file' => ':attribute कम से कम :min किलोबाइट होनी चाहिए।',
    ],
    'max' => [
        'numeric' => ':attribute :max से ज़्यादा नहीं हो सकता।',
        'string' => ':attribute में :max से ज़्यादा अक्षर नहीं हो सकते।',
        'array' => ':attribute में :max से ज़्यादा आइटम नहीं हो सकते।',
        'file' => ':attribute :max किलोबाइट से बड़ी नहीं हो सकती।',
    ],
];
