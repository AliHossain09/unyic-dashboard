import { createContext } from "react";
import type { Id, Product } from "../../types";

type WishlistContextType = {
  wishlist: Product[];
  isWishlistLoading: boolean;
  isInWishlist: (productId: Id) => boolean;
};

export const WishlistContext = createContext<WishlistContextType | null>(null);
