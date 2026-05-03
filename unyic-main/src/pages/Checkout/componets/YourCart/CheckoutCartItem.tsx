import type { CartItem } from "../../../../types";
import { getDefaultImageUrl } from "../../../../utlis/product";

interface CheckoutCartItemProps {
  cartItem: CartItem;
}

const CheckoutCartItem = ({ cartItem }: CheckoutCartItemProps) => {
  const { id, product, quantity, size } = cartItem || {};
  const { images, name, price } = product || {};

  return (
    <div key={id} className="py-4 flex gap-4">
      <figure className="w-20 product-image-ratio rounded-md bg-gray-200">
        <img
          src={getDefaultImageUrl(images)}
          alt=""
          className="size-full rounded-md object-cover"
        />
      </figure>

      <div className="flex-1">
        <h4 className="mb-1.5 font-semibold">{name}</h4>
        <div className="text-sm text-dark-light">
          <p>Size: {size}</p>
          <p>Qty: {quantity}</p>
        </div>

        <p className="w-max ms-auto font-semibold">
          ₹{price.sellingPrice * quantity}
        </p>
      </div>
    </div>
  );
};

export default CheckoutCartItem;
