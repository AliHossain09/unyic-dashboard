import { Link } from "react-router";
import type { CartItem } from "../../../../../types";
import CartCardActions from "./CartCardActions";
import CartCardSelectors from "./CartCardSelectors";
import { getDefaultImageUrl } from "../../../../../utlis/product";

interface CartCardProps {
  cartItem: CartItem;
}

const CartCard = ({ cartItem }: CartCardProps) => {
  const { id: cartItemId, size, quantity, product } = cartItem || {};
  const {
    images = [],
    name,
    slug,
    brand,
    price,
    sizes: availableSizes = [],
  } = product || {};

  return (
    <div className="h-55 pb-15 p-3 sm:p-4 flex gap-3 bg-light relative">
      <Link to={`/product/${slug}`} className="h-full">
        <img
          src={getDefaultImageUrl(images)}
          alt="Product Image"
          className="h-full product-image-ratio object-cover"
        />
      </Link>

      <div className="flex-1 flex flex-col justify-between gap-3">
        <div className="space-y-2">
          <div className="h-20 space-y-1">
            <h3 className="text-sm font-semibold">Brand{brand}</h3>
            <p className="text-dark-light text-xs sm:text-sm line-clamp-2">
              {name}
            </p>
            <p className="text-sm sm:text-base">₹{price?.sellingPrice}</p>
          </div>

          <CartCardSelectors
            cartItemId={cartItemId}
            size={size}
            quantity={quantity}
            availableSizes={availableSizes}
          />
        </div>

        <CartCardActions cartItem={cartItem} />
      </div>
    </div>
  );
};

export default CartCard;
