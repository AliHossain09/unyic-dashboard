import type { Filters } from "../../../types/productsFilter";
import ProductFilters from "./ProductFilters";
import ProductsSection from "./ProductsSection";
import ProductsWithFiltersContainer from "./ProductsWithFiltersContainer";

interface ProductsWithFiltersProps {
  queryString: string;
  filters: Filters | undefined;
  isFiltersLoading: boolean;
}

const ProductsWithFilters = ({
  filters,
  isFiltersLoading,
  queryString,
}: ProductsWithFiltersProps) => {
  return (
    <ProductsWithFiltersContainer>
      <ProductFilters filters={filters} isFiltersLoading={isFiltersLoading} />
      <ProductsSection queryString={queryString} />
    </ProductsWithFiltersContainer>
  );
};

export default ProductsWithFilters;
