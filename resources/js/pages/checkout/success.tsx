import { useCart } from '@/hooks/use-cart';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Button } from '@/components/ui/button';
import { CircleCheckBig } from 'lucide-react';
import { useEffect } from 'react';
import { Link } from '@inertiajs/react';

export default function CheckoutSuccess({ session }) {
    const { cart, clearCart } = useCart();

    useEffect(() => {
        console.log('🛒 CheckoutSuccess cart:', cart);
        console.log('🛒 CheckoutSuccess session:', session);
        clearCart();
    }, []);

    return (
        <AppHeaderLayout>
            <section className="flex items-center justify-center flex-col h-full text-center px-4 py-12 sm:px-6 lg:px-8">
                <CircleCheckBig className="text-8xl text-green-600 size-20" />
            <h1 className="text-2xl font-bold">¡Compra exitosa!</h1>
            <p className="text-neutral-500 text-lg">
                Tu pedido ha sido procesado con éxito. Gracias por preferirnos.
            </p>
            <Button className="mt-4 " size="lg" asChild >
                <Link href={route('user.orders')}>
                    Ver mis pedidos
                </Link>
            </Button>
            </section>
        </AppHeaderLayout>
    );
}

