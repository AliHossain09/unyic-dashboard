import { useMemo } from "react";
import { useGetWishlistProductsQuery } from "../../store/features/wishlist/wishlistApi";
import type { Id } from "../../types";
import { WishlistContext } from "./wishlistContext";

interface WishlistProviderProps {
  children: React.ReactNode;
}

const WishlistProvider = ({ children }: WishlistProviderProps) => {
  const {
    data: wishlist = [],
    isLoading,
    isUninitialized,
  } = useGetWishlistProductsQuery();

  const wishlistIds = useMemo(
    () => new Set(wishlist.map((item) => item.id)),
    [wishlist]
  );

  const isInWishlist = (productId: Id) => wishlistIds.has(productId);

  return (
    <WishlistContext
      value={{
        wishlist,
        isInWishlist,
        isWishlistLoading: isUninitialized || isLoading,
      }}
    >
      {children}
    </WishlistContext>
  );
};

export default WishlistProvider;
