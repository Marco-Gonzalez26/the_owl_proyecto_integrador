import { ProductCard } from '@/components/product-card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useCart } from '@/hooks/use-cart';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Head } from '@inertiajs/react';

import { Filter, Grid, List, Search, X } from 'lucide-react';
import { useMemo, useState } from 'react';

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
type Category = {
    CategoriaId: number;
    Estado: number;
    Nombre: string;
};

type CatalogProps = {
    products: Product[];
    categories: Category[];
};
export default function Catalog({ products, categories }: CatalogProps) {
    // Estados para filtros
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedCategory, setSelectedCategory] = useState('');
    const [priceRange, setPriceRange] = useState({ min: '', max: '' });
    const [viewMode, setViewMode] = useState('grid');
    const [showFilters, setShowFilters] = useState(false);
    const { cart, addToCart, removeFromCart } = useCart();
    const activeCategories = categories.filter((category) => category.Estado);
    console.log({ cart });
    // Función para limpiar filtros
    const clearFilters = () => {
        setSearchTerm('');
        setSelectedCategory('');
        setPriceRange({ min: '', max: '' });
    };

    // Productos filtrados
    const filteredProducts = useMemo(() => {
        return products.filter((product) => {
            // Filtro por término de búsqueda
            const matchesSearch =
                !searchTerm ||
                product.Nombre?.toLowerCase().includes(searchTerm.toLowerCase()) ||
                product.Descripcion?.toLowerCase().includes(searchTerm.toLowerCase());

            // Filtro por categoría
            const matchesCategory =
                !selectedCategory || product.CategoriaId?.toString() === selectedCategory || product.NombreCategoria === selectedCategory;

            // Filtro por precio
            const productPrice = product.Precio || 0;
            const minPrice = priceRange.min ? parseFloat(priceRange.min) : 0;
            const maxPrice = priceRange.max ? parseFloat(priceRange.max) : Infinity;
            const matchesPrice = productPrice >= minPrice && productPrice <= maxPrice;

            return matchesSearch && matchesCategory && matchesPrice;
        });
    }, [products, searchTerm, selectedCategory, priceRange]);

    // Obtener rango de precios
    const priceStats = useMemo(() => {
        const prices = products.map((p) => parseFloat(p.Precio || 0)).filter((p) => p > 0);
        return {
            min: Math.min(...prices) || 0,
            max: Math.max(...prices) || 1000,
        };
    }, [products]);

    return (
        <AppHeaderLayout>
            <Head title="Catálogo de Productos" />
            <div className="min-h-screen">
                <div className="border-b bg-white">
                    <div className="mx-auto max-w-7xl px-2 py-4">
                        <div className="flex flex-col md:flex-row md:items-center md:justify-between">
                            <h1 className="mb-4 text-xl font-bold text-neutral-900 md:mb-0">Catálogo de Productos</h1>
                            <div className="flex items-center space-x-4">
                                <span className="text-sm text-neutral-600">
                                    {filteredProducts.length} producto{filteredProducts.length !== 1 ? 's' : ''}
                                </span>

                                <div className="flex rounded-lg bg-neutral-200 p-1">
                                    <button
                                        onClick={() => setViewMode('grid')}
                                        className={`rounded-md p-2 transition-colors ${
                                            viewMode === 'grid' ? 'bg-white text-blue-600 shadow-sm' : 'text-neutral-600 hover:text-neutral-900'
                                        }`}
                                    >
                                        <Grid size={20} />
                                    </button>
                                    <button
                                        onClick={() => setViewMode('list')}
                                        className={`rounded-md p-2 transition-colors ${
                                            viewMode === 'list' ? 'bg-white text-blue-600 shadow-sm' : 'text-neutral-600 hover:text-neutral-900'
                                        }`}
                                    >
                                        <List size={20} />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="mx-auto max-w-7xl px-4 py-8">
                    <div className="flex flex-col gap-8 lg:flex-row">
                        <div className="lg:w-64">
                            <Button
                                onClick={() => setShowFilters(!showFilters)}
                                className="mb-4 flex w-full items-center justify-between rounded-lg border bg-white p-4 shadow-sm lg:hidden text-neutral-700"
                            >
                                <span className="flex items-center font-medium">
                                    <Filter size={20} className="mr-2" />
                                    Filtros
                                </span>
                                <X size={20} className={`transform transition-transform ${showFilters ? 'rotate-180' : ''}`} />
                            </Button>

                            <div className={`space-y-6 rounded-lg border bg-white p-6 shadow-sm ${showFilters || 'hidden lg:block'}`}>
                                <div>
                                    <Label className="mb-2 block text-sm font-medium text-neutral-700">Buscar productos</Label>
                                    <div className="relative">
                                        <Search size={20} className="absolute top-1/2 left-3 -translate-y-1/2 transform text-neutral-400" />
                                        <Input
                                            type="text"
                                            placeholder="Nombre, descripción..."
                                            value={searchTerm}
                                            onChange={(e) => setSearchTerm(e.target.value)}
                                            className="w-full rounded-lg border border-neutral-300 py-2 pr-4 pl-10 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                        />
                                    </div>
                                </div>

                                <div className="text-neutral-700">
                                    <Label className="mb-2 block text-sm font-medium text-neutral-700">Categoría</Label>
                                    <Select
                                        onValueChange={(value) => {
                                            setSelectedCategory(value);
                                        }}
                                    >
                                        <SelectTrigger className="w-full">
                                            <SelectValue placeholder="Todas las categorías" className="text-sm" />
                                        </SelectTrigger>
                                        <SelectContent className="bg-white text-neutral-700">
                                            {activeCategories.map((category) => (
                                                <SelectItem
                                                    key={category.CategoriaId}
                                                    value={category.Nombre}
                                                    className="bg-white text-neutral-700 hover:bg-blue-500 hover:text-white"
                                                >
                                                    {category.Nombre}
                                                </SelectItem>
                                            ))}
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div>
                                    <Label className="mb-2 block text-sm font-medium text-neutral-700">Rango de precio</Label>
                                    <div className="flex space-x-2">
                                        <Input
                                            type="number"
                                            placeholder={`Mín: ${priceStats.min}`}
                                            value={priceRange.min}
                                            onChange={(e) => setPriceRange((prev) => ({ ...prev, min: e.target.value }))}
                                            className="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                        />
                                        <Input
                                            type="number"
                                            placeholder={`Máx: ${priceStats.max}`}
                                            value={priceRange.max}
                                            onChange={(e) => setPriceRange((prev) => ({ ...prev, max: e.target.value }))}
                                            className="w-full rounded-lg border border-neutral-300 px-3 py-2 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                        />
                                    </div>
                                </div>

                                <Button
                                    onClick={clearFilters}
                                    className="w-full rounded-lg border px-4 py-2 text-sm text-white transition-transform hover:cursor-pointer hover:shadow-md active:scale-95"
                                >
                                    Limpiar filtros
                                </Button>
                            </div>
                        </div>
                        <div className="flex-1">
                            {filteredProducts.length === 0 ? (
                                <div className="py-12 text-center">
                                    <div className="mb-4 text-neutral-400">
                                        <Search size={48} className="mx-auto" />
                                    </div>
                                    <h3 className="mb-2 text-lg font-medium text-neutral-900">No se encontraron productos</h3>
                                    <p className="text-neutral-600">Intenta ajustar los filtros o términos de búsqueda</p>
                                </div>
                            ) : (
                                <div
                                    className={
                                        viewMode === 'grid' ? 'grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4' : 'space-y-4'
                                    }
                                >
                                    {filteredProducts.map((product) => (
                                        <ProductCard key={product.ProductoId} product={product} viewMode={viewMode} />
                                    ))}
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AppHeaderLayout>
    );
}
