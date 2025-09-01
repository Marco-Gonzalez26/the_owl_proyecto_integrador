import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { AlertTriangle, CheckCircle, LoaderCircle, Save, Tag, X, XCircle } from 'lucide-react';

type Category = {
    CategoriaId: number;
    Nombre: string;
    Estado?: boolean; // true = activa, false = inactiva
};

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/the-owl/public/dashboard',
    },
    {
        title: 'Categorías',
        href: '/the-owl/public/dashboard/categories',
    },
    {
        title: 'Editar Categoría',
        href: '/the-owl/public/dashboard/categories/edit',
    },
];

export default function EditCategory({ category }: { category: Category }) {
    const { data, setData, put, processing, errors } = useForm({
        name: category.Nombre,
        state: category.Estado ? 1 : 0, // Default a true si no está definido
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        console.log({ data });
        put(route('api.categories.update', category.CategoriaId), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: (response) => {
                console.log({ response });
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Editar Categoría" />
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-gray-900">Editar Categoría</h1>
                                <p className="mt-2 text-sm text-gray-600">Modifica la información de la categoría "{category.Nombre}"</p>
                            </div>
                            <Link
                                href={route('categories.index')}
                                className="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Información de la Categoría */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Tag className="mr-2 h-5 w-5" />
                                    Información de la Categoría
                                </CardTitle>
                                <CardDescription>Información básica de la categoría para organizar productos</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="nombre">Nombre de la Categoría *</Label>
                                        <Input
                                            id="nombre"
                                            type="text"
                                            placeholder="Ej: Bebidas Alcohólicas, Snacks, etc."
                                            value={data.name}
                                            onChange={(e) => setData('name', e.target.value)}
                                            className={errors.name ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.name && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.name}
                                            </p>
                                        )}
                                        <p className="text-sm text-gray-500">{data.name.length}/50 caracteres</p>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="estado">Estado de la Categoría *</Label>
                                        <Select
                                            value={data.state ? 'true' : 'false'}
                                            onValueChange={(value) => setData('state', value === 'true' ? 1 : 0)}
                                        >
                                            <SelectTrigger className={errors.state ? 'border-red-500 focus:ring-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar estado" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectItem value="true">
                                                    <div className="flex items-center">
                                                        <CheckCircle className="mr-2 h-4 w-4 text-green-600" />
                                                        Activa
                                                    </div>
                                                </SelectItem>
                                                <SelectItem value="false">
                                                    <div className="flex items-center">
                                                        <XCircle className="mr-2 h-4 w-4 text-red-600" />
                                                        Inactiva
                                                    </div>
                                                </SelectItem>
                                            </SelectContent>
                                        </Select>
                                        {errors.state && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.state}
                                            </p>
                                        )}
                                        <p className="text-sm text-gray-500">Las categorías inactivas no aparecen en el formulario de productos</p>
                                    </div>
                                </div>

                                <div className="rounded-lg border border-amber-200 bg-amber-50/75 p-4">
                                    <div className="flex items-start">
                                        <AlertTriangle className="mt-0.5 mr-2 h-4 w-4 flex-shrink-0 text-amber-700" />
                                        <div className="text-sm">
                                            <p className="mb-1 font-medium text-amber-800">Importante sobre el estado:</p>
                                            <ul className="space-y-1 text-amber-700">
                                                <li>
                                                    • Las categorías <strong>activas</strong> están disponibles para asignar a productos
                                                </li>
                                                <li>
                                                    • Las categorías <strong>inactivas</strong> no se pueden asignar a productos nuevos
                                                </li>
                                                <li>• Los productos existentes con categorías inactivas mantienen su asignación</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Vista Previa de la Categoría Actualizada*/}
                        {data.name && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa de la Categoría</CardTitle>
                                    <CardDescription>Así se verá la categoría en el sistema</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-gray-50 p-4">
                                        <div className="flex items-center space-x-3">
                                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                                <Tag className="h-6 w-6 text-blue-600" />
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <h4 className="text-lg font-medium text-gray-900">{data.name}</h4>
                                                <p className="text-sm text-gray-600">ID: {category.CategoriaId}</p>
                                            </div>

                                            <div className="flex-shrink-0">
                                                {data.state ? (
                                                    <span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                        Activa
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                                                        Inactiva
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Información Adicional */}
                        <Card>
                            <CardHeader>
                                <CardTitle>Información del Sistema</CardTitle>
                                <CardDescription>Datos técnicos de la categoría (solo lectura)</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div className="rounded-lg border border-gray-200 bg-gray-50 p-3">
                                        <span className="mb-1 block text-sm font-medium text-gray-700">ID de Categoría:</span>
                                        <p className="text-lg font-semibold text-gray-900">{category.CategoriaId}</p>
                                    </div>
                                    <div className="rounded-lg border border-gray-200 bg-gray-50 p-3">
                                        <span className="mb-1 block text-sm font-medium text-gray-700">Estado:</span>

                                        {data.state ? (
                                            <p className="text-lg font-semibold text-green-600">Activa</p>
                                        ) : (
                                            <p className="text-lg font-semibold text-red-600">Inactiva</p>
                                        )}
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Botones de Acción */}
                        <Card>
                            <CardContent className="pt-6">
                                <div className="flex justify-end space-x-3">
                                    <Button variant="outline" type="button" asChild>
                                        <Link href={route('categories.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />
                                                Actualizando Categoría...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Actualizar Categoría
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
