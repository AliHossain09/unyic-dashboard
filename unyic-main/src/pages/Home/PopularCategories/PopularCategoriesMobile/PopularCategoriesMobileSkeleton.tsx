import PopularCategoriesMobileContainer from "./PopularCategoriesMobileContainer";
import PopularCategoryMobileSkeleton from "./PopularCategoryMobile/PopularCategoryMobileSkeleton";

const PopularCategoriesMobileSkeleton = () => {
  return (
    <PopularCategoriesMobileContainer>
      {[...Array(8)].map((_, index) => (
        <PopularCategoryMobileSkeleton key={index} />
      ))}
    </PopularCategoriesMobileContainer>
  );
};

export default PopularCategoriesMobileSkeleton;
