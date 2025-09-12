import { CartContext } from '@/context/cart-context';
import { useContext } from 'react';

export const useCart = () => {
    const context = useContext(CartContext);

    if (!context) {
        throw new Error('CartProvider must be used within a CartProvider');
    }

    return context;
};
