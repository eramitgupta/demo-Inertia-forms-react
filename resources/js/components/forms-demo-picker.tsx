import { Link } from '@inertiajs/react';
import {
    Briefcase,
    CalendarDays,
    CreditCard,
    House,
    LayoutList,
    LayoutTemplate,
    LifeBuoy,
    Megaphone,
    MessagesSquare,
    Newspaper,
    Palette,
    Puzzle,
    Rocket,
    Shapes,
    Stethoscope,
    Target,
    Users,
    type LucideIcon,
} from 'lucide-react';
import { useSyncExternalStore } from 'react';
import { cn } from '@/lib/utils';
import { index } from '@/routes/forms-demo';

/**
 * Accent colors offered by the demo picker.
 */
export const accents = [
    { name: 'Indigo', value: '#4f46e5' },
    { name: 'Sky', value: '#0284c7' },
    { name: 'Emerald', value: '#059669' },
    { name: 'Amber', value: '#d97706' },
    { name: 'Rose', value: '#e11d48' },
    { name: 'Violet', value: '#7c3aed' },
];

/**
 * Icon shown next to each demo in the picker.
 */
const demoIcons: Record<string, LucideIcon> = {
    'all-fields': LayoutList,
    'custom-fields': Puzzle,
    'onboarding-wizard': Rocket,
    'landing-page': LayoutTemplate,
    'support-chat': MessagesSquare,
    'product-launch': Megaphone,
    'project-kickoff': Briefcase,
    'support-triage': LifeBuoy,
    'event-session': CalendarDays,
    'campaign-plan': Target,
    'hiring-pipeline': Users,
    'subscription-billing': CreditCard,
    'clinic-intake': Stethoscope,
    'property-booking': House,
    'editorial-calendar': Newspaper,
};

let currentAccent = accents[0].value;
const listeners = new Set<() => void>();

/**
 * The accent picked in the demo, kept while moving between the demo pages.
 */
export function useDemoAccent(): [string, (accent: string) => void] {
    const accent = useSyncExternalStore(
        (listener) => {
            listeners.add(listener);

            return () => listeners.delete(listener);
        },
        () => currentAccent,
        () => currentAccent,
    );

    function setAccent(next: string): void {
        currentAccent = next;
        listeners.forEach((listener) => listener());
    }

    return [accent, setAccent];
}

type FormsDemoPickerProps = {
    demo: string;
    demos: Record<string, string>;
    accent: string;
    onAccentChange: (accent: string) => void;
};

export function FormsDemoPicker({
    demo,
    demos,
    accent,
    onAccentChange,
}: FormsDemoPickerProps) {
    return (
        <section
            className="flex flex-col gap-4 rounded-xl border bg-card p-4"
            style={{ '--demo-accent': accent } as React.CSSProperties}
        >
            <div className="flex flex-col gap-3">
                <h2
                    id="form-class-heading"
                    className="flex items-center gap-1.5 text-xs font-semibold tracking-[0.14em] text-muted-foreground uppercase"
                >
                    <Shapes className="size-3.5" />
                    Form class
                </h2>
                <nav
                    className="flex flex-wrap gap-2"
                    aria-labelledby="form-class-heading"
                >
                    {Object.entries(demos).map(([slug, label]) => (
                        <Link
                            key={slug}
                            href={index(slug)}
                            preserveScroll
                            aria-current={slug === demo ? 'page' : undefined}
                            className={cn(
                                'inline-flex items-center gap-2 rounded-xl border bg-background px-4 py-2 text-sm font-medium text-muted-foreground shadow-xs transition hover:border-foreground/20 hover:text-foreground',
                                slug === demo &&
                                    'border-[color-mix(in_oklab,var(--demo-accent)_45%,transparent)] bg-[color-mix(in_oklab,var(--demo-accent)_8%,transparent)] text-[var(--demo-accent)] hover:border-[color-mix(in_oklab,var(--demo-accent)_45%,transparent)] hover:text-[var(--demo-accent)]',
                            )}
                        >
                            <DemoIcon slug={slug} />
                            {label}
                        </Link>
                    ))}
                </nav>
            </div>
            <div
                className="flex flex-wrap items-center gap-2"
                role="group"
                aria-label="Accent color"
            >
                <span className="flex items-center gap-1.5 text-xs font-semibold tracking-[0.14em] text-muted-foreground uppercase">
                    <Palette className="size-3.5" />
                    Accent
                </span>
                {accents.map((color) => (
                    <button
                        key={color.value}
                        type="button"
                        aria-label={color.name}
                        aria-pressed={accent === color.value}
                        className="size-6 rounded-full ring-offset-2 ring-offset-background transition hover:scale-110 aria-pressed:ring-2"
                        style={
                            {
                                backgroundColor: color.value,
                                '--tw-ring-color': color.value,
                            } as React.CSSProperties
                        }
                        onClick={() => onAccentChange(color.value)}
                    />
                ))}
                <label
                    className="relative size-6 cursor-pointer overflow-hidden rounded-full border border-dashed border-muted-foreground"
                    title="Custom color"
                >
                    <span className="sr-only">Custom accent color</span>
                    <input
                        type="color"
                        value={accent}
                        className="absolute inset-0 size-full cursor-pointer opacity-0"
                        onChange={(event) => onAccentChange(event.target.value)}
                    />
                </label>
            </div>
        </section>
    );
}

function DemoIcon({ slug }: { slug: string }) {
    const Icon = demoIcons[slug] ?? Shapes;

    return <Icon className="size-4" />;
}
