<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('switches the language and keeps it in the session', function () {
    $this->actingAs(User::factory()->create())
        ->from(route('forms-demo.create', 'all-fields'))
        ->post(route('locale.update'), ['locale' => 'nl'])
        ->assertRedirect(route('forms-demo.create', 'all-fields'))
        ->assertSessionHas('locale', 'nl');
});

it('rejects a language that is not offered', function () {
    $this->post(route('locale.update'), ['locale' => 'xx'])
        ->assertSessionHasErrors('locale')
        ->assertSessionMissing('locale');
});

it('renders the form, page text and component text in the picked language', function () {
    $this->actingAs(User::factory()->create())
        ->withSession(['locale' => 'hi'])
        ->get(route('forms-demo.create', 'all-fields'))
        ->assertInertia(fn (Assert $page) => $page
            ->where('locale', 'hi')
            ->where('locales.nl', 'Nederlands')
            ->where('label', 'सभी फ़ील्ड')
            ->where('form.fieldsets.0.legend', 'टेक्स्ट इनपुट')
            ->where('form.fieldsets.0.fields.0.label', 'पूरा नाम')
            ->where('lang.forms-ui.option_placeholder', 'कोई विकल्प चुनें')
            ->where('lang.demo.page.back', 'वापस'));
});

it('shows validation messages in the picked language', function () {
    $this->actingAs(User::factory()->create())
        ->withSession(['locale' => 'nl'])
        ->post(route('forms-demo.store', 'all-fields'), [])
        ->assertSessionHasErrors(['full_name' => 'Het veld Volledige naam is verplicht.']);
});

it('uses English without a picked language', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('forms-demo.create', 'all-fields'))
        ->assertInertia(fn (Assert $page) => $page
            ->where('locale', 'en')
            ->where('form.fieldsets.0.fields.0.label', 'Full name')
            ->where('lang.forms-ui', []));
});
