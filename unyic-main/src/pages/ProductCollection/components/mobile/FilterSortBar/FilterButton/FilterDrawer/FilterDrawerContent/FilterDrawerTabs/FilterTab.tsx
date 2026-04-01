import clsx from "clsx";
import type { FilterKey } from "../../../../../../../../../types/productsFilter";

interface FilterTabProps {
  label: FilterKey;
  isActive: boolean;
  onClick: () => void;
  count?: number; // For brand, color, size
  showActiveDot?: boolean;
}

const FilterTab = ({
  label,
  isActive,
  onClick,
  count,
  showActiveDot = false,
}: FilterTabProps) => {
  return (
    <li>
      <button
        onClick={onClick}
        className={clsx(
          "w-full p-4 font-semibold capitalize text-left text-base flex justify-between items-center",
          isActive && "bg-neutral-100",
        )}
      >
        {label}

        {count !== undefined && count > 0 && (
          <span className="flex-none size-4 rounded-full grid place-items-center bg-primary text-light text-xs font-normal">
            {count}
          </span>
        )}

        {showActiveDot && (
          <span className="flex-none size-2 rounded-full bg-primary" />
        )}
      </button>
    </li>
  );
};

export default FilterTab;
