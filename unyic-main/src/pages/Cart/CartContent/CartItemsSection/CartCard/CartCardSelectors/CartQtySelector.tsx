import DropdownSelector from "../../../../../../components/ui/DropdownSelector";
import LoadingOverlay from "../../../../../../components/ui/LoadingOverlay";
import {
  useUpdateCartItemMutation,
  type UpdateCartItemPayload,
} from "../../../../../../store/features/cart/cartApi";
import type { Id } from "../../../../../../types";
import type {
  ProductSize,
  ProductSizeItem,
} from "../../../../../../types/product";

interface CartQtySelectorProps {
  cartItemId: Id;
  size: ProductSize;
  quantity: string;
  availableSizes: ProductSizeItem[];
}

const CartQtySelector = ({
  cartItemId,
  size,
  quantity,
  availableSizes,
}: CartQtySelectorProps) => {
  const [updateCartItem, { isLoading, error }] = useUpdateCartItemMutation();

  const updateQuantity = (quantity: string) => {
    const payload: UpdateCartItemPayload = {
      cartItemId,
      size,
      quantity: parseInt(quantity, 10),
    };

    updateCartItem(payload);
  };

  if (error) {
    console.error("Error updating cart item quantity:", error);
  }

  const selectedSizeQty =
    availableSizes.find((item) => item.size === size)?.quantity || 0;

  const quantityOptions = Array.from({ length: selectedSizeQty }, (_, idx) =>
    (idx + 1).toString(),
  );

  return (
    <>
      {isLoading && <LoadingOverlay />}

      <div className="sm:flex items-center gap-2">
        <p className="font-semibold text-sm text-dark-light">Qty</p>
        <div className="w-20">
          <DropdownSelector
            selected={quantity}
            list={quantityOptions}
            onSelect={updateQuantity}
            defaultText="Select"
          />
        </div>
      </div>
    </>
  );
};

export default CartQtySelector;
