import ProductFiltersSkeleton from "./ProductFilters/ProductFiltersSkeleton";
import ProductsSectionSkeleton from "./ProductsSection/ProductsSectionSkeleton";
import ProductsWithFiltersContainer from "./ProductsWithFiltersContainer";

const ProductsWithFiltersSkeleton = () => {
  return (
    <ProductsWithFiltersContainer>
      <ProductFiltersSkeleton />
      <ProductsSectionSkeleton />
    </ProductsWithFiltersContainer>
  );
};

export default ProductsWithFiltersSkeleton;
