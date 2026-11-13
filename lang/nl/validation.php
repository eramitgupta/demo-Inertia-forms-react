<?php

// The most used validation messages. Anything missing falls back to English.

return [
    'accepted' => 'Je moet :attribute accepteren.',
    'email' => ':attribute moet een geldig e-mailadres zijn.',
    'required' => 'Het veld :attribute is verplicht.',
    'url' => ':attribute moet een geldige URL zijn.',
    'numeric' => ':attribute moet een getal zijn.',
    'in' => 'De gekozen :attribute is ongeldig.',
    'image' => ':attribute moet een afbeelding zijn.',
    'mimes' => ':attribute moet een bestand zijn van het type: :values.',
    'date' => ':attribute is geen geldige datum.',
    'after_or_equal' => ':attribute moet een datum zijn op of na :date.',
    'integer' => ':attribute moet een geheel getal zijn.',
    'digits' => ':attribute moet uit :digits cijfers bestaan.',
    'required_if' => 'Het veld :attribute is verplicht als :other :value is.',
    'between' => [
        'numeric' => ':attribute moet tussen :min en :max liggen.',
        'string' => ':attribute moet tussen :min en :max tekens bevatten.',
        'array' => ':attribute moet tussen :min en :max items bevatten.',
        'file' => ':attribute moet tussen :min en :max kilobytes zijn.',
    ],
    'min' => [
        'numeric' => ':attribute moet minstens :min zijn.',
        'string' => ':attribute moet minstens :min tekens bevatten.',
        'array' => ':attribute moet minstens :min items bevatten.',
        'file' => ':attribute moet minstens :min kilobytes zijn.',
    ],
    'max' => [
        'numeric' => ':attribute mag niet groter zijn dan :max.',
        'string' => ':attribute mag niet meer dan :max tekens bevatten.',
        'array' => ':attribute mag niet meer dan :max items bevatten.',
        'file' => ':attribute mag niet groter zijn dan :max kilobytes.',
    ],
];
