import { Button } from '@/components/ui/button';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Link, ShoppingBag } from 'lucide-react';

export default function CheckoutCancel({ session }) {
    return (
        <AppHeaderLayout>
            <section className="flex h-full flex-col items-center justify-center px-4 py-12 text-center sm:px-6 lg:px-8">
                <ShoppingBag className="size-20 text-8xl text-indigo-600" />
                <h1 className="text-2xl font-bold">Pedido cancelado</h1>
                <p className="text-lg text-neutral-500">Tu pedido ha sido cancelado.</p>
                <p className="text-lg text-neutral-500">No te preocupes, puedes volver a comprar y tus fondos estan seguros.</p>
                <p className="text-lg text-neutral-500">Gracias por elegirnos.</p>
                <Button className="mt-4" size="lg" asChild about="Volver al catálogo">
                    <Link href={route('catalog.index')}>Volver al catálogo</Link>
                </Button>
            </section>
        </AppHeaderLayout>
    );
}
