import type { Id } from "../../types";
import clsx from "clsx";
import { useWishlist } from "../../contexts/wishlist/useWishlist";
import {
  useAddToWishlistMutation,
  useRemoveFromWishlistMutation,
} from "../../store/features/wishlist/wishlistApi";
import { VscHeartFilled } from "react-icons/vsc";

interface WishlistButtonProps {
  productId: Id;
}

const WishlistButton = ({ productId }: WishlistButtonProps) => {
  const { isInWishlist } = useWishlist();
  const [addToWishlist, { isLoading: isAdding }] = useAddToWishlistMutation();
  const [removeFromWishlist, { isLoading: isRemoving }] =
    useRemoveFromWishlistMutation();

  const isWishlisted = isInWishlist(productId);
  const isLoading = isAdding || isRemoving;

  const toggleWishlist = () => {
    if (isLoading) return;

    if (isWishlisted) {
      removeFromWishlist(productId);
      return;
    }

    addToWishlist(productId);
  };

  return (
    <button
      onClick={() => toggleWishlist()}
      disabled={isLoading}
      className={clsx(
        "size-8 grid place-items-center absolute top-0 right-0",
        isLoading && "opacity-50",
      )}
      title={isWishlisted ? "Remove From Wishlist" : "Add To Wishlist"}
    >
      <span className="mt-2 me-1">
        {isWishlisted ? (
          <VscHeartFilled size={22} className="text-primary-dark" />
        ) : (
          <VscHeartFilled
            size={21}
            className="text-white/80"
            style={{
              filter: `
                drop-shadow(1px 1px 0px rgba(0, 0, 0, 0.3))
                drop-shadow(-1px 1px 0px rgba(0, 0, 0, 0.3))
                drop-shadow(1px -1px 0px rgba(0, 0, 0, 0.3))
                drop-shadow(-1px -1px 0px rgba(0, 0, 0, 0.3))
            `,
            }}
          />
        )}
      </span>
    </button>
  );
};

export default WishlistButton;
