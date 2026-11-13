import { router, usePage } from '@inertiajs/react';
import { Check, Languages } from 'lucide-react';
import { Button } from '@/components/ui/button';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { update } from '@/routes/locale';

/**
 * Pick the app language. Laravel stores it in the session and reloads the
 * page props, so labels, form text and messages all switch together.
 */
export function LanguageSwitcher() {
    const { locale, locales } = usePage().props;

    function choose(code: string): void {
        if (code === locale) {
            return;
        }

        router.post(
            update.url(),
            { locale: code },
            { preserveScroll: true, preserveState: true },
        );
    }

    return (
        <DropdownMenu>
            <DropdownMenuTrigger asChild>
                <Button variant="ghost" size="sm" className="gap-2">
                    <Languages className="size-4" />
                    <span>{locales[locale] ?? locale}</span>
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                {Object.entries(locales).map(([code, name]) => (
                    <DropdownMenuItem
                        key={code}
                        onSelect={() => choose(code)}
                        className="justify-between gap-4"
                    >
                        {name}
                        {code === locale && <Check className="size-4" />}
                    </DropdownMenuItem>
                ))}
            </DropdownMenuContent>
        </DropdownMenu>
    );
}
