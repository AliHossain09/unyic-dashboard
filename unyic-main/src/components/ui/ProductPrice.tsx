import type { ProductPrice as ProductPriceType } from "../../types";

interface ProductPriceProps {
  price: ProductPriceType;
}

const ProductPrice = ({ price }: ProductPriceProps) => {
  const { sellingPrice, discountPercent, originalPrice } = price || {};

  return (
    <div className="mt-1 flex flex-wrap text-right gap-x-2">
      <span className="font-semibold">₹ {sellingPrice}</span>

      {originalPrice && originalPrice > sellingPrice && (
        <span className="text-dark-light line-through">₹{originalPrice}</span>
      )}

      {discountPercent > 0 && (
        <span className="text-primary">{discountPercent}% off</span>
      )}
    </div>
  );
};

export default ProductPrice;