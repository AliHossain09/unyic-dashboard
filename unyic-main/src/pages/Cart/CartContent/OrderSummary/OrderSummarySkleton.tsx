const OrderSummarySkeleton = () => {
  return (
    <div className="h-max p-3 bg-light">
      <div className="h-35 space-y-4 animate-pulse">
        {/* Header */}
        <div className="flex justify-between">
          <div className="h-5 w-28 bg-gray-200 rounded" />
          <div className="h-4 w-12 bg-gray-200 rounded" />
        </div>
        {/* Order Value */}
        <div className="flex items-center justify-between">
          <div className="h-4 w-20 bg-gray-200 rounded" />
          <div className="h-4 w-16 bg-gray-200 rounded" />
        </div>
        {/* Shipping Charges */}
        <div className="flex items-center justify-between">
          <div className="h-4 w-24 bg-gray-200 rounded" />
          <div className="h-4 w-10 bg-gray-200 rounded" />
        </div>
        <hr />
        {/* Grand Total */}
        <div className="flex items-center justify-between">
          <div className="h-5 w-24 bg-gray-200 rounded" />
          <div className="h-5 w-20 bg-gray-200 rounded" />
        </div>
      </div>

      {/* Button Skeleton (visible only on larger screens) */}
      <div className="hidden sm:block h-10.5 mt-4 bg-gray-200 rounded-md animate-pulse" />
    </div>
  );
};

export default OrderSummarySkeleton;
