import { useState } from "react";
import { VscSettings } from "react-icons/vsc";
import FilterDrawer from "./FilterDrawer";
import type { Filters } from "../../../../../../types/productsFilter";
import { useSearchParams } from "react-router";
import { hasActiveProductFilters } from "../../../../../../utlis/product";

interface FilterButtonProps {
  filters: Filters;
}

const FilterButton = ({ filters }: FilterButtonProps) => {
  const [isFilterDrawerOpen, setIsFilterDrawerOpen] = useState(false);
  const [searchParams] = useSearchParams();

  return (
    <>
      <button
        onClick={() => setIsFilterDrawerOpen(true)}
        className="size-full flex items-center justify-center gap-2"
      >
        {hasActiveProductFilters(searchParams) && (
          <div className="size-1.5 rounded-full bg-primary" />
        )}

        <VscSettings size={24} />
        <span className="uppercase">Filters</span>
      </button>

      <FilterDrawer
        isOpen={isFilterDrawerOpen}
        closeDrawer={() => setIsFilterDrawerOpen(false)}
        filters={filters}
      />
    </>
  );
};

export default FilterButton;
