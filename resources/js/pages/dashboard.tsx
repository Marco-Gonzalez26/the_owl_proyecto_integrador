import { ChartConfig } from '@/components/ui/chart';

import { Chart } from '@/components/chart';
import AppLayout from '@/layouts/admin-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { AlertTriangle, Archive, DollarSign, Package } from 'lucide-react';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel de Control',
        href: '/dashboard',
    },
];

const chartConfig: ChartConfig = {
    Enero: {
        label: 'Enero',
        color: 'var(--chart-1)',
    },
    Febrero: {
        label: 'Febrero',
        color: 'var(--chart-2)',
    },
    Marzo: {
        label: 'Marzo',
        color: 'var(--chart-3)',
    },
    Abril: {
        label: 'Abril',
        color: 'var(--chart-4)',
    },
    Mayo: {
        label: 'Mayo',
        color: 'var(--chart-5)',
    },
    Junio: {
        label: 'Junio',
        color: 'var(--chart-1)',
    },
    Julio: {
        label: 'Julio',
        color: 'var(--chart-2)',
    },
    Agosto: {
        label: 'Agosto',
        color: 'var(--chart-3)',
    },
    Septiembre: {
        label: 'Septiembre',
        color: 'var(--chart-4)',
    },
    Octubre: {
        label: 'Octubre',
        color: 'var(--chart-5)',
    },
    Noviembre: {
        label: 'Noviembre',
        color: 'var(--chart-1)',
    },
    Diciembre: {
        label: 'Diciembre',
        color: 'var(--chart-2)',
    },
} satisfies ChartConfig;

export default function Dashboard({ products, categories, orders }: { products: any[]; categories: any[]; orders: any[] }) {
    const lowStockProducts = products.filter((p) => p.Stock <= 10 && p.Stock > 0);
    const outOfStockProducts = products.filter((p) => p.Stock === 0);
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-EC', {
            style: 'currency',
            currency: 'USD',
        }).format(price);
    };


    const processOrdersData = () => {
        const monthNames = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Septiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];


        const monthlyData = monthNames.reduce(
            (acc, month) => {
                acc[month] = 0;
                return acc;
            },
            {} as Record<string, number>,
        );


        orders.forEach((order) => {
            const orderDate = new Date(order.fecha_pedido || order.CreatedAt);
            const monthIndex = orderDate.getMonth();
            const monthName = monthNames[monthIndex];


            monthlyData[monthName] += Number(order.Monto) || 1;
        });


        return monthNames.map((month) => ({
            month,
            pedidos: monthlyData[month],
        }));
    };

    const salesData = processOrdersData();


    const totalOrders = orders.length;
    const totalRevenue = orders.reduce((sum, order) => sum + (Number(order.Monto) || 0), 0);
    const currentMonth = new Date().getMonth();
    const currentMonthOrders = orders.filter((order) => {
        const orderDate = new Date(order.fecha_pedido || order.CreatedAt);
        return orderDate.getMonth() === currentMonth;
    }).length;

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Panel de Control" />
            <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
                {/* Alertas de Stock */}
                {(outOfStockProducts.length > 0 || lowStockProducts.length > 0) && (
                    <div className="mb-6 space-y-3">
                        {outOfStockProducts.length > 0 && (
                            <div className="rounded-md border border-red-200 bg-red-50 p-4">
                                <div className="flex">
                                    <AlertTriangle className="h-5 w-5 text-red-400" />
                                    <div className="ml-3">
                                        <h3 className="text-sm font-medium text-red-800">Productos sin stock ({outOfStockProducts.length})</h3>
                                        <p className="mt-1 text-sm text-red-700">
                                            {outOfStockProducts
                                                .slice(0, 3)
                                                .map((p) => p.Nombre)
                                                .join(', ')}
                                            {outOfStockProducts.length > 3 && ` y ${outOfStockProducts.length - 3} más...`}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        )}

                        {lowStockProducts.length > 0 && (
                            <div className="rounded-md border border-orange-200 bg-orange-50 p-4">
                                <div className="flex">
                                    <AlertTriangle className="h-5 w-5 text-orange-400" />
                                    <div className="ml-3">
                                        <h3 className="text-sm font-medium text-orange-800">Stock bajo ({lowStockProducts.length})</h3>
                                        <p className="mt-1 text-sm text-orange-700">
                                            {lowStockProducts
                                                .slice(0, 3)
                                                .map((p) => `${p.Nombre} (${p.Stock})`)
                                                .join(', ')}
                                            {lowStockProducts.length > 3 && ` y ${lowStockProducts.length - 3} más...`}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        )}
                    </div>
                )}

                {/* Tarjetas de Estadísticas */}
                <div className="mb-8 grid grid-cols-1 gap-6 md:grid-cols-4">
                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <Package className="h-6 w-6 text-neutral-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-neutral-500">Total Productos</dt>
                                        <dd className="text-lg font-medium text-neutral-900">{products.length}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-neutral-50 px-5 py-3">
                            <div className="text-sm">
                                <span className="font-medium text-neutral-900">{categories.length}</span>
                                <span className="text-neutral-500"> categorías</span>
                            </div>
                        </div>
                    </div>

                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <DollarSign className="h-6 w-6 text-green-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-neutral-500">Valor Inventario</dt>
                                        <dd className="text-lg font-medium text-neutral-900">
                                            {formatPrice(products.reduce((sum, p) => sum + p.Precio * p.Stock, 0))}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-neutral-50 px-5 py-3">
                            <div className="text-sm">
                                <span className="font-medium text-neutral-900">{products.reduce((sum, p) => sum + p.Stock, 0)}</span>
                                <span className="text-neutral-500"> unidades totales</span>
                            </div>
                        </div>
                    </div>

                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <Archive className="h-6 w-6 text-blue-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-neutral-500">Total Pedidos</dt>
                                        <dd className="text-lg font-medium text-blue-600">{totalOrders}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-neutral-50 px-5 py-3">
                            <div className="text-sm">
                                <span className="font-medium text-neutral-900">{currentMonthOrders}</span>
                                <span className="text-neutral-500"> este mes</span>
                            </div>
                        </div>
                    </div>

                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <DollarSign className="h-6 w-6 text-green-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-neutral-500">Total Ventas</dt>
                                        <dd className="text-lg font-medium text-green-600">{formatPrice(totalRevenue)}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-neutral-50 px-5 py-3">
                            <div className="text-sm text-green-600">Ingresos totales</div>
                        </div>
                    </div>
                </div>

                {/* Estadísticas de Pedidos */}
                <h2 className="mb-4 text-xl font-medium text-neutral-900">Pedidos por Mes</h2>
                <div className="mb-8 grid h-full grid-cols-1 gap-6 md:grid-cols-2">
                    <div className="h-full overflow-hidden rounded-lg bg-white shadow">
                        <Chart chartData={salesData} chartConfig={chartConfig} description="Pedidos mensuales del año actual" dataKey="pedidos" />
                    </div>

                    {/* Tarjeta adicional con resumen de pedidos */}
                    <div className="h-full overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-6">
                            <h3 className="mb-4 text-lg font-medium text-neutral-900">Resumen de Pedidos</h3>
                            <div className="space-y-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-neutral-500">Pedidos totales:</span>
                                    <span className="font-semibold">{totalOrders}</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-neutral-500">Promedio mensual:</span>
                                    <span className="font-semibold">{Math.round(totalOrders / 12)}</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-neutral-500">Ingresos totales:</span>
                                    <span className="font-semibold">{formatPrice(totalRevenue)}</span>
                                </div>
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-neutral-500">Promedio por pedido:</span>
                                    <span className="font-semibold">
                                        {totalOrders > 0 ? formatPrice(totalRevenue / totalOrders) : formatPrice(0)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
