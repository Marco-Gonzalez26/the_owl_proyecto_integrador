import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { AlertTriangle, DollarSign, Hash, LoaderCircle, Package, Save, Upload, X } from 'lucide-react';
import { useEffect, useState } from 'react';

type Product = {
    ProductoId: number;
    Nombre: string;
    Descripcion: string;
    Precio: number;
    Stock: number;
    Imagen: string;
    CategoriaId: number;
    NombreCategoria: string;
    MarcaId: number;
    TamanoId: number;
    PrecioMayorista: string;
    MinimoMayorista: string;
};

const breadcrumbs = [
    {
        title: 'Panel de Control',
        href: '/the-owl/public/panel',
    },
    {
        title: 'Productos',
        href: '/the-owl/public/panel/productos',
    },
    {
        title: 'Crear Producto',
        href: '/the-owl/public/panel/productos/crear',
    },
];
export default function Edit() {
    const { categories, brands, product } = usePage().props;

    const typedProduct = product as Product;
    const { data, setData, processing, errors, put } = useForm({
        Nombre: typedProduct.Nombre,
        Descripcion: typedProduct.Descripcion,
        Precio: typedProduct.Precio,
        Stock: typedProduct.Stock,
        Imagen: typedProduct.Imagen,
        CategoriaId: typedProduct.CategoriaId,
        MarcaId: typedProduct.MarcaId,
        TamanoId: typedProduct.TamanoId,
        PrecioMayorista: typedProduct.PrecioMayorista,
        MinimoMayorista: typedProduct.MinimoMayorista,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(route('api.products.update', product.ProductoId), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (response) => {
                console.log({ response });
            },
        });
    };
    const [availableSizes, setAvailableSizes] = useState([]);
    const fetchSizes = async () => {
        try {
            const response = await fetch(route('api.brands.sizes.by-brand', { brandId: data.MarcaId }));
            const sizesData = await response.json();
            setAvailableSizes(sizesData);

            setData('TamanoId', data.TamanoId);
        } catch (error) {
            console.error('Error fetching sizes:', error);
            setAvailableSizes([]);
            setData('TamanoId', '');
        }
    };

    useEffect(() => {
        if (data.MarcaId) {
            fetchSizes();
        } else {
            setAvailableSizes([]);
            setData('TamanoId', '');
        }
    }, [data.MarcaId]);

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('Imagen', file);
        }
    };

    const selectedCategory = categories.find((cat) => cat.CategoriaId === parseInt(data.CategoriaId));
    const totalValue = data.Precio && data.Stock ? (parseFloat(data.Precio) * parseInt(data.Stock)).toFixed(2) : '0.00';

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Inventario de Productos" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Editar Producto</h1>
                                <p className="mt-2 text-sm text-neutral-600"> Edita el producto seleccionado</p>
                            </div>
                            <Link
                                href={route('products.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Información Básica */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Package className="mr-2 h-5 w-5" />
                                    Información del Producto
                                </CardTitle>
                                <CardDescription>Información básica del producto para la bodega</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="nombre">Nombre del Producto *</Label>
                                        <Input
                                            id="nombre"
                                            type="text"
                                            placeholder="Ej: Cerveza Pilsener 330ml"
                                            value={data.Nombre}
                                            onChange={(e) => setData('Nombre', e.target.value)}
                                            className={errors.Nombre ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.Nombre && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Nombre}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="categoria">Categoría *</Label>
                                        <Select
                                            value={data.CategoriaId.toString()}
                                            onValueChange={(value) => setData('CategoriaId', parseInt(value))}
                                        >
                                            <SelectTrigger className={errors.CategoriaId ? 'border-red-500 focus:ring-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar categoría" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {categories.map((category) => (
                                                    <SelectItem key={category.id} value={category.CategoriaId.toString().toLowerCase()}>
                                                        {category.Nombre}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.CategoriaId && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.CategoriaId}
                                            </p>
                                        )}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="marca">Marca</Label>
                                        <Select value={data.MarcaId.toString()} onValueChange={(value) => setData('MarcaId', value)}>
                                            <SelectTrigger className={errors.MarcaId ? 'border-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar marca" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {brands.map((brand) => (
                                                    <SelectItem key={brand.MarcaId} value={brand.MarcaId.toString()}>
                                                        {brand.Nombre}
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.MarcaId && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.MarcaId}
                                            </p>
                                        )}
                                    </div>

                                    {/* Select de Tamaño */}
                                    <div className="space-y-2">
                                        <Label htmlFor="tamano">Tamaño</Label>
                                        <Select
                                            value={data.TamanoId.toString()}
                                            onValueChange={(value) => setData('TamanoId', parseInt(value))}
                                            disabled={!data.MarcaId || availableSizes.length === 0}
                                        >
                                            <SelectTrigger className={errors.TamanoId ? 'border-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar tamaño" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {availableSizes.map((size) => (
                                                    <SelectItem key={size.TamanoId} value={size.TamanoId.toString()}>
                                                        {size.Descripcion} - ({size.Valor}
                                                        {size.unidad_medida.Abreviacion})
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.TamanoId && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.TamanoId}
                                            </p>
                                        )}
                                    </div>
                                    <div className="space-y-2 md:col-span-2">
                                        <Label htmlFor="descripcion">Descripción *</Label>
                                        <Textarea
                                            id="descripcion"
                                            placeholder="Describe el producto, sus características, origen, etc."
                                            rows={4}
                                            value={data.Descripcion}
                                            onChange={(e) => setData('Descripcion', e.target.value)}
                                            className={errors.Descripcion ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        <div className="flex items-center justify-between">
                                            {errors.Descripcion && (
                                                <p className="flex items-center text-sm text-red-600">
                                                    <AlertTriangle className="mr-1 h-4 w-4" />
                                                    {errors.Descripcion}
                                                </p>
                                            )}
                                            <p className="ml-auto text-sm text-neutral-500">{data.Descripcion.length}/500 caracteres</p>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Precio e Inventario */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <DollarSign className="mr-2 h-5 w-5" />
                                    Precio e Inventario
                                </CardTitle>
                                <CardDescription>Información financiera y de stock del producto</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="precio">Precio Unitario (USD) *</Label>
                                        <div className="relative">
                                            <DollarSign className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="precio"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                placeholder="0.00"
                                                value={data.Precio}
                                                onChange={(e) => setData('Precio', e.target.value)}
                                                className={`pl-10 ${errors.Precio ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.Precio && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Precio}
                                            </p>
                                        )}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="precio">Precio Unitario Mayorista (USD) *</Label>
                                        <div className="relative">
                                            <DollarSign className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="precio"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                placeholder="0.00"
                                                value={data.PrecioMayorista}
                                                onChange={(e) => setData('PrecioMayorista', e.target.value)}
                                                className={`pl-10 ${errors.Precio ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.PrecioMayorista && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.PrecioMayorista}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="stock">Stock Inicial *</Label>
                                        <div className="relative">
                                            <Hash className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="stock"
                                                type="number"
                                                min="0"
                                                placeholder="0"
                                                value={data.Stock}
                                                onChange={(e) => setData('Stock', e.target.value)}
                                                className={`pl-10 ${errors.Stock ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.Stock && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Stock}
                                            </p>
                                        )}
                                    </div>
                                    <div className="space-y-2">
                                        <Label htmlFor="seller-minimum-qty">Minima Cantidad Mayorista *</Label>
                                        <div className="relative">
                                            <Hash className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                            <Input
                                                id="seller-minimum-qty"
                                                type="number"
                                                min="0"
                                                placeholder="0"
                                                value={data.MinimoMayorista}
                                                onChange={(e) => setData('MinimoMayorista', e.target.value)}
                                                className={`pl-10 ${errors.MinimoMayorista ? 'border-red-500 focus:ring-red-500' : ''}`}
                                            />
                                        </div>
                                        {errors.MinimoMayorista && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.MinimoMayorista}
                                            </p>
                                        )}
                                    </div>
                                    {/* Resumen de cálculo */}
                                    {data.Precio && data.Stock && (
                                        <div className="rounded-lg border border-blue-200 bg-blue-50 p-4 md:col-span-2">
                                            <h4 className="mb-3 flex items-center text-sm font-medium text-blue-900">
                                                <DollarSign className="mr-1 h-4 w-4" />
                                                Resumen del Inventario
                                            </h4>
                                            <div className="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
                                                <div className="rounded bg-white p-3">
                                                    <span className="mb-1 block text-blue-700">Precio por unidad:</span>
                                                    <p className="text-lg font-semibold text-blue-900">${parseFloat(data.Precio || 0).toFixed(2)}</p>
                                                </div>
                                                <div className="rounded bg-white p-3">
                                                    <span className="mb-1 block text-blue-700">Stock inicial:</span>
                                                    <p className="text-lg font-semibold text-blue-900">{parseInt(data.Stock || 0)} unidades</p>
                                                </div>
                                                <div className="rounded bg-white p-3">
                                                    <span className="mb-1 block text-blue-700">Valor total:</span>
                                                    <p className="text-lg font-semibold text-blue-900">${totalValue}</p>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Imagen del Producto */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Upload className="mr-2 h-5 w-5" />
                                    Imagen del Producto
                                </CardTitle>
                                <CardDescription>Sube una imagen representativa del producto</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="space-y-4">
                                    <div className="space-y-2">
                                        <Label htmlFor="imagen">Subir Imagen</Label>
                                        <div className="flex w-full items-center justify-center">
                                            <label className="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-neutral-300 bg-neutral-50 transition-colors hover:bg-neutral-100">
                                                <div className="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <Upload className="mb-2 h-8 w-8 text-neutral-400" />
                                                    <p className="mb-2 text-sm text-neutral-500">
                                                        <span className="font-semibold">Clic para subir</span> o arrastra y suelta
                                                    </p>
                                                    <p className="text-xs text-neutral-500">PNG, JPG o JPEG (MAX. 2MB)</p>
                                                </div>
                                                <input id="imagen" type="file" accept="image/*" className="hidden" onChange={handleImageChange} />
                                            </label>
                                        </div>
                                        {errors.Imagen && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Imagen}
                                            </p>
                                        )}
                                    </div>

                                    {data.Imagen && typeof data.Imagen === 'object' && (
                                        <div className="rounded-lg border border-green-200 bg-green-50 p-3">
                                            <p className="flex items-center text-sm text-green-800">
                                                <Upload className="mr-2 h-4 w-4" />
                                                Archivo seleccionado: {data.Imagen.name}
                                            </p>
                                        </div>
                                    )}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Vista Previa del Producto */}
                        {(data.Nombre || data.Descripcion || selectedCategory) && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa del Producto</CardTitle>
                                    <CardDescription>Así se verá el producto en el inventario</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-neutral-50 p-4">
                                        <div className="flex items-start space-x-4">
                                            <div className="flex-shrink-0">
                                                <div className="flex h-16 w-16 items-center justify-center rounded-lg bg-neutral-200">
                                                    <Package className="h-6 w-6 text-neutral-400" />
                                                </div>
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <h4 className="mb-2 text-lg font-medium text-neutral-900">{data.Nombre || 'Nombre del producto'}</h4>
                                                {selectedCategory && (
                                                    <span className="mb-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                                        {selectedCategory.Nombre}
                                                    </span>
                                                )}
                                                <p className="mb-3 text-sm text-neutral-600">
                                                    {data.Descripcion || 'Descripción del producto aparecerá aquí...'}
                                                </p>
                                                <div className="flex items-center space-x-4">
                                                    {data.Precio && (
                                                        <span className="text-lg font-semibold text-neutral-900">
                                                            ${parseFloat(data.Precio).toFixed(2)}
                                                        </span>
                                                    )}
                                                    {data.Stock && (
                                                        <span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                            Stock: {data.Stock} unidades
                                                        </span>
                                                    )}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Botones de Acción */}
                        <Card>
                            <CardContent className="pt-6">
                                <div className="flex justify-end space-x-3">
                                    <Button variant="outline" type="button" asChild>
                                        <Link href={route('products.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <div className="mr-2 -ml-1 h-4 w-4 rounded-full border-2 border-white border-t-transparent disabled:opacity-75"></div>
                                                <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />
                                                Editando Producto...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Editar Producto
                                            </>
                                        )}
                                    </Button>
                                </div>
                            </CardContent>
                        </Card>
                    </form>
                </div>
            </div>
        </AppLayout>
    );
}
