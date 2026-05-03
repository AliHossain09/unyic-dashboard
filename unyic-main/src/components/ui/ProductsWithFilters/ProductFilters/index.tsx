import useScreenSize from "../../../../hooks/useScreenSize";
import type { Filters } from "../../../../types/productsFilter";
import FilterSortBarMobile from "./FilterSortBarMobile";
import ProductFiltersDesktop from "./ProductFiltersDesktop";
import ProductFiltersSkeleton from "./ProductFiltersSkeleton";

interface ProductFiltersProps {
  filters: Filters | undefined;
  isFiltersLoading: boolean;
}

const ProductFilters = ({ filters, isFiltersLoading }: ProductFiltersProps) => {
  const { isDesktopScreen } = useScreenSize();

  if (isFiltersLoading) {
    return <ProductFiltersSkeleton />;
  }

  if (!filters) {
    return null;
  }

  return (
    <div className="min-w-0 h-max lg:pt-6 lg:sticky lg:top-30.5">
      <p className="lg:mb-2 text-dark-light">
        Total {filters.totalProductsCount} products
      </p>

      {isDesktopScreen ? (
        <ProductFiltersDesktop filters={filters} />
      ) : (
        <FilterSortBarMobile filters={filters} />
      )}
    </div>
  );
};

export default ProductFilters;
