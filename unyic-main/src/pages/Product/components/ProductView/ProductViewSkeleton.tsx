const ProductViewSkeleton = () => {
  return (
    <div className="ui-container mb-12 lg:mt-12 grid lg:grid-cols-[60%_1fr] gap-6 lg:gap-8 animate-pulse">
      <div className="hidden lg:flex gap-6">
        <div className="space-y-2">
          <div className="w-28 product-image-ratio rounded bg-gray-200" />
          <div className="w-28 product-image-ratio rounded bg-gray-200" />
          <div className="w-28 product-image-ratio rounded bg-gray-200" />
        </div>

        <div className="flex-1 product-image-ratio bg-gray-200" />
      </div>

      <div className="lg:hidden space-y-3">
        <div className="max-w-sm w-full mx-auto product-image-ratio bg-gray-200" />
        <div className="h-5 w-24 mx-auto bg-gray-200" />
      </div>

      <div className="relative space-y-5">
        <div className="h-14 bg-gray-200" />
        <div className="h-5 w-9/12 bg-gray-200" />
        <div className="h-5 w-4/12 bg-gray-200" />
        <div className="h-5 w-8/12 bg-gray-200" />
        <div className="h-22 bg-gray-200" />
        <div className="h-10 w-10/12 mx-auto bg-gray-200" />
        <div className="h-26 bg-gray-200" />
      </div>
    </div>
  );
};

export default ProductViewSkeleton;
