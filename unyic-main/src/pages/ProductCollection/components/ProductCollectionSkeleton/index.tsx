const ProductCollectionSkeleton = () => {
  return (
    <div className="ui-container mt-2 lg:mt-6 mb-12">
      <div className="grid grid-cols-[1fr_3fr] gap-8">
        <div className="h-74.5 bg-gray-200 animate-pulse" />

        <div className="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-2 sm:gap-x-4 gap-y-8">
          {[...Array(8)].map((_, index) => (
            <div key={index} className="bg-gray-200 animate-pulse rounded-lg h-74.5" />
          ))}
        </div>
      </div>
    </div>
  );
};

export default ProductCollectionSkeleton;
