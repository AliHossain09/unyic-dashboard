import { Link } from "react-router";
import { getImageWrapperClasses } from "./helpers";
import { useGetPopularCatgoriesQuery } from "../../../../../store/features/category/popularCatgoriesApi";
import PopularCategoriesGridSkeleton from "./PopularCategoriesGridSkeleton";

const PopularCategoriesGrid = () => {
  const {
    data: popularCategories = [],
    isLoading,
    error,
  } = useGetPopularCatgoriesQuery();

  if (isLoading) {
    return <PopularCategoriesGridSkeleton />;
  }

  if (error) {
    console.error("Error fetching popular categories:", error);
    return <p className="text-center text-sm">Failed to load popular categories</p>;
  }

  if (popularCategories.length === 0) {
    return <p className="text-center text-sm">No popular categories found</p>;
  }

  // Split 8 items into 4 columns of 2 items each
  const columns = [0, 1, 2, 3].map((colIndex) => [
    popularCategories[colIndex * 2],
    popularCategories[colIndex * 2 + 1],
  ]);

  return (
    <div className="grid grid-cols-4 gap-6">
      {columns.map((col, colIndex) => (
        <div key={colIndex} className="space-y-6">
          {col.map((item, itemIndex) => {
            const { id, title, link, images } = item || {};

            return (
              <Link key={id} to={`${link}`} className="space-y-2 block">
                {/* Image with aspect ratio */}
                <div className={getImageWrapperClasses(colIndex, itemIndex)}>
                  <img
                    src={images?.desktop}
                    alt={title}
                    className="size-full object-cover"
                  />
                </div>

                {/* Caption */}
                <div className="h-6 grid place-items-center">
                  <p className="text-sm uppercase font-semibold">{title}</p>
                </div>
              </Link>
            );
          })}
        </div>
      ))}
    </div>
  );
};

export default PopularCategoriesGrid;
