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

export default function Dashboard({ products, categories }: { products: any[]; categories: any[] }) {
    const lowStockProducts = products.filter((p) => p.Stock <= 10 && p.Stock > 0);
    const outOfStockProducts = products.filter((p) => p.Stock === 0);
    const formatPrice = (price: number) => {
        return new Intl.NumberFormat('es-EC', {
            style: 'currency',
            currency: 'USD',
        }).format(price);
    };

    const sales = [
        { month: 'Enero', brand: 'Fioravanti', product: 120 },
        { month: 'Febrero', brand: 'Tropical', product: 95 },
        { month: 'Marzo', brand: 'Güitig', product: 140 },
        { month: 'Abril', brand: 'Pony Malta', product: 110 },
        { month: 'Mayo', brand: 'Fioravanti', product: 160 },
        { month: 'Junio', brand: 'Tropical', product: 130 },
        { month: 'Julio', brand: 'Güitig', product: 150 },
        { month: 'Agosto', brand: 'Pony Malta', product: 125 },
        { month: 'Septiembre', brand: 'Fioravanti', product: 170 },
        { month: 'Octubre', brand: 'Tropical', product: 145 },
        { month: 'Noviembre', brand: 'Güitig', product: 155 },
        { month: 'Diciembre', brand: 'Pony Malta', product: 180 },
    ];
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
                                    <Package className="h-6 w-6 text-gray-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-gray-500">Total Productos</dt>
                                        <dd className="text-lg font-medium text-gray-900">{products.length}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-5 py-3">
                            <div className="text-sm">
                                <span className="font-medium text-gray-900">{categories.length}</span>
                                <span className="text-gray-500"> categorías</span>
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
                                        <dt className="truncate text-sm font-medium text-gray-500">Valor Inventario</dt>
                                        <dd className="text-lg font-medium text-gray-900">
                                            {formatPrice(products.reduce((sum, p) => sum + p.Precio * p.Stock, 0))}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-5 py-3">
                            <div className="text-sm">
                                <span className="font-medium text-gray-900">{products.reduce((sum, p) => sum + p.Stock, 0)}</span>
                                <span className="text-gray-500"> unidades totales</span>
                            </div>
                        </div>
                    </div>

                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <Archive className="h-6 w-6 text-red-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-gray-500">Sin Stock</dt>
                                        <dd className="text-lg font-medium text-red-600">{outOfStockProducts.length}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-5 py-3">
                            <div className="text-sm text-red-600">Requieren reabastecimiento</div>
                        </div>
                    </div>

                    <div className="overflow-hidden rounded-lg bg-white shadow">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <AlertTriangle className="h-6 w-6 text-orange-400" />
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="truncate text-sm font-medium text-gray-500">Stock Bajo</dt>
                                        <dd className="text-lg font-medium text-orange-600">{lowStockProducts.length}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div className="bg-gray-50 px-5 py-3">
                            <div className="text-sm text-orange-600">Menos de 10 unidades</div>
                        </div>
                    </div>
                </div>

                {/* Estadísticas de Ventas */}
                <h2 className="mb-4 text-xl font-medium text-gray-900">Ventas</h2>
                <div className="mb-8 grid h-full grid-cols-1 gap-6 md:grid-cols-2">
                    <div className="h-full overflow-hidden rounded-lg bg-white shadow">
                        <Chart chartData={sales} chartConfig={chartConfig} description="Ventas mensuales" />
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
