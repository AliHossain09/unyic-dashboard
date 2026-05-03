import { MdCheckBox, MdCheckBoxOutlineBlank } from "react-icons/md";
import type { FilterOptionType } from "../../../../../../types/productsFilter";

interface FilterOptionProps {
  option: FilterOptionType;
  isApplied: boolean;
  onClick: () => void;
}

const FilterOption = ({ option, isApplied, onClick }: FilterOptionProps) => {
  const { label, count } = option || {};

  return (
    <li>
      <button
        onClick={onClick}
        className="w-full flex justify-between items-center gap-3"
      >
        <span className="min-w-0 flex items-center gap-2">
          {isApplied ? (
            <MdCheckBox size={24} className="flex-none text-primary" />
          ) : (
            <MdCheckBoxOutlineBlank
              size={24}
              className="flex-none text-primary-light"
            />
          )}

          <span className="text-sm truncate">{label}</span>
        </span>

        <span className="text-xs text-dark-light">({count})</span>
      </button>
    </li>
  );
};

export default FilterOption;
