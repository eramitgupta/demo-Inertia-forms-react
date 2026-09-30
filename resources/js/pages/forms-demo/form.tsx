import { Form, type FormSchema } from '@erag/inertia-forms-react';
import { Head } from '@inertiajs/react';
import { CodeInput } from '@/components/form-fields/code-input';
import { QuantityStepper } from '@/components/form-fields/quantity-stepper';
import { Rating } from '@/components/form-fields/rating';
import { FormsDemoPanel } from '@/components/forms-demo-panel';
import { FormsDemoPicker, useDemoAccent } from '@/components/forms-demo-picker';
import { dashboard } from '@/routes';
import { index, show } from '@/routes/forms-demo';
import type { FormEntrySummary, FormsDemoPageProps } from '@/types';

/**
 * Components for the custom fields in app/Forms/Fields, keyed by `component()`.
 */
const customFields = { Rating, CodeInput, QuantityStepper };

type FormsDemoFormProps = FormsDemoPageProps & {
    form: FormSchema;
    entry: (FormEntrySummary & { data: Record<string, unknown> }) | null;
};

export default function FormsDemoForm({
    demo,
    label,
    className,
    demos,
    form,
    entry,
}: FormsDemoFormProps) {
    const [accent, setAccent] = useDemoAccent();
    const title = entry
        ? `Edit ${label.toLowerCase()} entry`
        : `New ${label.toLowerCase()} entry`;

    return (
        <>
            <Head title={title} />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                <FormsDemoPicker
                    demo={demo}
                    demos={demos}
                    accent={accent}
                    onAccentChange={setAccent}
                />

                <FormsDemoPanel
                    title={title}
                    className={className}
                    backHref={entry ? show([demo, entry.id]) : index(demo)}
                    data={entry?.data ?? null}
                >
                    <Form
                        key={`${demo}-${entry?.id ?? 'new'}`}
                        form={form}
                        accent={accent}
                        components={customFields}
                    />
                </FormsDemoPanel>
            </div>
        </>
    );
}

FormsDemoForm.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: dashboard() },
        { title: 'Inertia Forms demo', href: index() },
    ],
};
