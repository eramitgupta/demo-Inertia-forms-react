import { reactLang } from '@erag/lang-sync-inertia/react';
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
    const { __, trans } = reactLang();

    return (
        <div className="grid gap-4 xl:grid-cols-[minmax(0,1fr)_22rem]">
            <Card>
                <CardHeader className="flex flex-row flex-wrap items-start justify-between gap-3">
                    <div className="grid gap-1.5">
                        <CardTitle>{title}</CardTitle>
                        <CardDescription>
                            {trans('demo.page.panel_description', {
                                file: `app/Forms/${className}.php`,
                            })}
                        </CardDescription>
                    </div>
                    <Button variant="outline" size="sm" asChild>
                        <Link href={backHref}>
                            <ArrowLeft />
                            {__('demo.page.back')}
                        </Link>
                    </Button>
                </CardHeader>
                <CardContent>{children}</CardContent>
            </Card>

            <Card className="h-fit">
                <CardHeader>
                    <CardTitle>{__('demo.page.stored_data')}</CardTitle>
                    <CardDescription>
                        {__('demo.page.stored_data_description')}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    {data ? (
                        <pre className="max-h-128 overflow-auto rounded-md bg-muted p-3 text-xs">
                            {JSON.stringify(data, null, 2)}
                        </pre>
                    ) : (
                        <p className="rounded-md border border-dashed p-3 text-sm text-muted-foreground">
                            {__('demo.page.nothing_saved')}
                        </p>
                    )}
                </CardContent>
            </Card>
        </div>
    );
}
