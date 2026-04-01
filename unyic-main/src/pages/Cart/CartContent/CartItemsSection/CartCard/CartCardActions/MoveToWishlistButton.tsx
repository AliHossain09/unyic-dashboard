import { FaRegHeart } from "react-icons/fa";
import type { Id } from "../../../../../../types";
import { useAddToWishlistMutation } from "../../../../../../store/features/wishlist/wishlistApi";
import { useRemoveCartItemMutation } from "../../../../../../store/features/cart/cartApi";
import LoadingOverlay from "../../../../../../components/ui/LoadingOverlay";

interface MoveToWishlistButtonProps {
  cartItemId: Id;
  productId: Id;
}

const MoveToWishlistButton = ({
  cartItemId,
  productId,
}: MoveToWishlistButtonProps) => {
  const [addToWishlist, { isLoading: isWishlistLoading }] =
    useAddToWishlistMutation();

  const [removeCartItem, { isLoading: isRemoveLoading }] =
    useRemoveCartItemMutation();

  const handleMoveToWishlist = () => {
    addToWishlist(productId)
      .unwrap()
      .then(() => {
        removeCartItem(cartItemId)
          .unwrap()
          .catch((err) => {
            console.error("Failed to remove cart item:", err);
          });
      })
      .catch((error) => {
        console.error("Failed to add item to wishlist:", error);
      });
  };

  const isLoading = isWishlistLoading || isRemoveLoading;

  return (
    <>
      {isLoading && <LoadingOverlay />}

      <button
        onClick={handleMoveToWishlist}
        className="p-2 flex-1 flex gap-1 items-center justify-center sm:uppercase"
      >
        <FaRegHeart className="shrink-0 text-lg text-dark-light" />
        <span className="font-semibold sm:font-normal text-xs text-nowrap">
          Move To Wishlist
        </span>
      </button>
    </>
  );
};

export default MoveToWishlistButton;
