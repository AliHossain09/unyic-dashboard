import clsx from "clsx";
import useProductSizeSelector from "../../../../hooks/useProductSizeSelector";
import useScreenSize from "../../../../hooks/useScreenSize";
import useModalById from "../../../../hooks/useModalById";
import ProductSizeSelector from "../../../ui/ProductSizeSelector";
import useAddToCart from "../../../../hooks/useAddToCart";
import type { Product } from "../../../../types/product";

interface AddToCartWithSizesProps {
  product: Product;
}

const AddToCartWithSizes = ({ product }: AddToCartWithSizesProps) => {
  const { id, sizes = [] } = product || {};
  const { selectedSize, setSelectedSize } = useProductSizeSelector({ sizes });

  const { isMobileScreen } = useScreenSize();
  const { openModalWithData } = useModalById("productSizeSelectorModal");
  const { addToCart, isAddingToCart } = useAddToCart();

  const handleAddToCartClick = () => {
    if (isAddingToCart) {
      return;
    }

    if (isMobileScreen) {
      openModalWithData({ product });
      return;
    }

    addToCart(id, selectedSize);
  };

  return (
    <div className="px-2 py-1.25 border relative bg-light">
      {/* Add to Cart Button */}
      <button
        onClick={handleAddToCartClick}
        disabled={isAddingToCart}
        className={clsx(
          "w-full py-1.5 rounded duration-300",
          "grid place-items-center text-sm font-semibold uppercase",
          "group-hover/product-card:bg-primary-dark group-hover/product-card:shadow-md group-hover/product-card:text-light"
        )}
      >
        {isAddingToCart ? "Adding..." : "Add To Cart"}
      </button>

      {/* Size selector tooltip (hidden when adding to cart) */}
      {!isAddingToCart && (
        <div className="hidden group-hover/product-card:block p-2 pt-3 border-x bg-light absolute -inset-x-px bottom-[calc(100%+1px)]">
          <p className="mb-3 text-sm text-dark-light">Select Size</p>

          <ProductSizeSelector
            sizes={sizes}
            selectedSize={selectedSize}
            setSelectedSize={setSelectedSize}
          />
        </div>
      )}
    </div>
  );
};

export default AddToCartWithSizes;
