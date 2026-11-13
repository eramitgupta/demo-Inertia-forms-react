import { defaultTranslations, setTranslations } from '@erag/inertia-forms-react';
import type { Translations } from '@erag/inertia-forms-react';

type LangProps = {
    locale?: unknown;
    lang?: unknown;
};

let active: string | undefined;

/**
 * Give the form components the text Laravel shared for the current language.
 *
 * Lang Sync Inertia shares lang/{locale}/forms-ui.php as `props.lang['forms-ui']`
 * (see HandleInertiaRequests). English has no file, so it uses the defaults.
 */
export function syncFormTranslations(props: LangProps): void {
    const locale = typeof props.locale === 'string' ? props.locale : 'en';

    if (locale === active) {
        return;
    }

    active = locale;

    const lang = (props.lang ?? {}) as Record<string, unknown>;
    const shared = (lang['forms-ui'] ?? {}) as Translations;

    setTranslations({ ...defaultTranslations, ...shared });
}

/**
 * The props of the first page, read before Inertia renders it so the first
 * form already shows the right language.
 */
export function initialPageProps(): LangProps {
    const script = document.querySelector(
        'script[data-page="app"][type="application/json"]',
    );

    try {
        return (JSON.parse(script?.textContent ?? '{}').props ?? {}) as LangProps;
    } catch {
        return {};
    }
}
