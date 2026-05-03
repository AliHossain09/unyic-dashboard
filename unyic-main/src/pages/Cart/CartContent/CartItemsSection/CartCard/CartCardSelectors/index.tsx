import CartQtySelector from "./CartQtySelector";
import CartSizeSelector from "./CartSizeSelector";
import type { Id } from "../../../../../../types";
import type {
  ProductSize,
  ProductSizeItem,
} from "../../../../../../types/product";

interface CartCardSelectorsProps {
  cartItemId: Id;
  size: ProductSize;
  quantity: number;
  availableSizes: ProductSizeItem[];
}

const CartCardSelectors = ({
  cartItemId,
  size,
  quantity,
  availableSizes,
}: CartCardSelectorsProps) => {
  return (
    <div className="flex gap-2">
      <CartSizeSelector
        cartItemId={cartItemId}
        size={size}
        sizeOptions={availableSizes.map((sizeItem) => sizeItem.size)}
      />

      <CartQtySelector
        cartItemId={cartItemId}
        size={size}
        quantity={quantity.toString()}
        availableSizes={availableSizes}
      />
    </div>
  );
};

export default CartCardSelectors;
