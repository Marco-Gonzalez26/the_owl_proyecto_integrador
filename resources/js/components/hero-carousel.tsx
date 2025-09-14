'use client';
import { Card, CardContent } from '@/components/ui/card';
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel';
import Autoplay from 'embla-carousel-autoplay';
import * as React from 'react';

export const HeroCarousel = ({ items }: { items?: any[] }) => {
    const plugin = React.useRef(Autoplay({ delay: 2000, stopOnInteraction: true }));
    return (
        <Carousel
            plugins={[plugin.current]}
            className="h-3/4 w-full max-w-6xl border-1"
            onMouseEnter={plugin.current.stop}
            onMouseLeave={plugin.current.reset}
        >
            <CarouselContent className="h-full w-full">
                {Array.from({ length: 5 }).map((_, index) => (
                    <CarouselItem key={index} className="h-full w-full">
                        <div className="h-full w-full p-1">
                      

                        </div>
                    </CarouselItem>
                ))}
            </CarouselContent>
            <CarouselPrevious />
            <CarouselNext />
        </Carousel>
    );
};
