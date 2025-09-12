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
import { Tooltip, TooltipContent, TooltipTrigger } from '@/components/ui/tooltip';

import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { BookmarkX, Check, Pen, Plus, Search, Trash } from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

type Category = {
    CategoriaId: number;
    Nombre: string;
    Estado: number;
};

const breadcrumbs: any[] = [
    {
        title: 'Dashboard',
        href: '/the-owl/public/dashboard',
    },
    {
        title: 'Categorias',
        href: '/the-owl/public/dashboard/categories',
    },
];
export default function Index({ categories }: { categories: Category[] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [currentPage, setCurrentPage] = useState(1);
    const { processing, delete: destroy, put } = useForm();
    const itemsPerPage = 15;

    const filteredCategories = useMemo(() => {
        return categories.filter((category: Category) => {
            const matchesSearch = category.Nombre.toLowerCase().includes(searchTerm.toLowerCase());

            return matchesSearch;
        });
    }, [categories, searchTerm]);
    const totalPages = Math.ceil(filteredCategories.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedCategories = filteredCategories.slice(startIndex, startIndex + itemsPerPage);

    const deleteCategory = (id: number) => {
        destroy(route('api.categories.destroy', id), {
            onSuccess: () => {
                toast.success('Categoria desactivada correctamente');
                setCurrentPage(1);
                setSearchTerm('');
            },
            onError: () => {
                toast.error('Error al desactivar categoria');
            },
        });
    };

    const activateCategory = (id: number) => {
        put(route('api.categories.update', id), {
            preserveScroll: true,
            onSuccess: () => {
                toast.success('Categoria activada correctamente');
                setCurrentPage(1);
                setSearchTerm('');
            },
            onError: () => {
                toast.error('Error al activar categoria');
            },
        });
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categorias" />
            <div className="min-h-screen bg-gray-50">
                <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {/* Header del Panel */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-gray-900">Panel de Control - Categorias</h1>
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
                            <Link href={route('categories.create')} className="">
                                <Button variant="outline" className="mr-2 hover:cursor-pointer">
                                    <Plus className="mr-2 h-4 w-4" />
                                    Crear Categoria
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
                                    <Label className="mb-2 block text-sm font-medium text-gray-700">Buscar categoria</Label>
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
                            </div>
                        </div>
                    </div>

                    {/* Tabla de Categorias */}
                    <div className="rounded-lg bg-white shadow">
                        <div className="border-b border-gray-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <h3 className="text-lg font-medium text-gray-900">Numero de Categorias ({filteredCategories.length})</h3>
                                <p className="text-sm text-gray-500">
                                    Mostrando {Math.min(startIndex + 1, filteredCategories.length)} -{' '}
                                    {Math.min(startIndex + itemsPerPage, filteredCategories.length)} de {filteredCategories.length}
                                </p>
                            </div>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead className="bg-gray-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Código</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Categoría</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Estado</th>
                                        <th className="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200 bg-white">
                                    {paginatedCategories.length === 0 ? (
                                        <tr>
                                            <td colSpan={7} className="px-6 py-12 text-center">
                                                <div className="text-gray-500">
                                                    <BookmarkX className="mx-auto mb-4 h-12 w-12 text-gray-400" />
                                                    <h3 className="mb-2 text-lg font-medium">No se encontraron categorias</h3>
                                                    <p>Intenta ajustar los filtros de búsqueda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    ) : (
                                        paginatedCategories.map((category: Category) => (
                                            <tr key={category.CategoriaId} className="hover:bg-gray-50">
                                                <td className="px-6 py-4 font-mono text-sm whitespace-nowrap text-gray-900">
                                                    #{String(category.CategoriaId).padStart(4, '0')}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">{category.Nombre}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{category.Estado === 0 ? 'Inactiva' : 'Activa'}</td>
                                                <td className="flex items-center gap-2 px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                                    <Link
                                                        href={route('categories.edit', category.CategoriaId)}
                                                        className="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm leading-4 font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                                                    >
                                                        <Pen className="h-4 w-4" />
                                                    </Link>
                                                    <Dialog>
                                                        <DialogTrigger>
                                                            {category.Estado === 1 ? (
                                                                <Tooltip>
                                                                    <TooltipTrigger>
                                                                        <Button
                                                                            variant="destructive"
                                                                            className="flex items-center justify-center hover:cursor-pointer"
                                                                        >
                                                                            <Trash className="h-4 w-4" />
                                                                        </Button>
                                                                    </TooltipTrigger>
                                                                    <TooltipContent>Desactivar</TooltipContent>
                                                                </Tooltip>
                                                            ) : (
                                                                <Tooltip>
                                                                    <TooltipTrigger>
                                                                        <Button
                                                                            variant="outline"
                                                                            className="flex items-center justify-center hover:cursor-pointer"
                                                                        >
                                                                            <Check className="h-4 w-4" />
                                                                        </Button>
                                                                    </TooltipTrigger>
                                                                    <TooltipContent>Activar</TooltipContent>
                                                                </Tooltip>
                                                            )}
                                                        </DialogTrigger>
                                                        <DialogContent>
                                                            <DialogHeader>
                                                                <DialogTitle>
                                                                    {category.Estado === 1 ? 'Desactivar' : 'Activar'} categoría
                                                                </DialogTitle>
                                                                <DialogDescription>
                                                                    ¿Estás seguro de que quieres {category.Estado === 1 ? 'desactivar' : 'activar'}{' '}
                                                                    esta categoría?
                                                                </DialogDescription>
                                                            </DialogHeader>
                                                            <DialogFooter>
                                                                <DialogClose asChild>
                                                                    <Button variant="outline">Cancelar</Button>
                                                                </DialogClose>
                                                                {category.Estado === 1 ? (
                                                                    <Button
                                                                        className="hover:cursor-pointer"
                                                                        variant="destructive"
                                                                        onClick={() => deleteCategory(category.CategoriaId)}
                                                                    >
                                                                        Desactivar
                                                                    </Button>
                                                                ) : (
                                                                    <Button
                                                                        className="hover:cursor-pointer"
                                                                        variant="default"
                                                                        onClick={() => deleteCategory(category.CategoriaId)}
                                                                    >
                                                                        Activar
                                                                    </Button>
                                                                )}
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
