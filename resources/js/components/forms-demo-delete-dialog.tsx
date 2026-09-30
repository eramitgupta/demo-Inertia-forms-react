import { Form } from '@inertiajs/react';
import type { ReactNode } from 'react';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { destroy } from '@/routes/forms-demo';
import type { FormEntrySummary } from '@/types';

type FormsDemoDeleteDialogProps = {
    demo: string;
    entry: FormEntrySummary;
    children: ReactNode;
};

export function FormsDemoDeleteDialog({
    demo,
    entry,
    children,
}: FormsDemoDeleteDialogProps) {
    return (
        <Dialog>
            <DialogTrigger asChild>{children}</DialogTrigger>
            <DialogContent>
                <DialogTitle>Delete this entry?</DialogTitle>
                <DialogDescription>
                    “{entry.title}” and its uploaded files will be deleted. This
                    cannot be undone.
                </DialogDescription>

                <Form {...destroy.form([demo, entry.id])}>
                    {({ processing }) => (
                        <DialogFooter className="gap-2">
                            <DialogClose asChild>
                                <Button variant="secondary">Cancel</Button>
                            </DialogClose>
                            <Button
                                type="submit"
                                variant="destructive"
                                disabled={processing}
                            >
                                Delete entry
                            </Button>
                        </DialogFooter>
                    )}
                </Form>
            </DialogContent>
        </Dialog>
    );
}
