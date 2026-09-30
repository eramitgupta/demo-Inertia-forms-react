import { Head, Link, router } from '@inertiajs/react';
import {
    ChevronLeft,
    ChevronRight,
    Eye,
    Inbox,
    Pencil,
    Plus,
    Search,
    Trash2,
} from 'lucide-react';
import { useEffect, useState } from 'react';
import { FormsDemoDeleteDialog } from '@/components/forms-demo-delete-dialog';
import { FormsDemoPicker, useDemoAccent } from '@/components/forms-demo-picker';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { formatDate } from '@/lib/forms-demo';
import { dashboard } from '@/routes';
import { create, edit, index, show } from '@/routes/forms-demo';
import type { FormEntrySummary, FormsDemoPageProps, Paginated } from '@/types';

type FormsDemoIndexProps = FormsDemoPageProps & {
    search: string;
    entries: Paginated<FormEntrySummary>;
};

export default function FormsDemoIndex({
    demo,
    label,
    className,
    demos,
    search,
    entries,
}: FormsDemoIndexProps) {
    const [accent, setAccent] = useDemoAccent();
    const [query, setQuery] = useState(search);

    useEffect(() => {
        if (query.trim() === search) {
            return;
        }

        const timer = setTimeout(() => {
            router.get(
                index(demo, { query: { search: query.trim() || undefined } }),
                {},
                { preserveState: true, preserveScroll: true, replace: true },
            );
        }, 300);

        return () => clearTimeout(timer);
    }, [query, search, demo]);

    return (
        <>
            <Head title={`${label} entries`} />
            <div
                className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
                style={{ '--demo-accent': accent } as React.CSSProperties}
            >
                <FormsDemoPicker
                    demo={demo}
                    demos={demos}
                    accent={accent}
                    onAccentChange={setAccent}
                />

                <Card>
                    <CardHeader className="flex flex-row flex-wrap items-start justify-between gap-3">
                        <div className="grid gap-1.5">
                            <CardTitle>{label} entries</CardTitle>
                            <CardDescription>
                                Saved with{' '}
                                <code>app/Forms/{className}.php</code> and{' '}
                                <code>FormEntryService</code>.
                            </CardDescription>
                        </div>
                        <div className="flex w-full flex-wrap items-center gap-2 sm:w-auto">
                            <div className="relative flex-1 sm:w-64 sm:flex-none">
                                <Search className="pointer-events-none absolute top-1/2 left-2.5 size-4 -translate-y-1/2 text-muted-foreground" />
                                <Input
                                    type="search"
                                    value={query}
                                    placeholder="Search entries…"
                                    aria-label="Search entries"
                                    className="pl-8"
                                    onChange={(event) =>
                                        setQuery(event.target.value)
                                    }
                                />
                            </div>
                            <Button
                                asChild
                                className="bg-(--demo-accent) text-white hover:bg-(--demo-accent)/90"
                            >
                                <Link href={create(demo)}>
                                    <Plus />
                                    New entry
                                </Link>
                            </Button>
                        </div>
                    </CardHeader>

                    <CardContent>
                        {entries.data.length === 0 ? (
                            <div className="flex flex-col items-center gap-3 rounded-lg border border-dashed px-4 py-12 text-center">
                                <Inbox className="size-8 text-muted-foreground" />
                                <p className="text-sm text-muted-foreground">
                                    {search
                                        ? `No entries match “${search}”.`
                                        : 'No entries yet. Fill in the form to save the first one.'}
                                </p>
                                {!search && (
                                    <Button variant="outline" size="sm" asChild>
                                        <Link href={create(demo)}>
                                            <Plus />
                                            Create entry
                                        </Link>
                                    </Button>
                                )}
                            </div>
                        ) : (
                            <div className="overflow-x-auto rounded-lg border">
                                <table className="w-full text-sm">
                                    <thead className="bg-muted/50 text-left text-xs text-muted-foreground uppercase">
                                        <tr>
                                            <th className="px-4 py-2.5 font-medium">
                                                Title
                                            </th>
                                            <th className="hidden px-4 py-2.5 font-medium md:table-cell">
                                                Created
                                            </th>
                                            <th className="hidden px-4 py-2.5 font-medium sm:table-cell">
                                                Updated
                                            </th>
                                            <th className="px-4 py-2.5 text-right font-medium">
                                                <span className="sr-only">
                                                    Actions
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y">
                                        {entries.data.map((entry) => (
                                            <tr
                                                key={entry.id}
                                                className="transition hover:bg-muted/40"
                                            >
                                                <td className="px-4 py-3">
                                                    <Link
                                                        href={show([
                                                            demo,
                                                            entry.id,
                                                        ])}
                                                        className="font-medium hover:underline"
                                                    >
                                                        {entry.title}
                                                    </Link>
                                                    <span className="ml-2 text-xs text-muted-foreground">
                                                        #{entry.id}
                                                    </span>
                                                </td>
                                                <td className="hidden px-4 py-3 text-muted-foreground md:table-cell">
                                                    {formatDate(
                                                        entry.createdAt,
                                                    )}
                                                </td>
                                                <td className="hidden px-4 py-3 text-muted-foreground sm:table-cell">
                                                    {formatDate(
                                                        entry.updatedAt,
                                                    )}
                                                </td>
                                                <td className="px-4 py-2">
                                                    <div className="flex justify-end gap-1">
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            asChild
                                                        >
                                                            <Link
                                                                href={show([
                                                                    demo,
                                                                    entry.id,
                                                                ])}
                                                                aria-label={`View ${entry.title}`}
                                                            >
                                                                <Eye />
                                                            </Link>
                                                        </Button>
                                                        <Button
                                                            variant="ghost"
                                                            size="icon"
                                                            asChild
                                                        >
                                                            <Link
                                                                href={edit([
                                                                    demo,
                                                                    entry.id,
                                                                ])}
                                                                aria-label={`Edit ${entry.title}`}
                                                            >
                                                                <Pencil />
                                                            </Link>
                                                        </Button>
                                                        <FormsDemoDeleteDialog
                                                            demo={demo}
                                                            entry={entry}
                                                        >
                                                            <Button
                                                                variant="ghost"
                                                                size="icon"
                                                                className="text-destructive hover:text-destructive"
                                                                aria-label={`Delete ${entry.title}`}
                                                            >
                                                                <Trash2 />
                                                            </Button>
                                                        </FormsDemoDeleteDialog>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}

                        {entries.total > 0 && (
                            <div className="mt-4 flex flex-wrap items-center justify-between gap-3 text-sm text-muted-foreground">
                                <p>
                                    Showing {entries.from}–{entries.to} of{' '}
                                    {entries.total}
                                </p>
                                <div className="flex items-center gap-2">
                                    <PageLink
                                        href={entries.prev_page_url}
                                        label="Previous"
                                    >
                                        <ChevronLeft />
                                    </PageLink>
                                    <span>
                                        Page {entries.current_page} of{' '}
                                        {entries.last_page}
                                    </span>
                                    <PageLink
                                        href={entries.next_page_url}
                                        label="Next"
                                    >
                                        <ChevronRight />
                                    </PageLink>
                                </div>
                            </div>
                        )}
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

function PageLink({
    href,
    label,
    children,
}: {
    href: string | null;
    label: string;
    children: React.ReactNode;
}) {
    if (!href) {
        return (
            <Button variant="outline" size="icon" disabled aria-label={label}>
                {children}
            </Button>
        );
    }

    return (
        <Button variant="outline" size="icon" asChild>
            <Link href={href} preserveScroll preserveState aria-label={label}>
                {children}
            </Link>
        </Button>
    );
}

FormsDemoIndex.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Inertia Forms demo', href: index() },
    ],
};
