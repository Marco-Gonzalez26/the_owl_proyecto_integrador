import { HeroBentoGrid } from '@/components/hero-bento-grid';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { ArrowRight, Award, Clock, Shield, ShoppingBag, Star, Truck, Users } from 'lucide-react';

export default function Welcome() {
    const { auth, session } = usePage<SharedData>().props;

    const items = [
        {
            id: '1',
            name: 'Producto 1',
            description: 'Descripción del producto 1',
            price: 10.0,
            quantity: 2,
            image: 'https://th.bing.com/th/id/R.89c4d45e7c78cb0d4f902734d13adff8?rik=l8OqrjQx6YBCBw&riu=http%3a%2f%2fincakolausa.com%2fwp-content%2fuploads%2f2014%2f09%2finca-Kola-Sodas-1024x743.jpg&ehk=iRiC3ytG3NP0d2C92rhqFeNuiXRFLML5akFJKyiKFSw%3d&risl=&pid=ImgRaw&r=0',
        },
        {
            id: '3',
            name: 'Producto 3',
            description: 'Descripción del producto 1',
            price: 10.0,
            quantity: 2,
            image: 'https://th.bing.com/th/id/R.89c4d45e7c78cb0d4f902734d13adff8?rik=l8OqrjQx6YBCBw&riu=http%3a%2f%2fincakolausa.com%2fwp-content%2fuploads%2f2014%2f09%2finca-Kola-Sodas-1024x743.jpg&ehk=iRiC3ytG3NP0d2C92rhqFeNuiXRFLML5akFJKyiKFSw%3d&risl=&pid=ImgRaw&r=0',
        },
        {
            id: '2',
            name: 'Producto 2',
            description: 'Descripción del producto 2',
            price: 25.5,
            quantity: 1,
            image: 'https://eldiariony.com/wp-content/uploads/sites/2/2023/08/pepsi-125-aniversario-shutterstock_1752025412.jpg?w=1200',
        },

        {
            id: '4',
            name: 'Producto 4',
            description: 'Descripción del producto 2',
            price: 25.5,
            quantity: 1,
            image: 'https://eldiariony.com/wp-content/uploads/sites/2/2023/08/pepsi-125-aniversario-shutterstock_1752025412.jpg?w=1200',
        },
    ];
    return (
        <AppHeaderLayout>
            <Head title="Bienvenido a The Owl"></Head>

            <div className="min-h-screen bg-white dark:bg-[#0a0a0a]">
                <section className="relative h-screen overflow-hidden">
                    <div className="flex h-full w-full items-center justify-center">
                        <HeroBentoGrid items={items} />
                    </div>
                </section>

                <section className="py-16 lg:py-24">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="grid gap-8 lg:grid-cols-2">
                            <div className="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-red-800 via-red-900 to-[#661923] p-8 text-white transition-transform duration-300 hover:scale-[1.02] lg:p-12">
                                <div className="relative z-10">
                                    <h3 className="mb-4 text-2xl font-bold lg:text-3xl">Encuentra tu bebida perfecta</h3>
                                    <p className="mb-6 text-lg leading-relaxed text-amber-100">
                                        Desde refrescos y jugos hasta bebidas premium y especialidades, tenemos la selección más amplia de Santo
                                        Domingo. Cada producto seleccionado cuidadosamente para tu satisfacción.
                                    </p>
                                    <Button className="bg-white font-semibold text-red-900 hover:bg-neutral-100" asChild>
                                        <Link href={route('catalog.index')}>Ver Todas las Bebidas</Link>
                                    </Button>
                                </div>
                                <div className="absolute -right-8 -bottom-8 h-32 w-32 rounded-full bg-white/10"></div>
                                <div className="absolute -right-4 -bottom-4 h-20 w-20 rounded-full bg-white/5"></div>
                            </div>

                            <div className="group relative overflow-hidden rounded-3xl bg-[#fff8e7] p-8 transition-transform duration-300 lg:p-12">
                                <div className="relative z-10">
                                    <Badge className="mb-4 bg-black text-white dark:bg-white dark:text-black">Ventas Mayoristas</Badge>
                                    <h3 className="mb-4 text-2xl font-bold text-neutral-900 lg:text-3xl dark:text-white">¿Tienes un negocio?</h3>
                                    <div className="mb-6 space-y-2">
                                        <p className="font-medium text-neutral-700 dark:text-neutral-300">Precios especiales por volumen.</p>
                                        <p className="font-medium text-neutral-700 dark:text-neutral-300">Entrega directa a tu establecimiento.</p>
                                        <p className="font-medium text-neutral-700 dark:text-neutral-300">
                                            Asesoría personalizada para tu inventario.
                                        </p>
                                    </div>
                                    <Button
                                        className="bg-black font-semibold text-white hover:bg-neutral-800 dark:bg-white dark:text-black dark:hover:bg-neutral-100"
                                        asChild
                                    >
                                        <Link href={''}>Catalogo de mayoristas</Link>
                                    </Button>
                                </div>
                                <div className="absolute top-4 right-4 h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 to-purple-500 opacity-20"></div>
                                <div className="absolute right-8 bottom-8 h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 opacity-20"></div>
                            </div>
                        </div>
                    </div>
                </section>

                <section className="bg-white py-16 dark:bg-neutral-900">
                    <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div className="mb-12 text-center">
                            <h2 className="mb-4 text-3xl font-bold text-neutral-900 dark:text-white">¿Por qué elegir The Owl?</h2>
                            <p className="mx-auto max-w-2xl text-neutral-600 dark:text-neutral-400">
                                Nos destacamos por ofrecer calidad, variedad y un servicio excepcional en cada compra.
                            </p>
                        </div>

                        <div className="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 dark:bg-blue-900/30">
                                    <Award className="h-6 w-6 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Calidad de calidad</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">
                                    Productos seleccionados con los más altos estándares de calidad .
                                </p>
                            </div>

                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 dark:bg-green-900/30">
                                    <Truck className="h-6 w-6 text-green-600 dark:text-green-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Entrega Rápida</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">Delivery en Santo Domingo con tiempos de entrega increibles.</p>
                            </div>

                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 dark:bg-purple-900/30">
                                    <Shield className="h-6 w-6 text-purple-600 dark:text-purple-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Pago Seguro</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">Múltiples métodos de pago con tecnología segura y confiable.</p>
                            </div>

                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 dark:bg-orange-900/30">
                                    <Users className="h-6 w-6 text-orange-600 dark:text-orange-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Atención Personalizada</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">
                                    Soporte mediante WhatsApp para cada uno de nuestros clientes.
                                </p>
                            </div>

                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 dark:bg-red-900/30">
                                    <Clock className="h-6 w-6 text-red-600 dark:text-red-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Disponibilidad 24/7</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">
                                    Compra en línea en cualquier momento, los 7 días de la semana.
                                </p>
                            </div>

                            <div className="rounded-2xl border border-neutral-200 bg-white p-8 shadow-sm dark:border-neutral-700 dark:bg-neutral-800">
                                <div className="mb-6 flex h-12 w-12 items-center justify-center rounded-xl bg-teal-100 dark:bg-teal-900/30">
                                    <Star className="h-6 w-6 text-teal-600 dark:text-teal-400" />
                                </div>
                                <h3 className="mb-3 text-xl font-bold text-neutral-900 dark:text-white">Experiencia de compra increibile</h3>
                                <p className="text-neutral-600 dark:text-neutral-400">Una experiencia de compra diseñada pensando en tu comodidad.</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-16 lg:py-24">
                    <div className="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                        <h2 className="mb-4 text-3xl font-bold text-neutral-900 lg:text-4xl dark:text-white">¿Listo para comenzar tu experiencia?</h2>
                        <p className="mb-8 text-xl leading-relaxed text-neutral-600 dark:text-neutral-400">
                            Únete a miles de clientes satisfechos que confían en The Owl para sus compras de bebidas.
                        </p>
                        <div className="flex flex-col justify-center gap-4 sm:flex-row">
                            <Button
                                size="lg"
                                className="bg-black px-8 py-4 text-lg font-semibold text-white hover:bg-neutral-800 dark:bg-white dark:text-black dark:hover:bg-neutral-100"
                                asChild
                            >
                                <Link href={route('catalog.index')}>
                                    <ShoppingBag className="mr-2 h-5 w-5" />
                                    Explorar Catálogo
                                </Link>
                            </Button>
                            <Button size="lg" variant="outline" className="border-2 px-8 py-4 text-lg font-semibold" asChild>
                                <Link href={route('register')}>
                                    Crear Cuenta Gratis
                                    <ArrowRight className="ml-2 h-5 w-5" />
                                </Link>
                            </Button>
                        </div>
                    </div>
                </section>
            </div>
        </AppHeaderLayout>
    );
}
