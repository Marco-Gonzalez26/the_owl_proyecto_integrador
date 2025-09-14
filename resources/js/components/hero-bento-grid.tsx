type BentoGridProps = {
    items: any[];
};

export const HeroBentoGrid = ({ items }: BentoGridProps) => {
    return (
        <div className="flex h-screen w-full items-center justify-center p-4">
            <div className="grid h-full w-full max-w-6xl grid-cols-4 grid-rows-4 gap-4 rounded-lg bg-white p-4">
                {items.map((item, index) => {
                    const isLargeItem = index % 4 === 0;

                    return (
                        <div
                            key={item.id}
                            className={`group relative cursor-pointer overflow-hidden rounded-lg transition-all duration-300 hover:shadow-xl ${isLargeItem ? 'col-span-2 row-span-1' : 'col-span-2 row-span-3'} `}
                        >
                            {/* Imagen */}
                            <img
                                src={item.image}
                                alt={item.name}
                                className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                            />

                            {/* Overlay con información */}
                            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div className="absolute right-0 bottom-0 left-0 p-4 text-white">
                                    <h3 className="mb-1 translate-y-4 transform text-lg font-bold transition-transform duration-300 group-hover:translate-y-0">
                                        {item.name}
                                    </h3>
                                    <div className="flex translate-y-4 transform items-center justify-between transition-transform delay-75 duration-300 group-hover:translate-y-0">
                                        <span className="text-2xl font-semibold text-green-400">${item.price.toFixed(2)}</span>
                                        <span className="rounded-full bg-white/20 px-3 py-1 text-sm backdrop-blur-sm">Cantidad: {item.quantity}</span>
                                    </div>
                                </div>
                            </div>

                            {/* Indicador de hover sutil */}
                            <div className="absolute top-2 right-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                <div className="h-3 w-3 animate-pulse rounded-full bg-white shadow-lg"></div>
                            </div>
                        </div>
                    );
                })}
            </div>
        </div>
    );
};
