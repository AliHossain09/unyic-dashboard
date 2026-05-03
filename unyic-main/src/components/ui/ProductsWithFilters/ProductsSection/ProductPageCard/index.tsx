import { Link, useNavigate } from "react-router";
import type { Product } from "../../../../../types/product";
import useScreenSize from "../../../../../hooks/useScreenSize";
import { getDefaultImageUrl } from "../../../../../utlis/product";
import ProductCardImageCarousel from "./ProductCardImageCarousel";
import WishlistButton from "../../../../../components/ui/WishlistButton";

interface ProductPageCardProps {
  product: Product;
}

const ProductPageCard = ({ product }: ProductPageCardProps) => {
  const { isMobileScreen, isDesktopScreen } = useScreenSize();
  const { id, slug, name, images, price, details, sizes } = product || {};
  const navigate = useNavigate();

  const handleSizeClick = (e: React.MouseEvent, size: string) => {
    e.preventDefault(); // prevent triggering the outer Link
    e.stopPropagation();
    navigate(`/product/${slug}?size=${size}`);
  };

  return (
    <div className="relative">
      <Link to={`/product/${slug}`} className="group space-y-3" title={name}>
        {/* Show a single image on mobile screen or if only has one image, otherwise use an image carousel */}
        <div className="product-image-ratio sm:rounded bg-gray-200 overflow-hidden relative">
          {isMobileScreen || images.length < 2 ? (
            <img
              src={getDefaultImageUrl(images)}
              alt=""
              className="w-full product-image-ratio object-cover"
            />
          ) : (
            <ProductCardImageCarousel images={images} />
          )}

          {isDesktopScreen && sizes && sizes.length > 0 && (
            <div className="hidden group-hover:block p-5 bg-light/60 absolute inset-x-0 bottom-0">
              <div className="flex justify-center text-xs">
                {sizes?.map((size, index) => (
                  <button
                    key={index}
                    onClick={(e) => handleSizeClick(e, size?.size)}
                    className="p-2 bg-light hover:bg-primary-dark hover:text-light"
                  >
                    {size?.size}
                  </button>
                ))}
              </div>
            </div>
          )}
        </div>

        <div className="h-14 sm:h-22 px-2 sm:px-3 space-y-1 text-xs sm:text-sm">
          <h3 className="uppercase font-semibold text-dark-light">
            {details?.brand}
          </h3>
          <p className="line-clamp-1 sm:line-clamp-2">{name}</p>
          <p>₹ {price?.sellingPrice}</p>
        </div>
      </Link>

      <WishlistButton productId={id} />
    </div>
  );
};

export default ProductPageCard;
