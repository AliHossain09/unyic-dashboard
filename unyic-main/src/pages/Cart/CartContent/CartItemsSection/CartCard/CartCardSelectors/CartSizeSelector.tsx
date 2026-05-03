import DropdownSelector from "../../../../../../components/ui/DropdownSelector";
import LoadingOverlay from "../../../../../../components/ui/LoadingOverlay";
import {
  useUpdateCartItemMutation,
  type UpdateCartItemPayload,
} from "../../../../../../store/features/cart/cartApi";
import type { Id } from "../../../../../../types";
import type { ProductSize } from "../../../../../../types/product";
import { isValidProductSize } from "../../../../../../utlis/product";

interface CartSizeSelectorProps {
  cartItemId: Id;
  size: ProductSize;
  sizeOptions: ProductSize[];
}

const CartSizeSelector = ({
  cartItemId,
  size,
  sizeOptions,
}: CartSizeSelectorProps) => {
  const [updateCartItem, { isLoading, error }] = useUpdateCartItemMutation();

  const updateSize = (selectedSize: string) => {
    if (!isValidProductSize(selectedSize)) {
      return;
    }

    const payload: UpdateCartItemPayload = {
      cartItemId,
      size: selectedSize,
      quantity: 1,
    };

    updateCartItem(payload);
  };

  if (error) {
    console.error("Error updating cart item size:", error);
  }

  return (
    <>
      {isLoading && <LoadingOverlay />}

      <div className="sm:flex items-center gap-2">
        <p className="w-6 font-semibold text-sm text-dark-light">Size</p>

        <div className="w-20">
          <DropdownSelector
            selected={size}
            list={sizeOptions}
            onSelect={updateSize}
            defaultText="Select"
          />
        </div>
      </div>
    </>
  );
};

export default CartSizeSelector;
