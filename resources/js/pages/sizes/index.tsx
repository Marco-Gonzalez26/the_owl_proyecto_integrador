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
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { Package, Pen, Plus, Search, Trash } from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

type Size = {
    TamanoId: number;
    Valor: string;
    Descripcion: string;
    Activo: boolean;
    unidad_medida: {
        UnidadId: number;
        Descripcion: string;
        Abreviacion: string;
    };
};

const breadcrumbs = [
    {
        title: 'Panel de control',
        href: '/the-owl/public/panel',
    },
    {
        title: 'Tamaños',
        href: '/the-owl/public/panel/tamaños',
    },
];
export default function Index({ sizes }: { sizes: Size[] }) {
    console.log({ sizes });
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const { delete: destroy } = useForm();
    const itemsPerPage = 15;
    const filteredSizes = useMemo(() => {
        return sizes.filter((size) => {
            const matchesSearch =
                size.Descripcion.toLowerCase().includes(searchTerm.toLowerCase()) ||
                size.unidad_medida.Descripcion.toLowerCase().includes(searchTerm.toLowerCase()) ||
                size.unidad_medida.Abreviacion.toLowerCase().includes(searchTerm.toLowerCase());

            return matchesSearch;
        });
    }, [sizes, searchTerm]);

    const totalPages = Math.ceil(filteredSizes.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedSizes = filteredSizes.slice(startIndex, startIndex + itemsPerPage);

    const deleteSize = (id: number) => {
        destroy(`/the-owl/public/dashboard/api/sizes/${id}/delete`, {
            onSuccess: () => {
                toast.success('Tamaño eliminado correctamente');
                setCurrentPage(1);
            },
            onError: () => {
                toast.error('Error al eliminar tamaño');
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Inventario de Tamaños" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {/* Header del Panel */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Panel de Control - Tamaños</h1>
                                <p className="mt-2 text-sm text-neutral-600">Gestión de inventario para bodega de bebidas</p>
                            </div>
                            <div className="text-right">
                                <p className="text-sm text-neutral-500">Última actualización</p>
                                <p className="text-lg font-semibold text-neutral-900">
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
                            <Link href={route('sizes.create')} className="">
                                <Button variant="outline" className="mr-2 hover:cursor-pointer">
                                    <Plus className="mr-2 h-4 w-4" />
                                    Crear Tamaño
                                </Button>
                            </Link>
                        </div>
                    </div>

                    {/* Panel de Filtros */}
                    <div className="mb-6 rounded-lg bg-white shadow">
                        <div className="border-b border-neutral-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-neutral-900">Filtros de Búsqueda</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                                <div>
                                    <Label className="mb-2 block text-sm font-medium text-neutral-700">Buscar Tamaño</Label>
                                    <div className="relative">
                                        <Search className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                        <Input
                                            type="text"
                                            placeholder="Nombre o descripción..."
                                            value={searchTerm}
                                            onChange={(e) => {
                                                setSearchTerm(e.target.value);
                                                setCurrentPage(1);
                                            }}
                                            className="block w-full rounded-md border border-neutral-300 py-2 pr-3 pl-10 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        />
                                    </div>
                                </div>

                                <div className="flex items-end">
                                    <Button
                                        className="hover:cursor-pointer"
                                        variant="outline"
                                        onClick={() => {
                                            setSearchTerm('');
                                            setCurrentPage(1);
                                        }}
                                    >
                                        Limpiar Filtros
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Tabla de Marcas */}
                    <div className="rounded-lg bg-white shadow">
                        <div className="border-b border-neutral-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <h3 className="text-lg font-medium text-neutral-900">Inventario de Tamaños ({filteredSizes.length})</h3>
                                <p className="text-sm text-neutral-500">
                                    Mostrando {Math.min(startIndex + 1, filteredSizes.length)} -{' '}
                                    {Math.min(startIndex + itemsPerPage, filteredSizes.length)} de {filteredSizes.length}
                                </p>
                            </div>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-neutral-200">
                                <thead className="bg-neutral-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-neutral-500 uppercase">Código</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-neutral-500 uppercase">Tamaño</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-neutral-500 uppercase">
                                            Unidad de medida
                                        </th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-neutral-500 uppercase">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-neutral-200 bg-white">
                                    {paginatedSizes.length === 0 ? (
                                        <tr>
                                            <td colSpan={4} className="px-6 py-12 text-center">
                                                <div className="text-neutral-500">
                                                    <Package className="mx-auto mb-4 h-12 w-12 text-neutral-400" />
                                                    <h3 className="mb-2 text-lg font-medium">No se encontraron tamaños</h3>
                                                    <p>Intenta ajustar los filtros de búsqueda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    ) : (
                                        paginatedSizes.map((size) => (
                                            <tr key={size.TamanoId} className="hover:bg-neutral-50">
                                                <td className="px-6 py-4 font-mono text-sm whitespace-nowrap text-neutral-900">
                                                    #{String(size.TamanoId).padStart(4, '0')}
                                                </td>
                                                <td className="px-6 py-4 text-sm whitespace-nowrap text-neutral-900">{size.Valor}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{size.unidad_medida.Abreviacion}</td>
                                                <td className="flex items-center gap-2 px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                                    <Link
                                                        href={route('sizes.edit', size.TamanoId)}
                                                        className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-3 py-2 text-sm leading-4 font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                                                    >
                                                        <Pen className="h-4 w-4" />
                                                    </Link>
                                                    <Dialog>
                                                        <DialogTrigger>
                                                            <Button
                                                                variant={size.Activo ? 'destructive' : 'outline'}
                                                                className="flex items-center justify-center hover:cursor-pointer"
                                                            >
                                                                <Trash className="h-4 w-4" />
                                                            </Button>
                                                        </DialogTrigger>
                                                        <DialogContent>
                                                            <DialogHeader>
                                                                <DialogTitle>Eliminar tamaño</DialogTitle>
                                                                <DialogDescription>
                                                                    ¿Estás seguro de que quieres eliminar este tamaño?
                                                                </DialogDescription>
                                                            </DialogHeader>
                                                            <DialogFooter>
                                                                <DialogClose asChild>
                                                                    <Button variant="outline">Cancelar</Button>
                                                                </DialogClose>
                                                                <Button variant="destructive" onClick={() => deleteSize(size.TamanoId)}>
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
                            <div className="flex items-center justify-between border-t border-neutral-200 bg-white px-4 py-3 sm:px-6">
                                <div className="flex flex-1 justify-between sm:hidden">
                                    <button
                                        onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                                        disabled={currentPage === 1}
                                        className="relative inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 disabled:opacity-50"
                                    >
                                        Anterior
                                    </button>
                                    <button
                                        onClick={() => setCurrentPage((prev) => Math.min(prev + 1, totalPages))}
                                        disabled={currentPage === totalPages}
                                        className="relative ml-3 inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50 disabled:opacity-50"
                                    >
                                        Siguiente
                                    </button>
                                </div>
                                <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                    <div>
                                        <p className="text-sm text-neutral-700">
                                            Mostrando página <span className="font-medium">{currentPage}</span> de{' '}
                                            <span className="font-medium">{totalPages}</span>
                                        </p>
                                    </div>
                                    <div>
                                        <nav className="relative z-0 inline-flex -space-x-px rounded-md shadow-sm">
                                            <button
                                                onClick={() => setCurrentPage((prev) => Math.max(prev - 1, 1))}
                                                disabled={currentPage === 1}
                                                className="relative inline-flex items-center rounded-l-md border border-neutral-300 bg-white px-2 py-2 text-sm font-medium text-neutral-500 hover:bg-neutral-50 disabled:opacity-50"
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
                                                                : 'border-neutral-300 bg-white text-neutral-500 hover:bg-neutral-50'
                                                        }`}
                                                    >
                                                        {pageNum}
                                                    </button>
                                                );
                                            })}

                                            <button
                                                onClick={() => setCurrentPage((prev) => Math.min(prev + 1, totalPages))}
                                                disabled={currentPage === totalPages}
                                                className="relative inline-flex items-center rounded-r-md border border-neutral-300 bg-white px-2 py-2 text-sm font-medium text-neutral-500 hover:bg-neutral-50 disabled:opacity-50"
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
