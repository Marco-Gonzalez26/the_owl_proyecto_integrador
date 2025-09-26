import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { CircleX } from 'lucide-react';

export default function CheckoutError({ session }) {
    return (
        <AppHeaderLayout>
            <section className="flex h-full flex-col items-center justify-center px-4 py-12 text-center sm:px-6 lg:px-8">
                <CircleX className="size-20 text-8xl text-red-600" />
                <h1 className="text-2xl font-bold">!Algo salió mal!</h1>
                <p className="text-lg text-neutral-500">Tu pedido no pudo ser procesado. Por favor, inténtalo de nuevo.</p>
                <p className="text-lg text-neutral-500">Si el problema persiste, comunícate con nosotros.</p>
                <p className="text-lg text-neutral-500">Gracias por elegirnos.</p>
            </section>
        </AppHeaderLayout>
    );
}
