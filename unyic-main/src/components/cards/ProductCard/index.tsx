import { Link } from "react-router";
import type { Product } from "../../../types";
import WishlistButton from "../../ui/WishlistButton";
import ProductCardDetails from "./components/ProductCardDetails";
import AddToCartWithSizes from "./components/AddToCartWithSizes";
import { getDefaultImageUrl } from "../../../utlis/product";

interface ProductCardProps {
  product: Product;
}

const ProductCard = ({ product }: ProductCardProps) => {
  const { id, slug, images = [], details, name, price } = product || {};

  return (
    <div className="group/product-card relative">
      <Link to={`/product/${slug}`} title={name}>
        <figure className="product-image-ratio bg-gray-200">
          <img
            src={getDefaultImageUrl(images)}
            alt=""
            className="size-full object-cover"
          />
        </figure>

        <ProductCardDetails brand={details?.brand} name={name} price={price} />
      </Link>

      <AddToCartWithSizes product={product} />

      <WishlistButton productId={id} />
    </div>
  );
};

export default ProductCard;
