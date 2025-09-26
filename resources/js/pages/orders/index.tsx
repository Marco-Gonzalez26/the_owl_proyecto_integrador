import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, useForm } from '@inertiajs/react';
import { Eye, Package, Search } from 'lucide-react';
import { useMemo, useState } from 'react';
import { toast } from 'sonner';

type Pedido = {
    PedidoId: number;
    StripeSesionId: string;
    UsuarioId: number;
    CorreoCliente: string;
    NombreCliente: string;
    Monto: number;
    Moneda: string;
    Estado: string;
    EstadoPago: string;
    DireccionFacturacion: string;
    DireccionEnvio: string;
    Codigo: string;
};

const breadcrumbs: any[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Pedidos',
        href: '/dashboard/pedidos',
    },
];

export default function Index({ orders }: { orders: Pedido[] }) {
    const [searchTerm, setSearchTerm] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');
    const [paymentStatusFilter, setPaymentStatusFilter] = useState('all');
    const [currentPage, setCurrentPage] = useState(1);
    const { processing, delete: destroy } = useForm();
    const itemsPerPage = 15;

    const filteredOrders = useMemo(() => {
        return orders.filter((order) => {
            const matchesSearch =
                order.NombreCliente.toLowerCase().includes(searchTerm.toLowerCase()) ||
                order.CorreoCliente.toLowerCase().includes(searchTerm.toLowerCase()) ||
                order.Codigo.toLowerCase().includes(searchTerm.toLowerCase());

            const matchesStatus = statusFilter === 'all' || order.Estado === statusFilter;
            const matchesPaymentStatus = paymentStatusFilter === 'all' || order.EstadoPago === paymentStatusFilter;

            return matchesSearch && matchesStatus && matchesPaymentStatus;
        });
    }, [orders, searchTerm, statusFilter, paymentStatusFilter]);

    const totalPages = Math.ceil(filteredOrders.length / itemsPerPage);
    const startIndex = (currentPage - 1) * itemsPerPage;
    const paginatedOrders = filteredOrders.slice(startIndex, startIndex + itemsPerPage);

    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-EC', {
            style: 'currency',
            currency: 'USD',
        }).format(price);
    };

    const getStatusBadge = (status: string) => {
        switch (status.toLowerCase()) {
            case 'entregado':
                return (
                    <span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                        Entregado
                    </span>
                );
            case 'enviado':
                return (
                    <span className="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-800">
                        Enviado
                    </span>
                );
            case 'preparando':
                return (
                    <span className="inline-flex items-center rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-800">
                        Preparando
                    </span>
                );
            case 'pendiente de entrega':
                return (
                    <span className="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">
                        Pendiente de entrega
                    </span>
                );
            case 'en espera de retiro':
                return (
                    <span className="inline-flex items-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-xs font-semibold text-indigo-800">
                        En espera de retiro
                    </span>
                );
            case 'cancelado':
                return (
                    <span className="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">
                        Cancelado
                    </span>
                );
            default:
                return (
                    <span className="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-semibold text-neutral-800">
                        Desconocido
                    </span>
                );
        }
    };

    const getPaymentStatusBadge = (status: string) => {
        switch (status.toLowerCase()) {
            case 'pagado':
                return (
                    <span className="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">
                        Pagado
                    </span>
                );
            case 'pendiente':
                return (
                    <span className="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">
                        Pendiente
                    </span>
                );
            case 'fallido':
                return (
                    <span className="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Fallido</span>
                );
            default:
                return (
                    <span className="inline-flex items-center rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-semibold text-neutral-800">
                        Desconocido
                    </span>
                );
        }
    };

    const deleteOrder = (id: number) => {
        destroy(route('orders.destroy', id), {
            onSuccess: () => {
                toast.success('Pedido eliminado correctamente');
                setCurrentPage(1);
            },
            onError: () => {
                toast.error('Error al eliminar el pedido');
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Gestión de Pedidos" />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <div>
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Panel de Control - Pedidos</h1>
                                <p className="mt-2 text-sm text-neutral-600">Gestión de pedidos de clientes</p>
                            </div>
                        </div>
                    </div>
                    <div className="mb-6 rounded-lg bg-white shadow">
                        <div className="border-b border-neutral-200 px-6 py-4">
                            <h3 className="text-lg font-medium text-neutral-900">Filtros de Búsqueda</h3>
                        </div>
                        <div className="p-6">
                            <div className="grid grid-cols-1 items-end gap-4 md:grid-cols-4">
                                <div>
                                    <Label className="mb-2 block text-sm font-medium text-neutral-700">Buscar pedido</Label>
                                    <div className="relative">
                                        <Search className="absolute top-3 left-3 h-4 w-4 text-neutral-400" />
                                        <Input
                                            type="text"
                                            placeholder="Codigo del pedido, nombre o correo de cliente..."
                                            value={searchTerm}
                                            onChange={(e) => {
                                                setSearchTerm(e.target.value);
                                                setCurrentPage(1);
                                            }}
                                            className="block w-full rounded-md border border-neutral-300 py-2 pr-3 pl-10 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <label className="mb-2 block text-sm font-medium text-neutral-700">Estado</label>
                                    <Select
                                        value={statusFilter}
                                        onValueChange={(value) => {
                                            setStatusFilter(value);
                                            setCurrentPage(1);
                                        }}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Filtrar por estado" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Todos los estados</SelectItem>
                                            <SelectItem value="pendiente">Pendiente</SelectItem>
                                            <SelectItem value="enviado">Enviado</SelectItem>
                                            <SelectItem value="entregado">Entregado</SelectItem>
                                            <SelectItem value="cancelado">Cancelado</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                <div>
                                    <label className="mb-2 block text-sm font-medium text-neutral-700">Estado de Pago</label>
                                    <Select
                                        value={paymentStatusFilter}
                                        onValueChange={(value) => {
                                            setPaymentStatusFilter(value);
                                            setCurrentPage(1);
                                        }}
                                    >
                                        <SelectTrigger>
                                            <SelectValue placeholder="Filtrar por estado de pago" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem value="all">Todos los estados</SelectItem>
                                            <SelectItem value="pagado">Pagado</SelectItem>
                                            <SelectItem value="pendiente">Pendiente</SelectItem>
                                            <SelectItem value="fallido">Fallido</SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>
                                <div className="flex items-end">
                                    <Button
                                        className="hover:cursor-pointer"
                                        variant="outline"
                                        onClick={() => {
                                            setSearchTerm('');
                                            setStatusFilter('all');
                                            setPaymentStatusFilter('all');
                                            setCurrentPage(1);
                                        }}
                                    >
                                        Limpiar Filtros
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    ---
                    <div className="rounded-lg bg-white shadow">
                        <div className="border-b border-neutral-200 px-6 py-4">
                            <div className="flex items-center justify-between">
                                <h3 className="text-lg font-medium text-neutral-900">Lista de Pedidos ({filteredOrders.length})</h3>
                                <p className="text-sm text-neutral-500">
                                    Mostrando {Math.min(startIndex + 1, filteredOrders.length)} -{' '}
                                    {Math.min(startIndex + itemsPerPage, filteredOrders.length)} de {filteredOrders.length}
                                </p>
                            </div>
                        </div>
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-neutral-200">
                                <thead className="bg-neutral-50">
                                    <tr>
                                        <th className="px-6 py-3 text-left text-xs font-bold tracking-wider text-neutral-900 uppercase">ID</th>
                                        <th className="px-6 py-3 text-left text-xs font-bold tracking-wider text-neutral-900 uppercase">Cliente</th>
                                        <th className="px-6 py-3 text-left text-xs font-bold tracking-wider text-neutral-900 uppercase">Monto</th>
                                        <th className="px-6 py-3 text-left text-xs font-bold tracking-wider text-neutral-900 uppercase">Estado</th>
                                        <th className="px-6 py-3 text-left text-xs font-bold tracking-wider text-neutral-900 uppercase">
                                            Estado de Pago
                                        </th>
                                        <th className="px-6 py-3 text-right text-xs font-medium tracking-wider text-neutral-900 uppercase">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-neutral-200 bg-white">
                                    {paginatedOrders.length === 0 ? (
                                        <tr>
                                            <td colSpan={6} className="px-6 py-12 text-center">
                                                <div className="text-neutral-500">
                                                    <Package className="mx-auto mb-4 h-12 w-12 text-neutral-400" />
                                                    <h3 className="mb-2 text-lg font-medium">No se encontraron pedidos</h3>
                                                    <p>Intenta ajustar los filtros de búsqueda</p>
                                                </div>
                                            </td>
                                        </tr>
                                    ) : (
                                        paginatedOrders.map((order) => (
                                            <tr key={order.PedidoId} className="hover:bg-neutral-50">
                                                <td className="px-6 py-4 font-mono text-sm whitespace-nowrap text-neutral-900">
                                                    #{String(order.PedidoId).padStart(6, '0')}
                                                </td>
                                                <td className="px-6 py-4">
                                                    <div className="min-w-0 flex-1">
                                                        <Link
                                                            href={route('orders.showEdit', order.PedidoId)}
                                                            className="block truncate text-sm font-medium text-neutral-900 hover:text-blue-600"
                                                        >
                                                            {order.NombreCliente}
                                                        </Link>
                                                        <p className="mt-1 line-clamp-1 text-sm text-neutral-500">{order.CorreoCliente}</p>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4 text-sm font-semibold whitespace-nowrap text-neutral-900">
                                                    {formatPrice(order.Monto)}
                                                </td>
                                                <td className="px-6 py-4 whitespace-nowrap">{getStatusBadge(order.Estado)}</td>
                                                <td className="px-6 py-4 whitespace-nowrap">{getPaymentStatusBadge(order.EstadoPago)}</td>
                                                <td className="flex items-center gap-2 px-6 py-4 text-right text-sm font-medium whitespace-nowrap">
                                                    <Button asChild>
                                                        <Link href={route('orders.showEdit', order.PedidoId)}>
                                                            <Eye className="h-4 w-4" /> Ver Pedido
                                                        </Link>
                                                    </Button>
                                                </td>
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                            </table>
                        </div>
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
