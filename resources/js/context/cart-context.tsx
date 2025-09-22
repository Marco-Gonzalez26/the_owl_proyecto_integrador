import { createContext, useEffect, useState } from 'react';

export type CartItem = {
    id: number;
    quantity: number;
    price: number;
    image: string;
    name: string;
};

type CartContextType = {
    cart: CartItem[];
    addToCart: (product: CartItem) => void;
    removeFromCart: (product: CartItem) => void;
    clearCart: () => void;
    getTotalItems: () => number;
    getTotalPrice: () => number;
    reduceItemQuantity: (product: CartItem) => void;
    increaseItemQuantity: (product: CartItem) => void;
};

export const CartContext = createContext<CartContextType>({
    cart: [],
    addToCart: () => {},
    removeFromCart: () => {},
    clearCart: () => {},
    getTotalItems: () => 0,
    getTotalPrice: () => 0,
    reduceItemQuantity: () => {},
    increaseItemQuantity: () => {},
});

export const CartProvider = ({ children }: { children: React.ReactNode }) => {
    const [cart, setCart] = useState<CartItem[]>([]);
    useEffect(() => {
        const savedCart = localStorage.getItem('cart');
        if (savedCart) {
            try {
                setCart(JSON.parse(savedCart));
            } catch (error) {
                console.error('Error al cargar el carrito desde localStorage:', error);
                localStorage.removeItem('cart');
            }
        }
    }, []);

    useEffect(() => {
        localStorage.setItem('cart', JSON.stringify(cart));
    }, [cart]);

    const addToCart = (product: CartItem) => {
        setCart((prev) => [...prev, product]);
    };

    const reduceItemQuantity = (product: CartItem) => {
        setCart((prev) => prev.map((p) => (p.id === product.id ? { ...p, quantity: p.quantity - 1 } : p)));
    };
    const increaseItemQuantity = (product: CartItem) => {
        setCart((prev) => prev.map((p) => (p.id === product.id ? { ...p, Quantity: p.quantity + 1 } : p)));
    };

    const removeFromCart = (product: CartItem) => {
        setCart((prev) => prev.filter((p) => p.id !== product.id));
    };

    const clearCart = () => {
        setCart([]);
        localStorage.removeItem('cart');
    };

    const getTotalItems = () => {
        return cart.reduce((total, item) => total + item.quantity, 0);
    };

    const getTotalPrice = () => {
        return cart.reduce((total, item) => total + parseFloat(item.price.toString()) * item.quantity, 0);
    };

    return (
        <CartContext.Provider
            value={{ cart, addToCart, removeFromCart, clearCart, getTotalItems, getTotalPrice, reduceItemQuantity, increaseItemQuantity }}
        >
            {children}
        </CartContext.Provider>
    );
};
