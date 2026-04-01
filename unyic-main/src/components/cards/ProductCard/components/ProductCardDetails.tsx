import type { ProductPrice as ProductPriceType } from "../../../../types";
import ProductPrice from "../../../ui/ProductPrice";

interface ProductCardDetailsProps {
  brand: string;
  name: string;
  price: ProductPriceType;
}

const ProductCardDetails = ({
  brand,
  name,
  price,
}: ProductCardDetailsProps) => {
  return (
    <div className="border-x p-3 pt-2 text-sm bg-light">
      <p>{brand}</p>
      <p className="truncate text-dark-light">{name}</p>

      <ProductPrice price={price} />
    </div>
  );
};

export default ProductCardDetails;
