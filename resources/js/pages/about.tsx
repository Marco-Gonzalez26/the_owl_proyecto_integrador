import { Card, CardContent } from '@/components/ui/card';
import AppHeaderLayout from '@/layouts/app/app-header-layout';
import { Head } from '@inertiajs/react';

export default function AboutUs() {
    return (
        <AppHeaderLayout>
            <Head title="Sobre nosotros"></Head>
            <div className="min-h-screen">
                <div className="container mx-auto px-6 py-6">
                    <h1 className="mb-4 text-4xl font-bold text-neutral-800 lg:text-5xl">Sobre nosotros</h1>
                    <div className="mx-auto mt-4 flex max-w-6xl grid-cols-1 gap-12 md:grid-cols-2">
                        <div className="flex items-center gap-4">
                            <Card className="relative overflow-hidden border-0 bg-white/80 shadow-xl backdrop-blur-sm transition-all duration-500">
                                <div className="absolute inset-0"></div>
                                <CardContent className="relative p-8">
                                    <div className="mb-6 flex items-center space-x-4">
                                        <h2 className="text-3xl font-bold text-neutral-800">Misión</h2>
                                    </div>
                                    <p className="text-lg leading-relaxed text-neutral-700">
                                        En The Owl, la Bodega de Líquidos, nuestra misión es ofrecer a nuestros clientes una amplia gama de bebidas de
                                        alta calidad, garantizando un servicio eficiente, confiable y personalizado. Nos comprometemos a satisfacer
                                        las necesidades de consumo de nuestros clientes, promoviendo la cultura del disfrute responsable,
                                        fortaleciendo relaciones duraderas y contribuyendo al desarrollo del mercado local mediante innovación,
                                        excelencia operativa y un enfoque constante en la experiencia del cliente.
                                    </p>

                                    <div className="absolute top-4 right-4 opacity-20">
                                        <div className="flex space-x-2">
                                            <span className="text-2xl">🍾</span>
                                            <span className="text-2xl">🥃</span>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                        <div className="flex items-center gap-4">
                            <Card className="hover:shadow-3xl 5 relative overflow-hidden border-0 bg-white/80 shadow-xl backdrop-blur-sm transition-all duration-500">
                                <div className="absolute inset-0"></div>
                                <CardContent className="relative p-8">
                                    <div className="mb-6 flex items-center space-x-4">
                                        <h2 className="text-3xl font-bold text-neutral-800">Visión</h2>
                                    </div>
                                    <p className="text-lg leading-relaxed text-neutral-700">
                                        Nuestra visión es consolidarnos como la bodega líder y referente en el sector de bebidas, reconocida por la
                                        diversidad de productos, la innovación en el servicio y la excelencia empresarial. Aspiramos a expandir
                                        nuestra presencia en la región, siendo un modelo de gestión responsable y sostenible, generando valor para
                                        nuestros clientes, colaboradores y la comunidad, y posicionándonos como un referente de confianza, calidad y
                                        profesionalismo en la industria de distribución y comercialización de líquidos.
                                    </p>

                                    <div className="absolute top-4 right-4 opacity-20">
                                        <div className="flex space-x-2">
                                            <span className="text-2xl">🍻</span>
                                            <span className="text-2xl">🍸</span>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>

                <div className="bg-white/50 backdrop-blur-sm">
                    <div className="container mx-auto px-6 py-20">
                        <div className="mx-auto max-w-6xl">
                            <div className="mb-12 text-center">
                                <h2 className="mb-4 text-3xl font-bold text-neutral-800 lg:text-4xl">Encuéntranos</h2>
                                <p className="mx-auto max-w-2xl text-xl text-neutral-600">
                                    Visítanos en nuestra ubicación y descubre nuestra amplia selección de bebidas de calidad
                                </p>
                            </div>

                            <Card className="overflow-hidden border-0 bg-white/80 shadow-2xl backdrop-blur-sm">
                                <CardContent className="p-2">
                                    <div className="grid gap-0 lg:grid-cols-2">
                                        <div className="h-96 rounded lg:h-[500px]">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d997.4449490481085!2d-79.17334243049032!3d-0.2517838999841053!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d5464946f26557%3A0x656dcf116b71f8d7!2sC.%20Ejercito%20Ecuatoriano%20264%2C%20Santo%20Domingo%20230107!5e0!3m2!1ses-419!2sec!4v1757813184427!5m2!1ses-419!2sec"
                                                width="100%"
                                                height="100%"
                                                style={{ border: 0, background: 'transparent' }}
                                                allowfullscreen
                                                loading="lazy"
                                                referrerpolicy="no-referrer-when-downgrade"
                                            ></iframe>
                                        </div>

                                        <div className="flex items-center bg-gradient-to-br p-8 lg:p-12">
                                            <div className="w-full">
                                                <div className="mb-8">
                                                    <h3 className="mb-4 flex items-center text-2xl font-bold text-neutral-800">
                                                        <span className="mr-3 text-3xl">📍</span>
                                                        Nuestra Ubicación
                                                    </h3>
                                                    <p className="text-lg leading-relaxed text-neutral-600">
                                                        Te esperamos en nuestra bodega para brindarte la mejor experiencia en la selección de tus
                                                        bebidas favoritas. Nuestro equipo está listo para asesorarte y ayudarte a encontrar
                                                        exactamente lo que buscas.
                                                    </p>
                                                </div>

                                                <div className="space-y-6">
                                                    <div className="flex items-start space-x-4">
                                                        <div className="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br">
                                                            <span className="text-xl">🕒</span>
                                                        </div>
                                                        <div>
                                                            <h4 className="mb-1 font-semibold text-neutral-800">Horarios de Atención</h4>
                                                            <p className="text-neutral-600">Lunes a Sábado: 6:00 AM - 6:00 PM </p>
                                                            <p className="text-neutral-600">Domingos: 6:00 AM - 3:00 PM</p>
                                                        </div>
                                                    </div>

                                                    <div className="flex items-start space-x-4">
                                                        <div className="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl">
                                                            <span className="text-xl">📞</span>
                                                        </div>
                                                        <div>
                                                            <h4 className="mb-1 font-semibold text-gray-800">Contáctanos</h4>
                                                            <p className="text-gray-600">+593 XX XXX XXXX</p>
                                                            <p className="text-gray-600">info@theowlbodega.com</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </div>
            </div>
        </AppHeaderLayout>
    );
}
