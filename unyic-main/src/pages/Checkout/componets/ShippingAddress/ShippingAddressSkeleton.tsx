const ShippingAddressSkeleton = () => {
  return (
    <div className="h-max p-4 py-6 md:p-6 bg-light">
      <div className="mb-4 flex items-center justify-between">
        <div className="h-7 w-38 rounded bg-gray-200 animate-pulse" />
        <div className="h-6 w-14 rounded bg-gray-200 animate-pulse" />
      </div>

      <div className="h-48 rounded bg-gray-200 animate-pulse" />
    </div>
  );
};

export default ShippingAddressSkeleton;
