import clsx from "clsx";
import ProductCardSkeleton from "../../cards/ProductCard/ProductCardSkeleton";

const ProductsCarouselSkeleton = () => {
  return (
    <div className="overflow-x-auto hide-scrollable lg:overflow-hidden">
      <div className="flex -ms-3 sm:-ms-5">
        {Array(8)
          .fill(0)
          .map((_, index) => (
            <div
              key={index}
              className={clsx(
                "w-7/12 sm:w-[35%] lg:w-[25%] xl:w-[20%]",
                "flex-none ps-3 sm:ps-5 p-px"
              )}
            >
              <ProductCardSkeleton />
            </div>
          ))}
      </div>
    </div>
  );
};

export default ProductsCarouselSkeleton;
