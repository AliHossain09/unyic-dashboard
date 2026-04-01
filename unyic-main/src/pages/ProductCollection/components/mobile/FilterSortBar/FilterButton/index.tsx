import { useState } from "react";
import { VscSettings } from "react-icons/vsc";
import FilterDrawer from "./FilterDrawer";
import type { Filters } from "../../../../../../types/productsFilter";
import { useSearchParams } from "react-router";
import { FILTER_KEYS } from "../../../../../../constants/filterKeys";

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
        {FILTER_KEYS.some((key) => searchParams.has(key)) && (
          <div className="size-[6px] rounded-full bg-primary" />
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
