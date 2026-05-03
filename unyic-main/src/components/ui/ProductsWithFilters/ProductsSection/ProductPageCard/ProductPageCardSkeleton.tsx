import clsx from "clsx";

interface ProductPageCardSkeletonProps {
  className?: string;
}

const ProductPageCardSkeleton = ({
  className,
}: ProductPageCardSkeletonProps) => {
  return (
    <div className={clsx("space-y-3 animate-pulse", className)}>
      <div className="product-image-ratio sm:rounded bg-gray-200" />

      <div className="h-14 sm:h-22 px-2 sm:px-3 space-y-2 animate-pulse">
        {/* Brand Skeleton */}
        <div className="h-4 w-24 bg-gray-200 rounded" />

        {/* Name Skeleton */}
        <div className="h-3 w-full sm:w-5/6 bg-gray-200 rounded" />
        <div className="hidden sm:block h-3 w-4/6 bg-gray-200 rounded" />

        {/* Price Skeleton */}
        <div className="h-3 w-16 bg-gray-200 rounded" />
      </div>
    </div>
  );
};

export default ProductPageCardSkeleton;
