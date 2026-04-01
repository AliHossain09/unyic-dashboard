import { SORT_OPTIONS } from "../../../../constants/sortOptions";
import DropdownSelector from "../../../../components/ui/DropdownSelector";
import { useSort } from "../../../../hooks/useSort";
import useClearFilters from "../../../../hooks/useClearFilters";

const FilterSortHeader = () => {
  const { selectedSort, setSortByLabel } = useSort();
  const clearFilters = useClearFilters();

  return (
    <div className="py-2 grid grid-cols-[1fr_3fr] gap-8 items-center sticky z-10 top-[122px] bg-light">
      <div className="flex items-center justify-between gap-2">
        <h3 className="uppercase font-bold text-lg">Filter by</h3>

        <button
          onClick={clearFilters}
          className="font-medium underline underline-offset-2"
        >
          Clear All
        </button>
      </div>

      <div className="flex items-center justify-end gap-2">
        <h4 className="uppercase text-nowrap font-semibold">Sort By</h4>

        <div className="ms-1 w-60">
          <DropdownSelector
            selected={selectedSort.label}
            list={SORT_OPTIONS.map((option) => option.label)}
            onSelect={setSortByLabel}
            defaultText="Sort by"
          />
        </div>
      </div>
    </div>
  );
};

export default FilterSortHeader;
