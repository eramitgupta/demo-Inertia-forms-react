import { Link } from '@inertiajs/react';
import type { InertiaLinkProps } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';
import type { ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';

type FormsDemoPanelProps = {
    title: string;
    className: string;
    backHref: NonNullable<InertiaLinkProps['href']>;
    data: Record<string, unknown> | null;
    children: ReactNode;
};

export function FormsDemoPanel({
    title,
    className,
    backHref,
    data,
    children,
}: FormsDemoPanelProps) {
    return (
        <div className="grid gap-4 xl:grid-cols-[minmax(0,1fr)_22rem]">
            <Card>
                <CardHeader className="flex flex-row flex-wrap items-start justify-between gap-3">
                    <div className="grid gap-1.5">
                        <CardTitle>{title}</CardTitle>
                        <CardDescription>
                            Defined in <code>app/Forms/{className}.php</code>{' '}
                            and rendered with one <code>&lt;Form&gt;</code>{' '}
                            component. Saving validates it on the server and
                            stores it with <code>FormEntryService</code>.
                        </CardDescription>
                    </div>
                    <Button variant="outline" size="sm" asChild>
                        <Link href={backHref}>
                            <ArrowLeft />
                            Back
                        </Link>
                    </Button>
                </CardHeader>
                <CardContent>{children}</CardContent>
            </Card>

            <Card className="h-fit">
                <CardHeader>
                    <CardTitle>Stored data</CardTitle>
                    <CardDescription>
                        What <code>FormEntryService</code> saved in the{' '}
                        <code>form_entries</code> table. Secrets are masked.
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {data ? (
                        <pre className="max-h-128 overflow-auto rounded-md bg-muted p-3 text-xs">
                            {JSON.stringify(data, null, 2)}
                        </pre>
                    ) : (
                        <p className="rounded-md border border-dashed p-3 text-sm text-muted-foreground">
                            Nothing saved yet. Submit the form to create an
                            entry.
                        </p>
                    )}
                </CardContent>
            </Card>
        </div>
    );
}
