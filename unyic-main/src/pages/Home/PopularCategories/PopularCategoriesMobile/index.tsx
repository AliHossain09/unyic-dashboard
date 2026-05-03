import { useGetPopularCatgoriesQuery } from "../../../../store/features/category/categoriesApi";
import PopularCategoriesMobileContainer from "./PopularCategoriesMobileContainer";
import PopularCategoriesMobileSkeleton from "./PopularCategoriesMobileSkeleton";
import PopularCategoryMobile from "./PopularCategoryMobile";

const PopularCategoriesMobile = () => {
  const {
    data: popularCategories = [],
    isLoading,
    error,
  } = useGetPopularCatgoriesQuery();

  if (isLoading) {
    return <PopularCategoriesMobileSkeleton />;
  }

  if (error) {
    console.error("Error fetching popular categories:", error);
  }

  if (popularCategories.length === 0) {
    return null;
  }

  return (
    <PopularCategoriesMobileContainer>
      {popularCategories.map((category) => (
        <PopularCategoryMobile key={category.id} category={category} />
      ))}
    </PopularCategoriesMobileContainer>
  );
};

export default PopularCategoriesMobile;
