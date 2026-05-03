import { createContext } from "react";
import type { Id } from "../../types";
import type { Product } from "../../types/product";

type WishlistContextType = {
  wishlist: Product[];
  isWishlistLoading: boolean;
  isInWishlist: (productId: Id) => boolean;
};

export const WishlistContext = createContext<WishlistContextType | null>(null);
