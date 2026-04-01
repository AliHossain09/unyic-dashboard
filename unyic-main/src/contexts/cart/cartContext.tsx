import { createContext } from "react";
import type { CartItem, Id } from "../../types";
import type { UpdateCartItemPayload } from "../../store/features/cart/cartApi";

type CartContextType = {
  cart: CartItem[];
  isCartLoading: boolean;
  isCartRefetching: boolean;
  cartTotal: number;
  isUpdating: boolean;
  isDeleting: boolean;
  updateCartItem: (payload: UpdateCartItemPayload) => void;
  removeCartItem: (cartItemId: Id) => void;
};

export const CartContext = createContext<CartContextType | null>(null);
