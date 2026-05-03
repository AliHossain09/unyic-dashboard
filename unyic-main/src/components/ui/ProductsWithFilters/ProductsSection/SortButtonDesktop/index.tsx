import DropdownSelector from "../../../../../components/ui/DropdownSelector";
import { SORT_OPTIONS } from "../../../../../constants/sortOptions";
import { useSort } from "../../../../../hooks/useSort";

const SortButtonDesktop = () => {
  const { selectedSort, setSortByLabel } = useSort();

  return (
    <div className="pt-6 pb-2 sticky top-30.5 z-10 bg-light flex items-center justify-end gap-2">
      <h4 className="text-sm uppercase text-nowrap font-semibold">Sort By</h4>

      <div className="ms-1 w-60">
        <DropdownSelector
          selected={selectedSort.label}
          list={SORT_OPTIONS.map((option) => option.label)}
          onSelect={setSortByLabel}
          defaultText="Sort by"
        />
      </div>
    </div>
  );
};

export default SortButtonDesktop;
