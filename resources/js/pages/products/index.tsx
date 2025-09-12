import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { AlertTriangle, Beer, Coffee, Package, Pen, Plus, Search, Trash, Wine } from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

type Product = {
    ProductoId: number;
    Nombre: string;
    Descripcion: string;
    Precio: number;
    Stock: number;
    Imagen: string;
    CategoriaId: number;
    NombreCategoria: string;
};

const breadcrumbs: any[] = [
    {
        title: 'Dashboard',
        href: '/the-owl/public/dashboard',
    },
    {
        title: 'Productos',
        href: '/the-owl/public/dashboard/products',
    },
];
export default function Index({ products }: { products: Product[] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [categoryFilter, setCategoryFilter] = useState('all');
    const [stockFilter, setStockFilter] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);
    const { processing, delete: destroy } = useForm();
    const itemsPerPage = 15;

    const categories = useMemo(() => {
        const uniqueCategories = Array.from(
            new Set(
                products.map((p) => {
                    return { CategoriaId: p.CategoriaId, Nombre: p.NombreCategoria };
                }),
            ),
        );
        return uniqueCategories;
    }, [products]);

    const filteredProducts = useMemo(() => {
        return products.filter((product) => {
            const matchesSearch =
                product.Nombre.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.Descripcion.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesCategory = categoryFilter === 'all' || product.NombreCategoria === categoryFilter;

            const matchesStock =
                stockFilter === 'all' ||
                (stockFilter === 'in-stock' && product.Stock > 0) ||
                (stockFilter === 'out-of-stock' && product.Stock === 0) ||
                (stockFilter === 'low-stock' && product.Stock > 0 && product.Stock <= 10);

            return matchesSearch && matchesCategory && matchesStock;
        });
    }, [products, searchTerm, categoryFilter, stockFilter]);

    const totalPages = Math.ceil(filteredProducts.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedProducts = filteredProducts.slice(startIndex, startIndex + itemsPerPage);

    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-EC', {
            style: 'currency',
            currency: 'USD',
        }).format(price);
    };

    const getStockBadge = (stock: number) => {
        if (stock === 0) {
            return (
                <span className="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">
                    <AlertTriangle className="mr-1 h-3 w-3" />
                    Sin Stock
                </span>
            );
        } else if (stock <= 10) {
            return (
                <span className="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-semibold text-orange-800">
                    <AlertTriangle className="mr-1 h-3 w-3" />
                    Stock Bajo ({stock})
                </span>
            );
        } else if (stock <= 50) {
            return (
                <span className="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">
                    Stock Medio ({stock})
                </span>
            );
        } else {
            return (
                <span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                    Stock Alto ({stock})
                </span>
            );
        }
    };

    const getCategoryIcon = (category: string) => {
        const iconClass = 'w-4 h-4 mr-1';
        switch (category.toLowerCase()) {
            case 'cervezas':
                return <Beer className={iconClass} />;
            case 'vinos':
                return <Wine className={iconClass} />;
            case 'licores':
                return <Coffee className={iconClass} />;
            default:
                return <Package className={iconClass} />;
        }
    };

    const deleteProduct = (id: number) => {
        destroy(`/the-owl/public/dashboard/api/products/${id}/delete`, {
            onSuccess: () => {
                toast.success('Producto eliminado correctamente');
                setCurrentPage(1);
            },
            onError: () => {
                toast.error('Error al eliminar producto');
            },
        });
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Inventario de Productos" />
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {/* Header del Panel */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-gray-900">Panel de Control - Productos</h1>
                                <p className="mt-2 text-sm text-gray-600">Gestión de inventario para bodega de bebidas</p>
                            </div>
                            <div className="text-right">
                                <p className="text-sm text-gray-500">Última actualización</p>
                                <p className="text-lg font-semibold text-gray-900">
                                    {new Date().toLocaleDateString('es-EC', {
                                        weekday: 'long',
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                    })}
                                </p>
                            </div>
                        </div>
                        <div className="text-right">
                            <Link href={route('products.create')} className="">
                                <Button variant="outline" className="mr-2 hover:cursor-pointer">
                                    <Plus className="mr-2 h-4 w-4" />
                                    Crear Producto
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Panel de Filtros */}
                    <div className="mb-6 rounded-lg bg-white shadow">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-gray-900">Filtros de Búsqueda</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                                <div>
                                    <Label className="mb-2 block text-sm font-medium text-gray-700">Buscar producto</Label>
                                    <div className="relative">
                                        <Search className="absolute top-3 left-3 h-4 w-4 text-gray-400" />
                                        <Input
                                            type="text"
                                            placeholder="Nombre o descripción..."
                                            value={searchTerm}
                                            onChange={(e) => {
                                                setSearchTerm(e.target.value);
                                                setCurrentPage(1);
                                            }}
                                            className="block w-full rounded-md border border-gray-300 py-2 pr-3 pl-10 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label className="mb-2 block text-sm font-medium text-gray-700">Categoría</label>
                                    <Select
                                        value={categoryFilter}
                                        onValueChange={(value) => {
                                            setCategoryFilter(value);
                                            setCurrentPage(1);
                                        }}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Seleccionar categoría" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Todas las categorías</SelectItem>
                                            {categories.map((category) => (
                                                <SelectItem key={category.CategoriaId} value={category.Nombre}>
                                                    {category.Nombre}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div>
                                    <label className="mb-2 block text-sm font-medium text-gray-700">Estado de Stock</label>
                                    <Select
                                        value={stockFilter}
                                        onValueChange={(value) => {
                                            setStockFilter(value);
                                            setCurrentPage(1);
                                        }}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Seleccionar estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Todos los estados</SelectItem>
                                            <SelectItem value="in-stock">Con stock</SelectItem>
                                            <SelectItem value="low-stock">Stock bajo</SelectItem>
                                            <SelectItem value="out-of-stock">Sin stock</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div className="flex items-end">
                                    <Button
                                        className="hover:cursor-pointer"
                                        variant="outline"
                                        onClick={() => {
                                            setSearchTerm('');
                                            setCategoryFilter('all');
                                            setStockFilter('all');
                                            setCurrentPage(1);
                                        }}
                                    >
                                        Limpiar Filtros
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Tabla de Productos */}
                    <div className="rounded-lg bg-white shadow">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <h3 className="text-lg font-medium text-gray-900">Inventario de Productos ({filteredProducts.length})</h3>
                                <p className="text-sm text-gray-500">
                                    Mostrando {Math.min(startIndex + 1, filteredProducts.length)} -{' '}
                                    {Math.min(startIndex + itemsPerPage, filteredProducts.length)} de {filteredProducts.length}
                                </p>
                            </div>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Código</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Producto</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Categoría</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                            Precio Unitario
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Stock</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">
                                            Valor Total
                                        </th>
                                        <th className="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {paginatedProducts.length === 0 ? (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-12 text-center">
                                                <div className="text-gray-500">
                                                    <Package className="mx-auto mb-4 h-12 w-12 text-gray-400" />
                                                    <h3 className="mb-2 text-lg font-medium">No se encontraron productos</h3>
                                                    <p>Intenta ajustar los filtros de búsqueda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    ) : (
                                        paginatedProducts.map((product) => (
                                            <tr key={product.ProductoId} className="hover:bg-gray-50">
                                                <td className="px-6 py-4 font-mono text-sm whitespace-nowrap text-gray-900">
                                                    #{String(product.ProductoId).padStart(4, '0')}
                                                </td>
                                                <td className="px-6 py-4">
                                                    <div className="flex items-start space-x-3">
                                                        <div className="flex-shrink-0">
                                                            <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-100">
                                                                <picture>
                                                                    <source srcSet={product.Imagen} type="image/webp" />
                                                                    <img
                                                                        src={product.Imagen}
                                                                        alt={product.Nombre}
                                                                        className="h-10 w-10 object-cover"
                                                                    />
                                                                </picture>
                                                            </div>
                                                        </div>
                                                        <div className="min-w-0 flex-1">
                                                            <Link
                                                                href={route('product.show', product.ProductoId)}
                                                                className="block truncate text-sm font-medium text-gray-900 hover:text-blue-600"
                                                            >
                                                                {product.Nombre}
                                                            </Link>
                                                            <p className="mt-1 line-clamp-2 text-sm text-gray-500">{product.Descripcion}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">
                                                    <span className="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                        {getCategoryIcon(product.NombreCategoria)}
                                                        {product.NombreCategoria}
                                                    </span>
                                                </td>
                                                <td className="px-6 py-4 text-sm font-semibold whitespace-nowrap text-gray-900">
                                                    {formatPrice(product.Precio)}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">{getStockBadge(product.Stock)}</td>
                                                <td className="px-6 py-4 text-sm font-semibold whitespace-nowrap text-gray-900">
                                                    {formatPrice(product.Precio * product.Stock)}
                                                </td>
                                                <td className="flex items-center gap-2 px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                                    <Link
                                                        href={route('products.edit', product.ProductoId)}
                                                        className="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm leading-4 font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                                                    >
                                                        <Pen className="h-4 w-4" />
                                                    </Link>
                                                    <Dialog>
                                                        <DialogTrigger>
                                                            <Button
                                                                variant={product.Stock > 0 ? 'destructive' : 'outline'}
                                                                className="flex items-center justify-center hover:cursor-pointer"
                                                            >
                                                                <Trash className="h-4 w-4" />
                                                            </Button>
                                                        </DialogTrigger>
                                                        <DialogContent>
                                                            <DialogHeader>
                                                                <DialogTitle>Eliminar producto</DialogTitle>
                                                                <DialogDescription>
                                                                    ¿Estás seguro de que quieres eliminar este producto?
                                                                </DialogDescription>
                                                            </DialogHeader>
                                                            <DialogFooter>
                                                                <DialogClose asChild>
                                                                    <Button variant="outline">Cancelar</Button>
                                                                </DialogClose>
                                                                <Button variant="destructive" onClick={() => deleteProduct(product.ProductoId)}>
                                                                    Eliminar
                                                                </Button>
                                                            </DialogFooter>
                                                        </DialogContent>
                                                    </Dialog>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>

                        {/* Paginación */}
                        {totalPages > 1 && (
                            <div className="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
                                <div className="flex flex-1 justify-between sm:hidden">
                                    <button
                                        onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                                        disabled={currentPage === 1}
                                        className="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                                    >
                                        Anterior
                                    </button>
                                    <button
                                        onClick={() => setCurrentPage((prev) => Math.min(prev + 1, totalPages))}
                                        disabled={currentPage === totalPages}
                                        className="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50"
                                    >
                                        Siguiente
                                    </button>
                                </div>
                                <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                    <div>
                                        <p className="text-sm text-gray-700">
                                            Mostrando página <span className="font-medium">{currentPage}</span> de{' '}
                                            <span className="font-medium">{totalPages}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <nav className="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                            <button
                                                onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                                                disabled={currentPage === 1}
                                                className="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                                            >
                                                <span className="sr-only">Anterior</span>←
                                            </button>

                                            {Array.from({ length: Math.min(5, totalPages) }, (_, i) => {
                                                let pageNum;
                                                if (totalPages <= 5) {
                                                    pageNum = i + 1;
                                                } else if (currentPage <= 3) {
                                                    pageNum = i + 1;
                                                } else if (currentPage >= totalPages - 2) {
                                                    pageNum = totalPages - 4 + i;
                                                } else {
                                                    pageNum = currentPage - 2 + i;
                                                }

                                                return (
                                                    <button
                                                        key={pageNum}
                                                        onClick={() => setCurrentPage(pageNum)}
                                                        className={`relative inline-flex items-center border px-4 py-2 text-sm font-medium ${
                                                            currentPage === pageNum
                                                                ? 'z-10 border-blue-500 bg-blue-50 text-blue-600'
                                                                : 'border-gray-300 bg-white text-gray-500 hover:bg-gray-50'
                                                        }`}
                                                    >
                                                        {pageNum}
                                                    </button>
                                                );
                                            })}

                                            <button
                                                onClick={() => setCurrentPage((prev) => Math.min(prev + 1, totalPages))}
                                                disabled={currentPage === totalPages}
                                                className="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50"
                                            >
                                                <span className="sr-only">Siguiente</span>→
                                            </button>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
