import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { useCart } from '@/hooks/use-cart';
import { router } from '@inertiajs/react';
import { Minus, Plus, ShoppingBag, ShoppingCart, Trash2 } from 'lucide-react';

export const Cart = () => {
    const { cart, addToCart, removeFromCart, getTotalItems, getTotalPrice, clearCart, reduceItemQuantity, increaseItemQuantity } = useCart();

    // Función para formatear precio
    const formatPrice = (price: number | string) => {
        return new Intl.NumberFormat('es-EC', {
            style: 'currency',
            currency: 'USD',
        }).format(typeof price === 'string' ? parseFloat(price) : price);
    };

    // Función para aumentar cantidad
    const increaseQuantity = (item: any) => {
        increaseItemQuantity(item);
    };

    // Función para disminuir cantidad
    const decreaseQuantity = (item: any) => {
        if (item.Quantity === 1) {
            removeFromCart(item);
        } else {
            reduceItemQuantity(item);
        }
    };

    const handleCheckout = async () => {
        // Realizar el checkout
        router.post(
            route('checkout.create'),
            {
                cart_items: cart,
            },
            {
                onSuccess: () => {
                    console.log('🛒 handleCheckout ejecutado');
                    console.log('🛒 cart:', cart);
                },
                onError: (error) => {
                    console.log('🛒 handleCheckout error', error);
                },
            },
        );
    };
    const totalItems = getTotalItems();
    const totalPrice = getTotalPrice();

    return (
        <Sheet>
            <SheetTrigger asChild>
                <Button variant="ghost" size="icon" className="relative mr-2 h-[34px] w-[34px] hover:cursor-pointer">
                    <ShoppingCart className="h-5 w-5" />
                    {totalItems > 0 && (
                        <Badge
                            variant="destructive"
                            className="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full p-0 text-xs"
                        >
                            {totalItems > 99 ? '99+' : totalItems}
                        </Badge>
                    )}
                </Button>
            </SheetTrigger>
            <SheetContent side="right" className="flex h-full w-80 flex-col p-4">
                <SheetHeader className="space-y-2.5 pr-6">
                    <SheetTitle className="flex items-center gap-2">
                        <ShoppingBag className="h-5 w-5" />
                        Carrito de compras
                        {totalItems > 0 && (
                            <Badge variant="secondary" className="ml-auto truncate">
                                {totalItems} {totalItems === 1 ? 'producto' : 'productos'}
                            </Badge>
                        )}
                    </SheetTitle>
                </SheetHeader>

                <div className="flex flex-1 flex-col">
                    {cart.length > 0 ? (
                        <>
                            <ScrollArea className="flex-1 pr-2">
                                <div className="space-y-4 pb-4">
                                    {cart.map((item) => (
                                        <div key={item.id} className="group relative rounded-lg border p-3 transition-colors hover:bg-muted/50">
                                            <div className="flex gap-3">
                                                <div className="relative h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border bg-muted">
                                                    <img src={item.image} alt={item.name} className="h-full w-full object-cover p-1" />
                                                </div>

                                                <div className="flex flex-1 flex-col justify-between">
                                                    <div>
                                                        <h4 className="text-sm leading-none font-medium text-foreground">{item.name}</h4>
                                                        <p className="mt-1 text-sm text-muted-foreground">{formatPrice(item.price)} c/u</p>
                                                    </div>

                                                    <div className="mt-2 flex items-center justify-between">
                                                        <div className="flex items-center gap-1">
                                                            <Button
                                                                variant="outline"
                                                                size="icon"
                                                                className="h-6 w-6"
                                                                onClick={() => decreaseQuantity(item)}
                                                            >
                                                                <Minus className="h-3 w-3" />
                                                            </Button>
                                                            <span className="w-8 text-center text-sm font-medium">{item.quantity}</span>
                                                            <Button
                                                                variant="outline"
                                                                size="icon"
                                                                className="h-6 w-6"
                                                                onClick={() => increaseQuantity(item)}
                                                            >
                                                                <Plus className="h-3 w-3" />
                                                            </Button>
                                                        </div>

                                                        <div className="flex items-center gap-2">
                                                            <span className="text-sm font-semibold">
                                                                {formatPrice(parseFloat(item.price.toString()) * item.quantity)}
                                                            </span>
                                                            <Button
                                                                variant="ghost"
                                                                size="icon"
                                                                className="h-6 w-6 text-muted-foreground hover:text-destructive"
                                                                onClick={() => removeFromCart(item)}
                                                            >
                                                                <Trash2 className="h-3 w-3" />
                                                            </Button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </ScrollArea>

                            <div className="space-y-4 pt-4">
                                <Separator />

                                <div className="space-y-2">
                                    <div className="flex justify-between text-sm">
                                        <span className="text-muted-foreground">Subtotal ({totalItems} items)</span>
                                        <span className="font-medium">{formatPrice(totalPrice)}</span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span className="text-muted-foreground">Envío</span>
                                        <span className="font-medium text-green-600">Gratis</span>
                                    </div>
                                    <Separator />
                                    <div className="flex justify-between">
                                        <span className="text-base font-semibold">Total</span>
                                        <span className="text-base font-bold">{formatPrice(totalPrice)}</span>
                                    </div>
                                </div>

                                <div className="space-y-2">
                                    <Button className="w-full" size="lg" onClick={handleCheckout}>
                                        Proceder al pago
                                    </Button>
                                    <Button variant="outline" className="w-full" onClick={clearCart}>
                                        Vaciar carrito
                                    </Button>
                                </div>
                            </div>
                        </>
                    ) : (
                        <div className="flex flex-1 flex-col items-center justify-center text-center">
                            <div className="mb-4 rounded-full bg-muted p-6">
                                <ShoppingCart className="h-8 w-8 text-muted-foreground" />
                            </div>
                            <h3 className="mb-2 text-lg font-medium">Tu carrito está vacío</h3>
                            <p className="mb-6 max-w-sm text-sm text-muted-foreground">
                                Explora nuestros productos y agrega algunos artículos a tu carrito para comenzar.
                            </p>
                            <Button variant="outline" className="w-full">
                                Continuar comprando
                            </Button>
                        </div>
                    )}
                </div>
            </SheetContent>
        </Sheet>
    );
};
