import { CartContext } from '@/context/cart-context';
import { useContext } from 'react';

export const useCart = () => {
    const context = useContext(CartContext);
    if (!context || context.addToCart.toString() === '() => {}') {
        throw new Error('useCart debe usarse dentro de CartProvider');
    }
    return context;
};
