import { useMemo } from "react";
import {
  useGetCartQuery,
  useRemoveCartItemMutation,
  useUpdateCartItemMutation,
  type UpdateCartItemPayload,
} from "../../store/features/cart/cartApi";
import type { Id } from "../../types";
import { CartContext } from "./cartContext";

interface CartProviderProps {
  children: React.ReactNode;
}

const CartProvider = ({ children }: CartProviderProps) => {
  const {
    data: cart = [],
    isLoading,
    isUninitialized,
    isFetching,
  } = useGetCartQuery();

  const cartTotal = useMemo(() => {
    return cart.reduce((total, item) => {
      return total + item.product.price.sellingPrice * item.quantity;
    }, 0);
  }, [cart]);

  const [updateCartItemMutation, { isLoading: isUpdating }] =
    useUpdateCartItemMutation();
  const [removeCartItemMutation, { isLoading: isDeleting }] =
    useRemoveCartItemMutation();

  const updateCartItem = (payload: UpdateCartItemPayload) => {
    updateCartItemMutation(payload);
  };

  const removeCartItem = (cartItemId: Id) => {
    removeCartItemMutation(cartItemId);
  };

  return (
    <CartContext
      value={{
        cart,
        isCartLoading: isLoading || isUninitialized,
        isCartRefetching: isFetching,
        cartTotal,
        isUpdating,
        isDeleting,
        updateCartItem,
        removeCartItem,
      }}
    >
      {children}
    </CartContext>
  );
};

export default CartProvider;
