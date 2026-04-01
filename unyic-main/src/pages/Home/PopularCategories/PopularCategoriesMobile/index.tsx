import { useGetPopularCatgoriesQuery } from "../../../../store/features/category/popularCatgoriesApi";
import { popularCategories as popularCategoriesData } from "../../../../data/popularCategories";
import PopularCategoriesMobileContainer from "./PopularCategoriesMobileContainer";
import PopularCategoriesMobileSkeleton from "./PopularCategoriesMobileSkeleton";
import PopularCategoryMobile from "./PopularCategoryMobile";

const PopularCategoriesMobile = () => {
  const { data, isLoading, error } = useGetPopularCatgoriesQuery();
  const popularCategories = data || popularCategoriesData;

  if (isLoading) {
    return <PopularCategoriesMobileSkeleton />;
  }

  if (error) {
    console.error("Error fetching popular categories:", error);
    // return null;
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
