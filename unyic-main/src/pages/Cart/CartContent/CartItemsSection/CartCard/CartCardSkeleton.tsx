const CartCardSkeleton = () => {
  return (
    <div className="h-55 p-3 sm:p-4 bg-light flex gap-4">
      <div className="h-full product-image-ratio bg-gray-200 animate-pulse" />

      <div className="flex-1 space-y-3 animate-pulse">
        <div className="h-4 w-20 rounded bg-gray-200" />
        <div className="h-4 w-11/12 rounded bg-gray-200" />
        <div className="h-4 w-9/12 rounded bg-gray-200" />
        <div className="h-4 w-25 rounded bg-gray-200" />
      </div>
    </div>
  );
};

export default CartCardSkeleton;
