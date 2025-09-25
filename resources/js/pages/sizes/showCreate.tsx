import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { AlertTriangle, LoaderCircle, Ruler, Save, X } from 'lucide-react';
import { toast } from 'sonner';

const breadcrumbs = [
    {
        title: 'Panel',
        href: '/the-owl/public/panel',
    },
    {
        title: 'Tamaños',
        href: '/the-owl/public/panel/tamaños',
    },
    {
        title: 'Crear Tamaño',
        href: '/the-owl/public/panel/tamaños/crear',
    },
];

interface MeasureUnit {
    UnidadId: number;
    Descripcion: string;
    Abreviacion: string;
}

interface Props {
    measureUnits: MeasureUnit[];
}

export default function CreateSize({ measureUnits }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        Descripcion: '',
        UnidadMedida: '',
        Valor: '',
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('api.sizes.create'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Tamaño creado correctamente');

                setData('Descripcion', '');
                setData('UnidadMedida', '');
                setData('Valor', '');
            },
            onError: (response) => {
                console.log({ response });
                toast.error('Error al crear tamaño');
            },
        });
    };

    const getSelectedUnit = () => {
        return measureUnits.find((unit) => unit.UnidadId.toString() === data.UnidadMedida);
    };

    const formatPreviewDescription = () => {
        const selectedUnit = getSelectedUnit();
        if (!data.Valor || !selectedUnit) return data.Descripcion;

        return `${data.Descripcion} (${data.Valor} ${selectedUnit.Abreviacion})`;
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Crear Tamaño" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Crear Tamaño</h1>
                                <p className="mt-2 text-sm text-neutral-600">Crear un nuevo tamaño para productos</p>
                            </div>
                            <Link
                                href={route('sizes.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Cancelar
                            </Link>
                        </div>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
                        {/* Información del Tamaño */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Ruler className="mr-2 h-5 w-5" />
                                    Información del Tamaño
                                </CardTitle>
                                <CardDescription>Información básica del tamaño para clasificar productos</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6">
                                    {/* Descripción */}
                                    <div className="space-y-2">
                                        <Label htmlFor="descripcion">Descripción del Tamaño *</Label>
                                        <Input
                                            id="descripcion"
                                            type="text"
                                            placeholder="Ej: Pequeño, Mediano, Grande, Familiar, etc."
                                            value={data.Descripcion}
                                            onChange={(e) => setData('Descripcion', e.target.value)}
                                            className={errors.Descripcion ? 'border-red-500 focus:ring-red-500' : ''}
                                        />
                                        {errors.Descripcion && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Descripcion}
                                            </p>
                                        )}
                                        <p className="text-sm text-neutral-500">{data.Descripcion.length}/100 caracteres</p>
                                    </div>

                                    <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                        {/* Valor */}
                                        <div className="space-y-2">
                                            <Label htmlFor="valor">Valor Numérico *</Label>
                                            <Input
                                                id="valor"
                                                type="number"
                                                step="0.01"
                                                min="1"
                                                placeholder="Ej: 250, 500, 1.5, etc."
                                                value={data.Valor}
                                                onChange={(e) => setData('Valor', e.target.value)}
                                                className={errors.Valor ? 'border-red-500 focus:ring-red-500' : ''}
                                            />
                                            {errors.Valor && (
                                                <p className="flex items-center text-sm text-red-600">
                                                    <AlertTriangle className="mr-1 h-4 w-4" />
                                                    {errors.Valor}
                                                </p>
                                            )}
                                            <p className="text-sm text-neutral-500">Valor numérico del tamaño (acepta decimales)</p>
                                        </div>

                                        {/* Unidad de Medida */}
                                        <div className="space-y-2">
                                            <Label htmlFor="unidad">Unidad de Medida *</Label>
                                            <Select value={data.UnidadMedida} onValueChange={(value) => setData('UnidadMedida', value)}>
                                                <SelectTrigger className={errors.UnidadMedida ? 'border-red-500 focus:ring-red-500' : ''}>
                                                    <SelectValue placeholder="Seleccionar unidad" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    {measureUnits.map((unit) => (
                                                        <SelectItem key={unit.UnidadId} value={unit.UnidadId.toString()}>
                                                            <div className="flex w-full items-center justify-between">
                                                                <span>{unit.Descripcion}</span>
                                                                <span className="ml-2 text-sm text-neutral-500">({unit.Abreviacion})</span>
                                                            </div>
                                                        </SelectItem>
                                                    ))}
                                                </SelectContent>
                                            </Select>
                                            {errors.UnidadMedida && (
                                                <p className="flex items-center text-sm text-red-600">
                                                    <AlertTriangle className="mr-1 h-4 w-4" />
                                                    {errors.UnidadMedida}
                                                </p>
                                            )}
                                            <p className="text-sm text-neutral-500">Unidad para medir el tamaño (ml, lts, oz)</p>
                                        </div>
                                    </div>
                                </div>

                                <div className="rounded-lg border border-blue-200 bg-blue-50/75 p-4">
                                    <div className="flex items-start">
                                        <AlertTriangle className="mt-0.5 mr-2 h-4 w-4 flex-shrink-0 text-blue-700" />
                                        <div className="text-sm">
                                            <p className="mb-1 font-medium text-blue-800">Información sobre tamaños:</p>
                                            <ul className="space-y-1 text-blue-700">
                                                <li>
                                                    • La <strong>descripción</strong> es el nombre que verán los usuarios (Ej: "Grande", "Familiar")
                                                </li>
                                                <li>
                                                    • El <strong>valor</strong> es la cantidad numérica (Ej: 500 para 500ml)
                                                </li>
                                                <li>
                                                    • La <strong>unidad de medida</strong> especifica el tipo de medición (ml, L, g, kg, etc.)
                                                </li>
                                                <li>• Juntos forman la descripción completa: "Grande (500 ml)"</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </CardContent>
                        </Card>

                        {/* Vista Previa del Tamaño */}
                        {(data.Descripcion || data.Valor) && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>Vista Previa del Tamaño</CardTitle>
                                    <CardDescription>Así se verá el tamaño en el sistema</CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <div className="rounded-lg border bg-neutral-50 p-4">
                                        <div className="flex items-center space-x-3">
                                            <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100">
                                                <Ruler className="h-6 w-6 text-purple-600" />
                                            </div>
                                            <div className="min-w-0 flex-1">
                                                <h4 className="text-lg font-medium text-neutral-900">
                                                    {formatPreviewDescription() || 'Nombre del tamaño'}
                                                </h4>
                                                {data.Valor && getSelectedUnit() && (
                                                    <p className="text-sm text-neutral-600">
                                                        Valor: {data.Valor} {getSelectedUnit()?.Abreviacion}
                                                    </p>
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
                                        <Link href={route('sizes.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <LoaderCircle className="mr-2 h-4 w-4 animate-spin" />
                                                Guardando Tamaño...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Guardar Tamaño
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
