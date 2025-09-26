import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/admin-layout';
import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { AlertTriangle, Calendar, CreditCard, DollarSign, Eye, Mail, MapPin, Package, Save, ShoppingCart, User, X } from 'lucide-react';

const breadcrumbs = [
    {
        title: 'Panel de control',
        href: '/the-owl/public/panel',
    },
    {
        title: 'Pedidos',
        href: '/the-owl/public/panel/pedidos',
    },
    {
        title: 'Editar Estado',
        href: '/the-owl/public/panel/pedidos/editar',
    },
];

export default function EditOrderStatus() {
    const { order } = usePage().props;
    console.log({ order });
    const { data, setData, put, processing, errors } = useForm({
        Estado: order.Estado || '',
        EstadoPago: order.EstadoPago || '',
    });


    // Estados disponibles para pedidos
    const orderStatuses = [
        { value: 'pendiente de entrega', label: 'Pendiente', color: 'bg-yellow-100 text-yellow-800', icon: '⏳' },
        { value: 'confirmado', label: 'Confirmado', color: 'bg-blue-100 text-blue-800', icon: '✅' },
        { value: 'preparando', label: ' Preparando', color: 'bg-purple-100 text-purple-800', icon: '⚙️' },
        { value: 'enviado', label: 'Enviado', color: 'bg-indigo-100 text-indigo-800', icon: '🚚' },
        { value: 'entregado', label: 'Entregado', color: 'bg-green-100 text-green-800', icon: '📦' },
        { value: 'cancelado', label: 'Cancelado', color: 'bg-red-100 text-red-800', icon: '❌' },
        {
            value: 'en espera de retiro',
            label: 'En espera de retiro',
            color: 'bg-gray-100 text-gray-800',
            icon: '⏳',
        },
    ];

    // Estados de pago disponibles
    const paymentStatuses = [
        { value: 'pendiente', label: 'Pendiente', color: 'bg-yellow-100 text-yellow-800', icon: '⏳' },
        { value: 'pagado', label: 'Pagado', color: 'bg-green-100 text-green-800', icon: '💳' },
        { value: 'fallido', label: 'Fallido', color: 'bg-red-100 text-red-800', icon: '❌' },
        { value: 'reembolsado', label: 'Reembolsado', color: 'bg-gray-100 text-gray-800', icon: '↩️' },
    ];

    const handleSubmit = (e) => {
        e.preventDefault();
        put(route('api.orders.update', order.PedidoId), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                router.push({ url: route('orders.index') });
            },
        });
    };

    const selectedOrderStatus = orderStatuses.find((status) => status.value === data.Estado);
    const selectedPaymentStatus = paymentStatuses.find((status) => status.value === data.EstadoPago);

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title={`Editar Estado - Pedido #${order.PedidoId}`} />
            <div className="min-h-screen bg-neutral-50">
                <div className="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
                    {/* Header */}
                    <div className="mb-8">
                        <div className="flex items-center justify-between">
                            <div>
                                <h1 className="text-3xl font-bold text-neutral-900">Editar Estado - Pedido #{order.PedidoId}</h1>
                                <p className="mt-2 text-sm text-neutral-600">Actualiza el estado del pedido y del pago</p>
                            </div>
                            <Link
                                href={route('orders.index')}
                                className="inline-flex items-center rounded-md border border-neutral-300 bg-white px-4 py-2 text-sm font-medium text-neutral-700 shadow-sm hover:bg-neutral-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none"
                            >
                                <X className="mr-2 h-4 w-4" />
                                Volver
                            </Link>
                        </div>
                    </div>

                    {/* Información del Cliente (Solo Lectura) */}
                    <Card className="mb-6">
                        <CardHeader>
                            <CardTitle className="flex items-center">
                                <Eye className="mr-2 h-5 w-5 text-neutral-500" />
                                Información del Cliente
                            </CardTitle>
                            <CardDescription>Datos del cliente (solo lectura)</CardDescription>
                        </CardHeader>
                        <CardContent className="bg-neutral-50">
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                                <div className="space-y-1">
                                    <Label className="text-sm font-medium text-neutral-600">Cliente</Label>
                                    <div className="flex items-center space-x-2">
                                        <User className="h-4 w-4 text-neutral-400" />
                                        <span className="text-neutral-900">{order.user.nombre_completo}</span>
                                    </div>
                                </div>

                                <div className="space-y-1">
                                    <Label className="text-sm font-medium text-neutral-600">Correo</Label>
                                    <div className="flex items-center space-x-2">
                                        <Mail className="h-4 w-4 text-neutral-400" />
                                        <span className="text-neutral-900">{order.user.correo}</span>
                                    </div>
                                </div>

                                <div className="space-y-1">
                                    <Label className="text-sm font-medium text-neutral-600">Monto Total</Label>
                                    <div className="flex items-center space-x-2">
                                        <DollarSign className="h-4 w-4 text-neutral-400" />
                                        <span className="text-lg font-semibold text-neutral-900">
                                            ${parseFloat(order.Monto || 0).toFixed(2)} {order.Moneda}
                                        </span>
                                    </div>
                                </div>

                                <div className="space-y-1">
                                    <Label className="text-sm font-medium text-neutral-600">Fecha de Creación</Label>
                                    <div className="flex items-center space-x-2">
                                        <Calendar className="h-4 w-4 text-neutral-400" />
                                        <span className="text-neutral-900">
                                            {new Date(order.CreatedAt).toLocaleDateString('es-ES', {
                                                year: 'numeric',
                                                month: 'long',
                                                day: 'numeric',
                                                hour: '2-digit',
                                                minute: '2-digit',
                                            })}
                                        </span>
                                    </div>
                                </div>

                                {order.Codigo && (
                                    <div className="space-y-1">
                                        <Label className="text-sm font-medium text-neutral-600">Codigo</Label>
                                        <div className="flex items-center space-x-2">
                                            <CreditCard className="h-4 w-4 text-neutral-400" />
                                            <span className="font-mono text-xs text-neutral-900">{order.Codigo}...</span>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Direcciones (Solo Lectura) */}

                    <Card className="mb-6">
                        <CardHeader>
                            <CardTitle className="flex items-center">
                                <MapPin className="mr-2 h-5 w-5 text-neutral-500" />
                                Direcciones
                            </CardTitle>
                            <CardDescription>Direcciones de facturación y envío (solo lectura)</CardDescription>
                        </CardHeader>
                        <CardContent className="bg-neutral-50">
                            <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                {order.DireccionFacturacion && (
                                    <div className="space-y-2">
                                        <Label className="text-sm font-medium text-neutral-600">Dirección de Facturación</Label>
                                        <div className="rounded-md border bg-white p-3">
                                            <p className="text-sm whitespace-pre-line text-neutral-900">{order.user.direccion}</p>
                                        </div>
                                    </div>
                                )}

                                {order.DireccionEnvio && (
                                    <div className="space-y-2">
                                        <Label className="text-sm font-medium text-neutral-600">Dirección de Envío</Label>
                                        <div className="rounded-md border bg-white p-3">
                                            <p className="text-sm whitespace-pre-line text-neutral-900">{order.user.direccion}</p>
                                        </div>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Artículos del Pedido (Solo Lectura) */}
                    {order.items && order.items.length > 0 && (
                        <Card className="mb-6">
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <ShoppingCart className="mr-2 h-5 w-5 text-neutral-500" />
                                    Artículos del Pedido
                                </CardTitle>
                                <CardDescription>Productos incluidos en este pedido (solo lectura)</CardDescription>
                            </CardHeader>
                            <CardContent className="bg-neutral-50">
                                <div className="space-y-3">
                                    {order.items.map((item, index) => (
                                        <div key={index} className="rounded-lg border bg-white p-4">
                                            <div className="flex items-center justify-between">
                                                <div className="flex items-center space-x-3">
                                                    <div className="flex-shrink-0">
                                                        <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-neutral-200">
                                                            <Package className="h-5 w-5 text-neutral-400" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h4 className="text-sm font-medium text-neutral-900">
                                                            {item.NombreProducto || `Producto #${item.ProductoId}`}
                                                        </h4>
                                                        <p className="text-sm text-neutral-500">
                                                            Cantidad: {item.Cantidad} × ${parseFloat(item.PrecioUnitario || 0).toFixed(2)}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="text-right">
                                                    <p className="text-sm font-semibold text-neutral-900">
                                                        ${parseFloat((item.Cantidad || 0) * (item.PrecioUnitario || 0)).toFixed(2)}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>
                    )}

                    {/* Formulario de Edición de Estado */}
                    <form onSubmit={handleSubmit} className="space-y-6">
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center">
                                    <Package className="mr-2 h-5 w-5" />
                                    Actualizar Estados
                                </CardTitle>
                                <CardDescription>Modifica el estado del pedido y del pago</CardDescription>
                            </CardHeader>
                            <CardContent className="space-y-6">
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div className="space-y-2">
                                        <Label htmlFor="estado">Estado del Pedido *</Label>
                                        <Select value={data.Estado} onValueChange={(value) => setData('Estado', value)}>
                                            <SelectTrigger className={errors.Estado ? 'border-red-500 focus:ring-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar estado del pedido" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {orderStatuses.map((status) => (
                                                    <SelectItem key={status.value} value={status.value}>
                                                        <span className="flex items-center">
                                                            <span className="mr-2">{status.icon}</span>
                                                            {status.label}
                                                        </span>
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.Estado && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.Estado}
                                            </p>
                                        )}
                                    </div>

                                    <div className="space-y-2">
                                        <Label htmlFor="estadoPago">Estado del Pago *</Label>
                                        <Select value={data.EstadoPago} onValueChange={(value) => setData('EstadoPago', value)}>
                                            <SelectTrigger className={errors.EstadoPago ? 'border-red-500 focus:ring-red-500' : ''}>
                                                <SelectValue placeholder="Seleccionar estado del pago" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                {paymentStatuses.map((status) => (
                                                    <SelectItem key={status.value} value={status.value}>
                                                        <span className="flex items-center">
                                                            <span className="mr-2">{status.icon}</span>
                                                            {status.label}
                                                        </span>
                                                    </SelectItem>
                                                ))}
                                            </SelectContent>
                                        </Select>
                                        {errors.EstadoPago && (
                                            <p className="flex items-center text-sm text-red-600">
                                                <AlertTriangle className="mr-1 h-4 w-4" />
                                                {errors.EstadoPago}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                {/* Vista previa de los cambios */}
                                {(selectedOrderStatus || selectedPaymentStatus) && (
                                    <div className="rounded-lg border border-blue-200 bg-blue-50 p-4">
                                        <h4 className="mb-3 flex items-center text-sm font-medium text-blue-900">
                                            <Package className="mr-1 h-4 w-4" />
                                            Vista Previa de Estados
                                        </h4>
                                        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                            {selectedOrderStatus && (
                                                <div className="rounded bg-white p-3">
                                                    <span className="mb-1 block text-sm text-blue-700">Estado del Pedido:</span>
                                                    <span
                                                        className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${selectedOrderStatus.color}`}
                                                    >
                                                        <span className="mr-1">{selectedOrderStatus.icon}</span>
                                                        {selectedOrderStatus.label}
                                                    </span>
                                                </div>
                                            )}
                                            {selectedPaymentStatus && (
                                                <div className="rounded bg-white p-3">
                                                    <span className="mb-1 block text-sm text-blue-700">Estado del Pago:</span>
                                                    <span
                                                        className={`inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ${selectedPaymentStatus.color}`}
                                                    >
                                                        <span className="mr-1">{selectedPaymentStatus.icon}</span>
                                                        {selectedPaymentStatus.label}
                                                    </span>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </CardContent>
                        </Card>

                        {/* Botones de Acción */}
                        <Card>
                            <CardContent className="pt-6">
                                <div className="flex justify-end space-x-3">
                                    <Button variant="outline" type="button" asChild>
                                        <Link href={route('orders.index')}>
                                            <X className="mr-2 h-4 w-4" />
                                            Cancelar
                                        </Link>
                                    </Button>
                                    <Button type="submit" disabled={processing}>
                                        {processing ? (
                                            <>
                                                <div className="mr-2 -ml-1 h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></div>
                                                Actualizando...
                                            </>
                                        ) : (
                                            <>
                                                <Save className="mr-2 h-4 w-4" />
                                                Actualizar Estado
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
