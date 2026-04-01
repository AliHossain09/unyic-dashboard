import type { CartItem } from "../../../../../../types";
import MoveToWishlistButton from "./MoveToWishlistButton";
import RemoveFromCartButton from "./RemoveFromCartButton";

interface CartCardActionsProps {
  cartItem: CartItem;
}

const CartCardActions = ({ cartItem }: CartCardActionsProps) => {
  return (
    <div className="h-12 sm:h-10 border-t flex divide-x absolute bottom-0 inset-x-0 sm:static">
      <RemoveFromCartButton cartItem={cartItem} />
      <MoveToWishlistButton
        cartItemId={cartItem?.id}
        productId={cartItem?.product?.id}
      />
    </div>
  );
};

export default CartCardActions;
