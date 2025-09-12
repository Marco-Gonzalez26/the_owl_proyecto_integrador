import { Head } from '@inertiajs/react';

import AppearanceTabs from '@/components/appearance-tabs';
import HeadingSmall from '@/components/heading-small';
import { type BreadcrumbItem } from '@/types';


import SettingsLayout from '@/layouts/settings/layout';
import AppHeaderLayout from '@/layouts/app/app-header-layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];

export default function Appearance() {
    return (
        <AppHeaderLayout breadcrumbs={breadcrumbs}>
            <Head title="Appearance settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <HeadingSmall title="Apariencia y tema" description="Actualiza tus ajustes de apariencia" />
                    <AppearanceTabs />
                </div>
            </SettingsLayout>
        </AppHeaderLayout>
    );
}
