import { Link, router } from '@inertiajs/react';

export function ProductCard({ product, viewMode }: { product: any; viewMode: string }) {
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'USD',
        }).format(price || 0);
    };

    if (viewMode === 'list') {
        return (
            <div className="rounded-lg border bg-white p-6 shadow-sm transition-shadow hover:shadow-md">
                <div className="flex items-start space-x-4">
                    {product.Imagen && <img src={product.Imagen} alt={product.Nombre} className="h-20 w-20 rounded-lg object-cover" />}
                    <div className="flex-1">
                        <Link href={route('product.show', product.ProductoId)} className="text-lg font-semibold text-neutral-900 hover:text-blue-600">
                            {product.Nombre}
                        </Link>
                        {product.Descripcion && <p className="mt-1 line-clamp-2 text-sm text-neutral-600">{product.Descripcion}</p>}
                        <div className="mt-2 flex items-center justify-between">
                            <span className="text-xl font-bold text-blue-600">{formatPrice(product.Precio)}</span>
                            {product.Stock !== undefined && (
                                <span
                                    className={`rounded-full px-2 py-1 text-sm ${
                                        product.Stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    }`}
                                >
                                    {product.Stock > 0 ? `Stock: ${product.Stock}` : 'Sin stock'}
                                </span>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        );
    }
    const goToProduct = () => {
        router.visit(route('product.show', product.ProductoId));
    };
    return (
        <div
            className="overflow-hidden rounded-lg border bg-white shadow-sm transition-all hover:scale-105 hover:cursor-pointer hover:shadow-md"
            onClick={goToProduct}
        >
            {product.Imagen && (
                <div className="aspect-w-16 aspect-h-12 bg-neutral-200">
                    <img src={product.Imagen} alt={product.Nombre} className="size-full md:object-scale-down" />
                </div>
            )}
            <div className="p-4">
                <Link
                    href={route('product.show', product.ProductoId)}
                    className="mb-2 block text-lg font-semibold text-neutral-900 hover:text-blue-600"
                >
                    {product.Nombre}
                </Link>
                {product.Descripcion && <p className="mb-3 line-clamp-2 text-sm text-neutral-600">{product.Descripcion}</p>}
                <div className="flex items-center justify-between">
                    <span className="text-xl font-bold text-blue-600">{formatPrice(product.Precio)}</span>
                    {product.Stock !== undefined && (
                        <span
                            className={`rounded-full px-2 py-1 text-xs ${
                                product.Stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                            }`}
                        >
                            {product.Stock > 0 ? `Stock: ${product.Stock}` : 'Sin stock'}
                        </span>
                    )}
                </div>
            </div>
        </div>
    );
}
