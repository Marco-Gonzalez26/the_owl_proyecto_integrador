import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { AlertTriangle, CheckCircle, LoaderCircle, Save, Tag, X, XCircle } from 'lucide-react';
import { toast } from 'sonner';

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

export default function CreateCategory() {
    const { data, setData, post, processing, errors } = useForm({
        Nombre: '',
        Estado: 0,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('api.categories.create'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Categoría creada correctamente');

                setData('Nombre', '');
                setData('Estado', 0);

                router.push({ url: route('categories.index') });
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Categoría" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Crear Categoría</h1>
                                <p className="mt-2 text-sm text-neutral-600">Crear una nueva categoría</p>
                            </div>
                            <Link
                                href={route('categories.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
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
                                            placeholder="Ej: Bebidas Energéticas, Bebidas Azucaradas, etc."
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
                                        <p className="text-sm text-neutral-500">{data.Nombre.length}/50 caracteres</p>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="estado">Estado de la Categoría *</Label>
                                        <Select
                                            value={data.Estado ? 'true' : 'false'}
                                            onValueChange={(value) => setData('Estado', value === 'true' ? 1 : 0)}
                                        >
                                            <SelectTrigger className={errors.Estado ? 'border-red-500 focus:ring-red-500' : ''}>
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
                                        {errors.Estado && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Estado}
                                            </p>
                                        )}
                                        <p className="text-sm text-neutral-500">Las categorías inactivas no aparecen en el formulario de productos</p>
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

                        {/* Vista Previa de la Categoría a crear*/}
                        {data.Nombre && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa de la Categoría</CardTitle>
                                    <CardDescription>Así se verá la categoría en el sistema</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-neutral-50 p-4">
                                        <div className="flex items-center space-x-3">
                                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100">
                                                <Tag className="h-6 w-6 text-blue-600" />
                                            </div>
                                            <div className="min-w-0 flex-1 text-sm">
                                                <h4 className="text-lg font-medium text-neutral-900">{data.Nombre || ''}</h4>
                                            </div>

                                            <div className="flex-shrink-0">
                                                {data.Estado ? (
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
                                                Guardando Categoría...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Guardar Categoría
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
