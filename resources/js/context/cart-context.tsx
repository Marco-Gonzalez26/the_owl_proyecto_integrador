import { createContext, useState } from 'react';

export type CartItem = {
    ProductId: number;
    Quantity: number;
    Price: number;
    Image: string;
    Name: string;
};

type CartContextType = {
    cart: CartItem[];
    addToCart: (product: CartItem) => void;
    removeFromCart: (product: CartItem) => void;
};

export const CartContext = createContext<CartContextType>({
    cart: [],
    addToCart: () => {},
    removeFromCart: () => {},
});

export const CartProvider = ({ children }: { children: React.ReactNode }) => {
    const [cart, setCart] = useState<CartItem[]>([]);

    const addToCart = (product: CartItem) => {
        setCart((prev) => [...prev, product]);
    };

    const removeFromCart = (product: CartItem) => {
        setCart((prev) => prev.filter((p) => p.ProductId !== product.ProductId));
    };

    return <CartContext.Provider value={{ cart, addToCart, removeFromCart }}>{children}</CartContext.Provider>;
};
