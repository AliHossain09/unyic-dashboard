import useClearFilters from "../../../../../hooks/useClearFilters";

const FilterHeader = () => {
  const clearFilters = useClearFilters();

  return (
    <div className="py-3 flex items-center justify-between gap-2">
      <h3 className="uppercase font-bold">Filter by</h3>

      <button
        onClick={clearFilters}
        className="text-sm font-medium underline underline-offset-2"
      >
        Clear All
      </button>
    </div>
  );
};

export default FilterHeader;
