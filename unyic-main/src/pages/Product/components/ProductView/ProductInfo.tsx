import { IoIosArrowForward } from "react-icons/io";
import { Link } from "react-router";
import type { ProductPrice as ProductPriceType } from "../../../../types";
import ProductPrice from "../../../../components/ui/ProductPrice";

interface ProductInfoProps {
  name: string;
  brand: string;
  price: ProductPriceType;
}

const ProductInfo = ({ name, brand, price }: ProductInfoProps) => {
  return (
    <div>
      <h4 className="mb-3 font-semibold sm:text-lg">{name}</h4>

      <div className="mb-3 flex items-center gap-6 text-dark-light text-sm">
        <Link to={``} className="uppercase font-semibold">
          View Shop
        </Link>

        <Link to={``} className="hover:text-primary flex items-center gap-1">
          <span>View Full Collection</span>
          <IoIosArrowForward className="text-lg" />
        </Link>
      </div>

      <p className="mb-5 uppercase text-dark-light font-semibold text-sm">
        {brand}
      </p>

      <ProductPrice price={price} />
    </div>
  );
};

export default ProductInfo;
