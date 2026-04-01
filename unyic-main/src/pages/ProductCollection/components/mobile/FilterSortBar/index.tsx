import type { Filters } from "../../../../../types/productsFilter";
import FilterButton from "./FilterButton";
import SortButton from "./SortButton";

interface FilterSortBarProps {
  filters: Filters;
}

const FilterSortBar = ({ filters }: FilterSortBarProps) => {
  return (
    <div className="w-full h-12 py-1 fixed z-40 left-0 bottom-0 bg-light text-sm grid grid-cols-2 divide-x divide-dark">
      <SortButton />
      <FilterButton filters={filters} />
    </div>
  );
};

export default FilterSortBar;
