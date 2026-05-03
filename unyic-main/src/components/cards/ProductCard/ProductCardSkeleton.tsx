import clsx from "clsx";

const ProductCardSkeleton = () => {
  return (
    <div className={clsx("animate-pulse")}>
      <div className="product-image-ratio bg-gray-200" />

      <div className="h-26 sm:h-21 p-3 border-x space-y-2 bg-light">
        <p className="h-4 w-6/12 rounded-md bg-gray-200" />
        <p className="h-3 rounded-md bg-gray-200" />
        <p className="h-4 w-8/12 rounded-md bg-gray-200" />
      </div>

      <div className="h-11 border bg-light grid place-items-center">
        <div className="h-6 w-32 rounded-md bg-gray-200" />
      </div>
    </div>
  );
};

export default ProductCardSkeleton;
