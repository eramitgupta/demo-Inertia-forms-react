import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, Paperclip, Pencil, Trash2 } from 'lucide-react';
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
import { formatDate, formatFileSize } from '@/lib/forms-demo';
import { dashboard } from '@/routes';
import { edit, index } from '@/routes/forms-demo';
import type {
    FormEntryRow,
    FormEntrySection,
    FormEntrySummary,
    FormsDemoPageProps,
} from '@/types';

type FormsDemoShowProps = FormsDemoPageProps & {
    entry: FormEntrySummary;
    sections: FormEntrySection[];
};

export default function FormsDemoShow({
    demo,
    label,
    demos,
    entry,
    sections,
}: FormsDemoShowProps) {
    const [accent, setAccent] = useDemoAccent();

    return (
        <>
            <Head title={entry.title} />
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
                            <CardTitle>{entry.title}</CardTitle>
                            <CardDescription>
                                {label} entry #{entry.id} · created{' '}
                                {formatDate(entry.createdAt)} · updated{' '}
                                {formatDate(entry.updatedAt)}
                            </CardDescription>
                        </div>
                        <div className="flex flex-wrap gap-2">
                            <Button variant="outline" size="sm" asChild>
                                <Link href={index(demo)}>
                                    <ArrowLeft />
                                    All entries
                                </Link>
                            </Button>
                            <Button
                                size="sm"
                                asChild
                                className="bg-(--demo-accent) text-white hover:bg-(--demo-accent)/90"
                            >
                                <Link href={edit([demo, entry.id])}>
                                    <Pencil />
                                    Edit
                                </Link>
                            </Button>
                            <FormsDemoDeleteDialog demo={demo} entry={entry}>
                                <Button variant="destructive" size="sm">
                                    <Trash2 />
                                    Delete
                                </Button>
                            </FormsDemoDeleteDialog>
                        </div>
                    </CardHeader>

                    <CardContent className="grid gap-6">
                        {sections.map((section, sectionIndex) => (
                            <section key={sectionIndex} className="grid gap-3">
                                {section.title && (
                                    <h3 className="border-b pb-2 text-xs font-semibold tracking-[0.14em] text-muted-foreground uppercase">
                                        {section.title}
                                    </h3>
                                )}
                                <dl className="grid gap-x-6 gap-y-3 sm:grid-cols-[12rem_minmax(0,1fr)]">
                                    {section.rows.map((row, rowIndex) => (
                                        <div
                                            key={rowIndex}
                                            className="contents"
                                        >
                                            <dt className="text-sm text-muted-foreground">
                                                {row.label}
                                            </dt>
                                            <dd className="text-sm">
                                                <EntryValue row={row} />
                                            </dd>
                                        </div>
                                    ))}
                                </dl>
                            </section>
                        ))}
                    </CardContent>
                </Card>
            </div>
        </>
    );
}

function EntryValue({ row }: { row: FormEntryRow }) {
    if (row.type === 'empty') {
        return <span className="text-muted-foreground">—</span>;
    }

    if (row.type === 'json') {
        return (
            <pre className="max-h-80 overflow-auto rounded-md bg-muted p-3 text-xs">
                {row.value}
            </pre>
        );
    }

    if (row.type === 'files') {
        return (
            <ul className="grid gap-1.5">
                {row.files.map((file) => (
                    <li key={file.url}>
                        <a
                            href={file.url}
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex items-center gap-1.5 hover:underline"
                        >
                            <Paperclip className="size-3.5 text-muted-foreground" />
                            {file.name}
                            <span className="text-xs text-muted-foreground">
                                {formatFileSize(file.size)}
                            </span>
                        </a>
                    </li>
                ))}
            </ul>
        );
    }

    return <span className="break-words whitespace-pre-wrap">{row.value}</span>;
}

FormsDemoShow.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Inertia Forms demo', href: index() },
    ],
};
