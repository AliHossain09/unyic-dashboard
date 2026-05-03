import toast from "react-hot-toast";
import { useAddToCartMutation } from "../store/features/cart/cartApi";
import type { Id } from "../types";
import type { ProductSize } from "../types/product";

const useAddToCart = () => {
  const [addToCart, { isLoading }] = useAddToCartMutation();

  const handleAddToCart = (
    productId: Id,
    selectedSize: ProductSize | null,
    onSuccess?: () => void,
  ) => {
    if (selectedSize === null) {
      toast.error("Please select size");
      return;
    }

    addToCart({ product_id: productId, size: selectedSize })
      .unwrap()
      .then(() => {
        toast.success("Product added to cart");
        onSuccess?.();
      })
      .catch((error) => {
        console.error("Failed to add product to cart:", error);
        toast.error("Failed to add product to cart");
      });
  };

  return {
    addToCart: handleAddToCart,
    isAddingToCart: isLoading,
  };
};

export default useAddToCart;
