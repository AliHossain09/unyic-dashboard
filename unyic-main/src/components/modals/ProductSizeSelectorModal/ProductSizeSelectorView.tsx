import useAddToCart from "../../../hooks/useAddToCart";
import useProductSizeSelector from "../../../hooks/useProductSizeSelector";
import type { Product } from "../../../types/product";
import ProductSizeSelector from "../../ui/ProductSizeSelector";

interface ProductSizeSelectorViewProps {
  product: Product;
  closeModal: () => void;
}

const ProductSizeSelectorView = ({
  product,
  closeModal,
}: ProductSizeSelectorViewProps) => {
  const { id, images, name, price, details, sizes = [] } = product || {};

  const { selectedSize, setSelectedSize } = useProductSizeSelector({ sizes });

  const { addToCart, isAddingToCart } = useAddToCart();

  const handleAddToCart = () => {
    if (isAddingToCart) {
      return;
    }

    addToCart(id, selectedSize, () => {
      // Close the modal after successfully adding to cart
      closeModal();
    });
  };

  return (
    <>
      <div className="mt-5 p-3">
        <div className="mb-4 flex items-center gap-3">
          <img src={images[0].url} alt="" className="w-20" />

          <div className="space-y-1">
            <p className="text-sm font-semibold">{details?.brand}</p>
            <p className="text-[13px] text-dark-light leading-snug">{name}</p>
            <p className="text-sm font-semibold">₹ {price.sellingPrice}</p>
          </div>
        </div>

        <div className="space-y-2">
          <p className="text-sm text-dark-light">Select Size</p>

          <ProductSizeSelector
            sizes={sizes}
            selectedSize={selectedSize}
            setSelectedSize={setSelectedSize}
          />
        </div>
      </div>

      <div className="p-3 border-t">
        <button
          onClick={handleAddToCart}
          disabled={isAddingToCart}
          className="w-full py-3 rounded shadow-md bg-primary-dark uppercase text-light font-semibold text-sm"
        >
          {isAddingToCart ? "Adding..." : "Add To Cart"}
        </button>
      </div>
    </>
  );
};

export default ProductSizeSelectorView;
