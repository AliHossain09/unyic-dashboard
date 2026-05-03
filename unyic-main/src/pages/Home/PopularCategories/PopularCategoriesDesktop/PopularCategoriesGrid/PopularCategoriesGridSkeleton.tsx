import { aspectRatios, getImageWrapperClasses } from "./helpers";

const PopularCategoriesGridSkeleton = () => {
  // Split 8 items into 4 columns of 2 items each
  const columns = [0, 1, 2, 3].map((colIndex) => [
    aspectRatios[colIndex * 2],
    aspectRatios[colIndex * 2 + 1],
  ]);

  return (
    <div className="grid grid-cols-4 gap-6 animate-pulse">
      {columns.map((col, colIndex) => (
        <div key={colIndex} className="space-y-6">
          {col.map((_, itemIndex) => {
            return (
              <div key={itemIndex} className="space-y-2">
                {/* Image placeholder */}
                <div className={getImageWrapperClasses(colIndex, itemIndex)} />

                {/* Caption placeholder */}
                <div className="h-6 grid place-items-center">
                  <div className="h-4 w-5/8 rounded-lg bg-gray-200" />
                </div>
              </div>
            );
          })}
        </div>
      ))}
    </div>
  );
};

export default PopularCategoriesGridSkeleton;
