import { Link } from "react-router";
import type { CartItem } from "../../../../../../types";
import { PiSpinnerGapBold } from "react-icons/pi";
import { FiTrash2 } from "react-icons/fi";
import { useRemoveCartItemMutation } from "../../../../../../store/features/cart/cartApi";
import { getDefaultImageUrl } from "../../../../../../utlis/product";

interface MiniCartCardProps {
  item: CartItem;
}

const MiniCartCard = ({ item }: MiniCartCardProps) => {
  const { id: cartItemId, product, quantity, size } = item || {};
  const { slug, images = [], name, brand, price } = product || {};
  const [removeCartItem, { isLoading, isSuccess, error }] =
    useRemoveCartItemMutation();

  if (isSuccess) {
    return null; // Return null to remove the item from the UI while refetching the cart to avoid flicker
  }

  if (error) {
    console.log("Error removing cart item:", error);
  }

  return (
    <li className="py-3 pe-1 grid grid-cols-3 gap-4">
      <Link to={`/product/${slug}`} title={name}>
        <img
          src={getDefaultImageUrl(images)}
          alt={name}
          className="block w-full h-full object-cover"
        />
      </Link>

      <div className="col-span-2 text-xs flex justify-between gap-1">
        <div className="space-y-2">
          <p className="font-bold me-6">{brand}</p>
          <p>{name}</p>

          <p className="font-semibold">₹ {price?.sellingPrice}</p>
          <p className="space-x-2 text-dark-light">
            <span>Size: {size}</span>
            <span>Qty: {quantity}</span>
          </p>
        </div>

        <div className="flex-none size-6">
          {isLoading ? (
            <button className="size-full grid place-items-center">
              <PiSpinnerGapBold size={18} />
            </button>
          ) : (
            <button
              onClick={() => removeCartItem(cartItemId)}
              className="size-full grid place-items-center"
            >
              <FiTrash2 size={18} />
            </button>
          )}
        </div>
      </div>
    </li>
  );
};

export default MiniCartCard;
