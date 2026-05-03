const PopularCategoryMobileSkeleton = () => {
  return (
    <div className="flex-none w-23 pe-3 animate-pulse">
      <div className="w-full aspect-square rounded-full bg-gray-200" />

      <div className="h-8 mt-2 text-center space-y-1">
        <p className="w-11/12 h-3 mx-auto rounded-md bg-gray-200" />
        <p className="w-8/12 h-3 mx-auto rounded-md bg-gray-200" />
      </div>
    </div>
  );
};

export default PopularCategoryMobileSkeleton;
