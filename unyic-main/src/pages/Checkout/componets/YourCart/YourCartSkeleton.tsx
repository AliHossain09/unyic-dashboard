const YourCartSkeleton = () => {
  return (
    <div className="h-max p-4 py-6 md:p-6 bg-light">
      <div className="mb-4 flex items-center justify-between">
        <div className="h-7 w-38 rounded bg-gray-200 animate-pulse" />
        <div className="h-6 w-14 rounded bg-gray-200 animate-pulse" />
      </div>

      <div className="divide-y">
        {[...Array(3)].map((_, index) => (
          <div key={index} className="py-4 flex gap-4 animate-pulse">
            <div className="w-20 product-image-ratio rounded-md bg-gray-200" />
            <div className="rounded-md bg-gray-200" />
          </div>
        ))}
      </div>
    </div>
  );
};

export default YourCartSkeleton;
