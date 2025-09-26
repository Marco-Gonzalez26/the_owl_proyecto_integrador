import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, router, useForm } from '@inertiajs/react';
import { AlertTriangle, CheckCircle, LoaderCircle, Plus, Save, Star, Trash, X, XCircle } from 'lucide-react';
import { toast } from 'sonner';

const breadcrumbs = [
    {
        title: 'Panel de Control',
        href: '/the-owl/public/panel',
    },
    {
        title: 'Marcas',
        href: '/the-owl/public/panel/marca',
    },
    {
        title: 'Editar Marca',
        href: '/the-owl/public/panel/marca/editar',
    },
];

interface Brand {
    MarcaId: number;
    Nombre: string;
    Estado: number;
}
interface Size {
    TamanoId: number;
    Descripcion: string;
}
interface BrandSizeAssociation {
    MarcaId: number;
    TamanoId: number;
}

interface Props {
    brandToEdit: Brand;
    allSizes: Size[];
    associatedSizes: BrandSizeAssociation[];
}

export default function Edit({ brandToEdit, allSizes, associatedSizes }: Props) {
    const { data, setData, put, processing, errors } = useForm({
        Nombre: brandToEdit.Nombre,
        Estado: brandToEdit.Estado,
    });
    const handleToggleAssociation = (sizeId: number) => {
        const isAssociated = associatedSizes.some((assoc) => assoc.TamanoId === sizeId);

        if (isAssociated) {
            
            if (confirm('¿Estás seguro de que quieres quitar este tamaño de la marca?')) {
                router.delete(route('api.brand_sizes.destroy'), {
                    data: { MarcaId: brandToEdit.MarcaId, TamanoId: sizeId },
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => toast.success('Asociación eliminada.'),
                    onError: () => toast.error('Error al eliminar asociación.'),
                });
            }
        } else {
            // Si no está asociado, lo creamos
            router.post(
                route('api.brand_sizes.create'),
                {
                    MarcaId: brandToEdit.MarcaId,
                    TamanoId: sizeId,
                },
                {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => toast.success('Asociación creada.'),
                    onError: () => toast.error('Error al crear asociación.'),
                },
            );
        }
    };
    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        put(route('api.brands.update', brandToEdit.MarcaId), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Marca actualizada correctamente');

                router.push({ url: route('brands.index') });
            },
            onError: () => {
                toast.error('Error al actualizar marca');
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Marca" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Editar Marca</h1>
                                <p className="mt-2 text-sm text-neutral-600">Editar una marca para productos</p>
                            </div>
                            <Link
                                href={route('brands.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Información de la Marca */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Star className="mr-2 h-5 w-5" />
                                    Información de la Marca
                                </CardTitle>
                                <CardDescription>Información básica de la marca para identificar productos</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="nombre">Nombre de la Marca *</Label>
                                        <Input
                                            id="nombre"
                                            type="text"
                                            placeholder="Ej: Coca-Cola, Pepsi, Sprite, etc."
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
                                        <p className="text-sm text-neutral-500">{data.Nombre.length}/100 caracteres</p>
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="estado">Estado de la Marca *</Label>
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
                                        <p className="text-sm text-neutral-500">Las marcas inactivas no aparecen en el formulario de productos</p>
                                    </div>
                                </div>

                                <div className="rounded-lg border border-amber-200 bg-amber-50/75 p-4">
                                    <div className="flex items-start">
                                        <AlertTriangle className="mt-0.5 mr-2 h-4 w-4 flex-shrink-0 text-amber-700" />
                                        <div className="text-sm">
                                            <p className="mb-1 font-medium text-amber-800">Importante sobre el estado:</p>
                                            <ul className="space-y-1 text-amber-700">
                                                <li>
                                                    • Las marcas <strong>activas</strong> están disponibles para asignar a productos
                                                </li>
                                                <li>
                                                    • Las marcas <strong>inactivas</strong> no se pueden asignar a productos nuevos
                                                </li>
                                                <li>• Los productos existentes con marcas inactivas mantienen su asignación</li>
                                                <li>• Puedes asignar tamaños específicos a cada marca después de crearla</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Vista Previa de la Marca */}
                        {data.Nombre && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa de la Marca</CardTitle>
                                    <CardDescription>Así se verá la marca en el sistema</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-neutral-50 p-4">
                                        <div className="flex items-center space-x-3">
                                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-orange-100">
                                                <Star className="h-6 w-6 text-orange-600" />
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <h4 className="text-lg font-medium text-neutral-900">{data.Nombre}</h4>
                                                <p className="text-sm text-neutral-600">Marca de productos</p>
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

                        {/* Información adicional */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <AlertTriangle className="mr-2 h-5 w-5 text-blue-600" />
                                    ¿Qué puedes hacer después?
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="rounded-lg border border-blue-200 bg-blue-50/75 p-4">
                                    <div className="text-sm text-blue-700">
                                        <p className="mb-2 font-medium">Una vez creada la marca podrás:</p>
                                        <ul className="space-y-1">
                                            <li>
                                                • <strong>Asignar tamaños específicos</strong> que estarán disponibles para esta marca
                                            </li>
                                            <li>
                                                • <strong>Gestionar el estado</strong> de cada combinación marca-tamaño
                                            </li>
                                            <li>
                                                • <strong>Crear productos</strong> que pertenezcan a esta marca
                                            </li>
                                            <li>
                                                • <strong>Ver estadísticas</strong> de productos por marca
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>
                        {/*Tamaños para la marca */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Star className="mr-2 h-5 w-5" />
                                    Asignar Tamaños
                                </CardTitle>
                                <CardDescription>Selecciona los tamaños que estarán disponibles para esta marca.</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-4">
                                <div className="grid grid-cols-2 gap-4">
                                    {allSizes.map((size) => {
                                        const isAssociated = associatedSizes.some((assoc) => assoc.TamanoId === size.TamanoId);
                                        return (
                                            <div key={size.TamanoId} className="flex items-center justify-between rounded-md border p-4">
                                                <span>{size.Descripcion}</span>
                                                <Button
                                                    variant={isAssociated ? 'destructive' : 'default'}
                                                    type="button"
                                                    size="icon"
                                                    onClick={() => handleToggleAssociation(size.TamanoId)}
                                                >
                                                    {isAssociated ? <Trash className="h-4 w-4" /> : <Plus className="h-4 w-4" />}
                                                </Button>
                                            </div>
                                        );
                                    })}
                                </div>
                            </CardContent>
                        </Card>
                        {/* Botones de Acción */}
                        <Card>
                            <CardContent className="pt-6">
                                <div className="flex justify-end space-x-3">
                                    <Button variant="outline" type="button" asChild>
                                        <Link href={route('brands.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />
                                                Guardando Marca...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Guardar Marca
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
