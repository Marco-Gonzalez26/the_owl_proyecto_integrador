import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Separator } from '@/components/ui/separator';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Head } from '@inertiajs/react';
import { Calendar, CheckCircle, Clock, CreditCard, Eye, Package, Truck, XCircle } from 'lucide-react';
import { useState } from 'react';

interface ArticuloPedido {
    ProductoId: number;
    NombreProducto: string;
    PrecioUnitario: number;
    Cantidad: number;
    PrecioTotal: number;
    ImagenProducto: string;
}

interface Pedido {
    PedidoId: number;
    StripeSesionId: string;
    Monto: number;
    Moneda: string;
    Estado: 'pendiente de entrega' | 'en espera de retiro' | 'enviado' | 'entregado' | 'cancelado' | 'preparando';
    EstadoPago: 'pendiente' | 'pagado' | 'fallido' | 'reembolsado';
    CreatedAt: string;
    Articulos: ArticuloPedido[];
    Codigo: string;
}

interface OrdersProps {
    orders: Pedido[];
}

export default function UserOrders({ orders }: OrdersProps) {
    const [expandedOrder, setExpandedOrder] = useState<number | null>(null);

    const formatPrice = (price: number, currency: string = 'USD') => {
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: currency,
        }).format(price);
    };
    const handlePdf = async (orderId) => {
        const res = await fetch(`/orders/${orderId}/pdf-upload`);
        const data = await res.json();

        // Abrir PDF en otra pestaña 
        window.open(data.cloud_url, '_blank');
    };
    const formatDate = (dateString: string) => {
        return new Intl.DateTimeFormat('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }).format(new Date(dateString));
    };

    const getStatusBadge = (estado: string, estadoPago: string) => {
        if (estadoPago === 'pagado') {
            switch (estado) {
                case 'preparando':
                    return (
                        <Badge className="bg-purple-100 text-purple-800 hover:bg-purple-200">
                            <Clock className="mr-1 h-3 w-3" />
                            Preparando
                        </Badge>
                    );
                case 'en espera de retiro':
                    return (
                        <Badge className="bg-gray-100 text-gray-800 hover:bg-gray-200">
                            <Clock className="mr-1 h-3 w-3" />
                            En espera de retiro
                        </Badge>
                    );

                case 'pagado':
                    return (
                        <Badge className="bg-green-100 text-green-800 hover:bg-green-200">
                            <CheckCircle className="mr-1 h-3 w-3" />
                            Pagado
                        </Badge>
                    );
                case 'enviado':
                    return (
                        <Badge className="bg-blue-100 text-blue-800 hover:bg-blue-200">
                            <Truck className="mr-1 h-3 w-3" />
                            Enviado
                        </Badge>
                    );
                case 'entregado':
                    return (
                        <Badge className="bg-green-100 text-green-800 hover:bg-green-200">
                            <CheckCircle className="mr-1 h-3 w-3" />
                            Entregado
                        </Badge>
                    );
                default:
                    return (
                        <Badge className="bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                            <Clock className="mr-1 h-3 w-3" />
                            Procesando
                        </Badge>
                    );
            }
        } else {
            return (
                <Badge variant="destructive">
                    <XCircle className="mr-1 h-3 w-3" />
                    {estadoPago === 'fallido' ? 'Pago Fallido' : 'Pendiente'}
                </Badge>
            );
        }
    };

    const toggleOrderDetails = (pedidoId: number) => {
        setExpandedOrder(expandedOrder === pedidoId ? null : pedidoId);
    };

    return (
        <AppHeaderLayout>
            <Head title="Mis Pedidos" />

            <div className="min-h-screen bg-neutral-50 py-8">
                <div className="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                    <div className="mb-8">
                        <h1 className="flex items-center text-3xl font-bold text-neutral-900">
                            <Package className="mr-3" />
                            Mis Pedidos
                        </h1>
                        <p className="mt-2 text-neutral-600">Revisa el estado de tus pedidos y el historial de compras</p>
                    </div>

                    {orders.length === 0 ? (
                        <Card className="py-12 text-center">
                            <CardContent>
                                <Package className="mx-auto mb-4 h-16 w-16 text-neutral-400" />
                                <h3 className="mb-2 text-lg font-medium text-neutral-900">No tienes pedidos aún</h3>
                                <p className="mb-6 text-neutral-500">Cuando realices tu primera compra, aparecerá aquí</p>
                                <Button asChild>
                                    <a href="/catalog">Explorar productos</a>
                                </Button>
                            </CardContent>
                        </Card>
                    ) : (
                        <div className="space-y-6">
                            {orders.map((order) => (
                                <Card key={order.PedidoId} className="overflow-hidden">
                                    <CardHeader className="bg-neutral-50">
                                        <div className="flex items-center justify-between">
                                            <div className="flex items-center space-x-4">
                                                <CardTitle className="text-lg">Pedido #{order.PedidoId}</CardTitle>
                                                {getStatusBadge(order.Estado, order.EstadoPago)}
                                            </div>
                                            <div className="flex items-center space-x-2">
                                                <span className="text-lg font-bold text-green-600">{formatPrice(order.Monto, order.Moneda)}</span>
                                                <Button variant="outline" size="sm" onClick={() => toggleOrderDetails(order.PedidoId)}>
                                                    <Eye className="mr-2 h-4 w-4" />
                                                    {expandedOrder === order.PedidoId ? 'Ocultar' : 'Ver detalles'}
                                                </Button>
                                            </div>
                                        </div>

                                        <div className="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                                            <div className="flex items-center text-sm text-neutral-600">
                                                <Calendar className="mr-2 h-4 w-4" />
                                                {formatDate(order.CreatedAt)}
                                            </div>
                                            <div className="flex items-center text-sm text-neutral-600">
                                                <CreditCard className="mr-2 h-4 w-4" />
                                                {order.Articulos.length} {order.Articulos.length === 1 ? 'artículo' : 'artículos'}
                                            </div>
                                            <div className="flex items-center text-sm text-neutral-600">
                                                <Package className="mr-2 h-4 w-4" />
                                                Código: {order.Codigo}
                                            </div>
                                        </div>
                                    </CardHeader>

                                    {expandedOrder === order.PedidoId && (
                                        <CardContent className="p-6">
                                            <div className="space-y-4">
                                                <ScrollArea className="max-h-96">
                                                    <div className="space-y-4">
                                                        {order.Articulos.map((item, index) => (
                                                            <div key={index} className="flex items-center space-x-4 rounded-lg border p-4">
                                                                <div className="flex-shrink-0">
                                                                    <img
                                                                        src={item.ImagenProducto}
                                                                        alt={item.NombreProducto}
                                                                        className="h-16 w-16 rounded-md border object-cover"
                                                                    />
                                                                </div>
                                                                <div className="min-w-0 flex-1">
                                                                    <h5 className="truncate font-medium text-neutral-900">{item.NombreProducto}</h5>
                                                                    <div className="mt-1 flex items-center space-x-4 text-sm text-neutral-500">
                                                                        <span>Precio: {formatPrice(item.PrecioUnitario)}</span>
                                                                        <span>Cantidad: {item.Cantidad}</span>
                                                                    </div>
                                                                </div>
                                                                <div className="text-right">
                                                                    <div className="text-lg font-semibold text-neutral-900">
                                                                        {formatPrice(item.PrecioTotal)}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        ))}
                                                    </div>
                                                </ScrollArea>

                                                <Separator />

                                                <div className="rounded-lg bg-neutral-50 p-4">
                                                    <div className="flex items-center justify-between">
                                                        <span className="text-lg font-semibold text-neutral-900">Total del pedido:</span>
                                                        <span className="text-xl font-bold text-green-600">
                                                            {formatPrice(order.Monto, order.Moneda)}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </CardContent>
                                    )}
                                </Card>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AppHeaderLayout>
    );
}
