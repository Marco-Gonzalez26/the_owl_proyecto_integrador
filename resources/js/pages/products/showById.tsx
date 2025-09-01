import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/react';
import { ArrowLeft, Coffee, Droplets, Heart, Minus, Plus, Share2, Shield, ShoppingCart, Thermometer, Truck, Wine } from 'lucide-react';
import { useState } from 'react';

export default function ShowById({ product }) {
    console.log({ product });
    const [quantity, setQuantity] = useState(1);

    const [isFavorite, setIsFavorite] = useState(false);

    // Función para formatear precio
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'USD',
        }).format(price || 0);
    };

    // Función para manejar cantidad
    const updateQuantity = (change: number) => {
        const newQuantity = quantity + change;
        if (newQuantity >= 1 && newQuantity <= product.Stock) {
            setQuantity(newQuantity);
        }
    };

    // Imagen del producto
    const productImage = product.Imagen;

    // Información específica para bebidas
    const productDetails = [
        { label: 'Código', value: product.ProductoId },
        { label: 'Categoría', value: product.NombreCategoria },
        { label: 'Stock disponible', value: `${product.Stock} unidades` },
        { label: 'Presentación', value: 'Botella/Lata' }, // Puedes agregar este campo
        { label: 'Contenido', value: '350ml' }, // Campo que puedes agregar
    ];

    // Determinar si el stock es bajo
    const isLowStock = product.Stock <= 5;
    const isOutOfStock = product.Stock === 0;

    // Determinar tipo de bebida para mostrar información relevante
    const getBeverageType = (categoria: string) => {
        console.log({ categoria });
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

    return (
        <div className="min-h-screen bg-gray-50">
            {/* Header con navegación */}
            <div className="sticky top-0 z-10 border-b bg-white">
                <div className="mx-auto max-w-7xl px-4 py-4">
                    <div className="flex items-center justify-between">
                        <Link href="/the-owl/public/catalog" className="flex items-center text-gray-600 hover:text-gray-900">
                            <ArrowLeft size={20} className="mr-2" />
                            Volver a catalogo
                        </Link>
                        <div className="flex items-center space-x-4">
                            <button
                                onClick={() => setIsFavorite(!isFavorite)}
                                className={`rounded-full p-2 transition-colors ${
                                    isFavorite ? 'bg-red-50 text-red-500 hover:bg-red-100' : 'text-gray-400 hover:bg-gray-100 hover:text-red-500'
                                }`}
                            >
                                <Heart size={20} fill={isFavorite ? 'currentColor' : 'none'} />
                            </button>
                            <button className="rounded-full p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600">
                                <Share2 size={20} />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="grid grid-cols-1 gap-12 lg:grid-cols-2">
                    {/* Imagen del producto */}
                    <div className="space-y-4">
                        <div className="mx-auto aspect-[3/4] max-w-md overflow-hidden rounded-lg border bg-white shadow-sm">
                            <img src={productImage} alt={product.Nombre} className="h-full w-full object-cover" />
                        </div>

                        {/* Badges específicos para bebidas */}
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

                    {/* Información del producto */}
                    <div className="space-y-6">
                        {/* Título y precio */}
                        <div>
                            <h1 className="mb-2 text-3xl font-bold text-gray-900">{product.Nombre}</h1>

                            <div className="flex items-baseline space-x-2">
                                <span className="text-4xl font-bold text-blue-600">{formatPrice(product.Precio)}</span>
                                <span className="text-sm text-gray-500">por unidad</span>
                            </div>

                            {/* Oferta por volumen */}
                            <div className="mt-2 text-sm font-medium text-green-600">
                                {quantity >= 6 && '¡Descuento por volumen disponible!'}
                                {quantity >= 12 && ' - Pack de 12 con 10% OFF'}
                                {quantity >= 24 && ' - Caja completa con 15% OFF'}
                            </div>
                        </div>

                        {/* Estado del stock */}
                        <div className="flex items-center space-x-2">
                            <div
                                className={`h-3 w-3 rounded-full ${isOutOfStock ? 'bg-red-400' : isLowStock ? 'bg-yellow-400' : 'bg-green-400'}`}
                            ></div>
                            <span className={`font-medium ${isOutOfStock ? 'text-red-600' : isLowStock ? 'text-yellow-600' : 'text-green-600'}`}>
                                {isOutOfStock
                                    ? 'Agotado - Restock en 2-3 días'
                                    : isLowStock
                                      ? `¡Solo quedan ${product.Stock} unidades!`
                                      : `${product.Stock} unidades en stock`}
                            </span>
                        </div>

                        {/* Descripción */}
                        <div>
                            <h3 className="mb-2 text-lg font-semibold text-gray-900">Sobre esta bebida</h3>
                            <p className="leading-relaxed text-gray-600">{product.Descripcion}</p>
                        </div>

                        {/* Recomendaciones de consumo */}
                        <div className="rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <h4 className="mb-2 flex items-center font-semibold text-blue-900">
                                <Thermometer size={16} className="mr-2" />
                                Recomendaciones de consumo
                            </h4>
                            <div className="space-y-1 text-sm text-blue-800">
                                <p>• Temperatura ideal: 4-8°C (bien fría)</p>
                                <p>• Consumir preferentemente antes de la fecha indicada</p>
                                {beverageType === 'beer' && <p>• Ideal para acompañar comidas</p>}
                                {beverageType === 'soft' && <p>• Perfecto para cualquier ocasión</p>}
                                {beverageType === 'energy' && <p>• No exceder 2 unidades por día</p>}
                                <p>• Mantener en lugar fresco y seco</p>
                            </div>
                        </div>

                        {/* Selector de cantidad y botón de compra */}
                        {!isOutOfStock && (
                            <div className="space-y-4">
                                <div className="flex items-center space-x-4">
                                    <span className="font-medium text-gray-700">Cantidad:</span>
                                    <div className="flex items-center rounded-lg border border-gray-300">
                                        <Button
                                            onClick={() => updateQuantity(-1)}
                                            disabled={quantity <= 1}
                                            className="bg-white p-2 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            <Minus size={16} />
                                        </Button>
                                        <span className="min-w-[60px] px-4 py-2 text-center font-medium text-neutral-900">{quantity}</span>
                                        <Button
                                            onClick={() => updateQuantity(1)}
                                            disabled={quantity >= product.Stock}
                                            className="bg-white p-2 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            <Plus size={16} />
                                        </Button>
                                    </div>
                                    {quantity >= 6 && <span className="text-sm font-medium text-green-600">Pack de {quantity}</span>}
                                </div>

                                {/* Precio total */}
                                <div className="flex items-center justify-between rounded-lg bg-gray-50 p-3">
                                    <span className="text-gray-600">Total:</span>
                                    <span className="text-2xl font-bold text-blue-600">{formatPrice(product.Precio * quantity)}</span>
                                </div>

                                <div className="flex space-x-4">
                                    <button className="flex flex-1 items-center justify-center space-x-2 rounded-lg bg-blue-600 px-6 py-3 font-medium text-white transition-colors hover:bg-blue-700">
                                        <ShoppingCart size={20} />
                                        <span>Agregar al carrito</span>
                                    </button>
                                    <button className="rounded-lg border border-blue-600 px-6 py-3 font-medium text-blue-600 transition-colors hover:bg-blue-50">
                                        Comprar ahora
                                    </button>
                                </div>
                            </div>
                        )}

                        {/* Información de envío para bebidas */}
                        <div className="space-y-3 rounded-lg bg-gray-50 p-4">
                            <div className="flex items-center space-x-3">
                                <Truck className="text-blue-600" size={20} />
                                <span className="text-sm text-gray-600">Entrega refrigerada disponible</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <Shield className="text-green-600" size={20} />
                                <span className="text-sm text-gray-600">Productos 100% originales</span>
                            </div>
                            <div className="flex items-center space-x-3">
                                <Thermometer className="text-orange-600" size={20} />
                                <span className="text-sm text-gray-600">Almacenamiento en condiciones óptimas</span>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Información adicional específica para bebidas */}
                <div className="mt-12 grid grid-cols-1 gap-8 lg:grid-cols-2">
                    {/* Especificaciones del producto */}
                    <div className="rounded-lg border bg-white p-6">
                        <h3 className="mb-4 text-xl font-semibold text-gray-900">Información del producto</h3>
                        <dl className="space-y-3">
                            {productDetails.map((detail, index) => (
                                <div key={index} className="flex justify-between border-b border-gray-100 py-2 last:border-b-0">
                                    <dt className="font-medium text-gray-600">{detail.label}:</dt>
                                    <dd className="text-gray-900">{detail.value}</dd>
                                </div>
                            ))}
                        </dl>
                    </div>

                    {/* Política de la bodega */}
                    <div className="rounded-lg border bg-white p-6">
                        <h3 className="mb-4 text-xl font-semibold text-gray-900">Política de la bodega</h3>
                        <div className="space-y-4 text-sm text-gray-600">
                            <p>• Verificación de edad para bebidas alcohólicas</p>
                            <p>• Productos almacenados en condiciones controladas</p>
                            <p>• Fechas de vencimiento garantizadas</p>
                            <p>• Devolución por producto defectuoso</p>
                            <p>• Descuentos por volumen en compras grandes</p>
                            <p>• Categoría: {product.NombreCategoria}</p>
                        </div>
                    </div>
                </div>

                {/* Debug info (remove in production) */}
                <div className="mt-8 rounded-lg bg-gray-100 p-4">
                    <details>
                        <summary className="mb-2 cursor-pointer font-medium text-gray-700">Datos del producto (Debug)</summary>
                        <pre className="overflow-auto text-xs text-gray-600">{JSON.stringify(product, null, 2)}</pre>
                    </details>
                </div>
            </div>
        </div>
    );
}
