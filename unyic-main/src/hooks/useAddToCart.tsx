import toast from "react-hot-toast";
import useRequireAuth from "./useRequireAuth";
import { useAddToCartMutation } from "../store/features/cart/cartApi";
import type { Id, ProductSize } from "../types";

const useAddToCart = () => {
  const { requireAuth } = useRequireAuth();
  const [addToCart, { isLoading }] = useAddToCartMutation();

  const handleAddToCart = (
    productId: Id,
    selectedSize: ProductSize | null,
    onSuccess?: () => void
  ) => {
    requireAuth(() => {
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
    });
  };

  return {
    addToCart: handleAddToCart,
    isAddingToCart: isLoading,
  };
};

export default useAddToCart;
