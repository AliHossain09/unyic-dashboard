import Button from "../../../../components/ui/Button";
import WishlistButton from "../../../../components/ui/WishlistButton";
import type { Product } from "../../../../types";
import ProductImages from "./ProductImages";
import Divider from "./Divider";
import ProductInfo from "./ProductInfo";
import ProductSizeSelector from "../../../../components/ui/ProductSizeSelector";
import useProductSizeSelector from "../../../../hooks/useProductSizeSelector";
import useAddToCart from "../../../../hooks/useAddToCart";
import DetailsAndDisclosure from "./DetailsAndDisclosure";
import { useSearchParams } from "react-router";
import { isValidProductSize } from "../../../../utlis/product";

interface ProductViewProps {
  product: Product;
}

const ProductView = ({ product }: ProductViewProps) => {
  const { id, images, name, details, disclosure, price, sizes } = product || {};
  const [searchParams] = useSearchParams();

  const sizeFromUrl = searchParams.get("size");
  const defaultSize = isValidProductSize(sizeFromUrl) ? sizeFromUrl : undefined;

  const { selectedSize, setSelectedSize } = useProductSizeSelector({
    defaultSize,
    sizes,
  });

  const { addToCart, isAddingToCart } = useAddToCart();

  const handleAddToCart = () => {
    if (!selectedSize) {
      const sizeSelector = document.getElementById("size-selector");
      if (sizeSelector) {
        sizeSelector.scrollIntoView({ behavior: "smooth" });
      }
    }

    if (isAddingToCart) {
      return;
    }

    addToCart(id, selectedSize);
  };

  return (
    <div className="ui-container mb-12 lg:mt-12 grid lg:grid-cols-[60%_1fr] gap-6 lg:gap-8">
      {/* Product images & wishlist button */}
      <div className="relative">
        <ProductImages images={images} />
        <WishlistButton productId={id} />
      </div>

      <div className="relative lg:space-y-8">
        <ProductInfo name={name} brand={details?.brand} price={price} />

        <Divider className="my-5" />

        {/* Size selector section */}
        <div id="size-selector" className="-mb-px scroll-mt-23 lg:scroll-mt-36">
          <div className="mb-3 flex items-center justify-between font-semibold text-sm">
            <p>Select Size</p>

            <button className="underline">Size Chart</button>
          </div>

          <ProductSizeSelector
            sizes={sizes}
            selectedSize={selectedSize}
            setSelectedSize={setSelectedSize}
          />
        </div>

        {/* Add to cart button (desktop) */}
        <Button
          onClick={handleAddToCart}
          disabled={isAddingToCart}
          className="hidden lg:block !w-10/12 mt-2 mx-auto"
        >
          {isAddingToCart ? "Adding..." : "Add To Cart"}
        </Button>

        <Divider className="my-2" />

        {/* Product details & disclosure */}
        <DetailsAndDisclosure details={details} disclosure={disclosure} />

        {/* Add to cart button (mobile sticky) */}
        <div
          className="lg:hidden mt-4 bg-light w-full py-2 px-2 sticky bottom-0"
          style={{
            boxShadow: "11px 0px 0px 0px #f9f6f2, -11px 0px 0px 0px #f9f6f2",
          }}
        >
          <Button onClick={handleAddToCart} disabled={isAddingToCart}>
            {isAddingToCart ? "Adding..." : "Add To Cart"}
          </Button>
        </div>
      </div>
    </div>
  );
};

export default ProductView;
