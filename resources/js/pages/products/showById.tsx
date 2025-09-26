import { Button } from '@/components/ui/button';
import { useCart } from '@/hooks/use-cart';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Link } from '@inertiajs/react';
import { ArrowLeft, Coffee, Droplets, Minus, Plus, ShoppingCart, Thermometer, Wine } from 'lucide-react';
import { useState } from 'react';

const volumeDiscounts = [
    { cantidad: 6, descuento: 0.05 },
    { cantidad: 12, descuento: 0.1 },
    { cantidad: 24, descuento: 0.15 },
];
export default function ShowById({ product }) {
    const [quantity, setQuantity] = useState(1);
    const { addToCart } = useCart();
    console.log({ product });
    // Formatear precio
    const formatPrice = (price: number) => new Intl.NumberFormat('es-ES', { style: 'currency', currency: 'USD' }).format(price || 0);

    // Manejar cantidad
    const updateQuantity = (change: number) => {
        const newQuantity = quantity + change;
        if (newQuantity >= 1 && newQuantity <= product.Stock) setQuantity(newQuantity);
    };

    // Determinar tipo de bebida
    const getBeverageType = (categoria: string) => {
        const cat = categoria.toLowerCase();
        if (cat.includes('cerveza') || cat.includes('beer')) return 'beer';
        if (cat.includes('vino') || cat.includes('wine')) return 'wine';
        if (cat.includes('refresco') || cat.includes('gaseosa') || cat.includes('soda')) return 'soft';
        if (cat.includes('agua') || cat.includes('water')) return 'water';
        if (cat.includes('jugo') || cat.includes('juice')) return 'juice';
        if (cat.includes('energética') || cat.includes('energy')) return 'energy';
        return 'other';
    };

    const beverageType = getBeverageType(product.categoria.Nombre);

    // Determinar precio final con mayoreo y descuento por volumen
    const calculatePrice = () => {
        let basePrice = product.CantidadMinMayorista && quantity >= product.CantidadMinMayorista ? product.PrecioMayorista : product.Precio;

        const applicableDiscount = volumeDiscounts.filter((d) => quantity >= d.cantidad).sort((a, b) => b.descuento - a.descuento)[0];

        if (applicableDiscount) basePrice *= 1 - applicableDiscount.descuento;

        return basePrice;
    };

    const priceFinal = calculatePrice();

    const handleAddToCart = () => {
        addToCart({
            id: product.ProductoId,
            name: product.Nombre,
            price: priceFinal,
            quantity,
            image: product.Imagen,
        });
    };

    const isLowStock = product.Stock <= 5;
    const isOutOfStock = product.Stock === 0;

    return (
        <AppHeaderLayout>
            <div className="min-h-screen bg-neutral-50">
                <div className="sticky top-0 z-10 border-b bg-white">
                    <div className="mx-auto max-w-7xl px-4 py-4">
                        <div className="flex items-center justify-between">
                            <Link href={route('catalog.index')} className="flex items-center text-neutral-600 hover:text-neutral-900">
                                <ArrowLeft size={20} className="mr-2" /> Volver a catálogo
                            </Link>
                        </div>
                    </div>
                </div>

                <div className="mx-auto max-w-7xl px-4 py-8">
                    <div className="grid grid-cols-1 gap-12 lg:grid-cols-2">
                        {/* Imagen */}
                        <div className="space-y-4">
                            <div className="mx-auto aspect-[3/4] max-w-md overflow-hidden rounded-lg border bg-white shadow-sm">
                                <img src={product.Imagen} alt={product.Nombre} className="h-full w-full object-cover" />
                            </div>

                            {/* Badges */}
                            <div className="flex flex-wrap justify-center gap-2">
                                {beverageType === 'beer' && (
                                    <span className="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-sm font-medium text-amber-800">
                                        <Wine size={14} className="mr-1" />
                                        Cerveza Premium
                                    </span>
                                )}
                                {beverageType === 'soft' && (
                                    <span className="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800">
                                        <Droplets size={14} className="mr-1" />
                                        Bebida Refrescante
                                    </span>
                                )}
                                {(beverageType === 'water' || beverageType === 'juice') && (
                                    <span className="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                        <Droplets size={14} className="mr-1" />
                                        Hidratante Natural
                                    </span>
                                )}
                                {beverageType === 'energy' && (
                                    <span className="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800">
                                        <Coffee size={14} className="mr-1" />
                                        Energizante
                                    </span>
                                )}
                                <span className="inline-flex items-center rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800">
                                    <Thermometer size={14} className="mr-1" />
                                    Servir frío
                                </span>
                            </div>
                        </div>

                        {/* Info y selector */}
                        <div className="space-y-6">
                            <div>
                                <h1 className="mb-2 text-3xl font-bold text-neutral-900">{product.Nombre}</h1>

                                <div className="flex flex-col space-y-1">
                                    <div className="flex items-baseline space-x-2">
                                        <span className="text-4xl font-bold text-blue-600">{formatPrice(product.Precio)}</span>
                                        <span className="text-sm text-neutral-500">por unidad</span>
                                    </div>
                                    <div className="flex items-baseline space-x-2">
                                        <span className="text-2xl font-semibold text-green-600">{formatPrice(product.PrecioMayorista)}</span>
                                        <span className="text-sm text-neutral-500">mayorista</span>
                                    </div>
                                </div>

                                {/* Mensaje de descuento por volumen */}

                                <div className="mt-2 text-sm font-medium text-green-600">
                                    {volumeDiscounts
                                        .filter((d) => quantity >= d.cantidad)
                                        .map((d) => `¡${d.descuento * 100}% OFF por ${d.cantidad}+ unidades!`)
                                        .join(', ')}
                                </div>
                            </div>

                            {/* Stock */}
                            <div className="flex items-center space-x-2">
                                <div
                                    className={`h-3 w-3 rounded-full ${isOutOfStock ? 'bg-red-400' : isLowStock ? 'bg-yellow-400' : 'bg-green-400'}`}
                                ></div>
                                <span className={`font-medium ${isOutOfStock ? 'text-red-600' : isLowStock ? 'text-yellow-600' : 'text-green-600'}`}>
                                    {isOutOfStock
                                        ? 'Agotado'
                                        : isLowStock
                                          ? `¡Solo quedan ${product.Stock} unidades!`
                                          : `${product.Stock} unidades en stock`}
                                </span>
                            </div>

                            {/* Selector de cantidad */}
                            {!isOutOfStock && (
                                <div className="space-y-4">
                                    <div className="flex items-center space-x-4">
                                        <span className="font-medium text-neutral-700">Cantidad:</span>
                                        <div className="flex items-center rounded-lg border border-neutral-300">
                                            <Button
                                                onClick={() => updateQuantity(-1)}
                                                disabled={quantity <= 1}
                                                className="p-2 text-white disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                <Minus size={16} />
                                            </Button>
                                            <span className="min-w-[60px] px-4 py-2 text-center font-medium text-neutral-900">{quantity}</span>
                                            <Button
                                                onClick={() => updateQuantity(1)}
                                                disabled={quantity >= product.Stock}
                                                className="p-2 text-white disabled:cursor-not-allowed disabled:opacity-50"
                                            >
                                                <Plus size={16} />
                                            </Button>
                                        </div>
                                    </div>

                                    {/* Total */}
                                    <div className="flex items-center justify-between rounded-lg bg-neutral-50 p-3">
                                        <span className="text-neutral-600">Total:</span>
                                        <span className="text-2xl font-bold text-blue-600">{formatPrice(priceFinal * quantity)}</span>
                                    </div>

                                    <div className="flex space-x-4">
                                        <Button
                                            onClick={handleAddToCart}
                                            className="flex flex-1 items-center justify-center space-x-2 rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700"
                                        >
                                            <ShoppingCart size={20} /> <span>Agregar al carrito</span>
                                        </Button>
                                        <Button
                                            variant="outline"
                                            className="rounded-lg border border-blue-600 px-6 py-3 font-medium text-blue-600 transition-colors hover:bg-blue-50"
                                        >
                                            Comprar ahora
                                        </Button>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppHeaderLayout>
    );
}
