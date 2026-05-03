import clsx from "clsx";
import type { SortOption } from "../../../../../../../types/productsFilter";
import { HiOutlineXMark } from "react-icons/hi2";
import { SORT_OPTIONS } from "../../../../../../../constants/sortOptions";

interface SortPopupProps {
  isOpen: boolean;
  closePopup: () => void;
  selectedSort: SortOption;
  setSortByLabel: (label: string) => void;
}

const SortPopUp = ({
  isOpen,
  closePopup,
  selectedSort,
  setSortByLabel,
}: SortPopupProps) => {
  return (
    <div
      role="dialog"
      className={clsx(
        "fixed z-40 inset-0",
        isOpen ? "pointer-events-auto" : "pointer-events-none"
      )}
    >
      {/* Background overlay */}
      <div
        onClick={closePopup}
        className={clsx(
          "absolute inset-0 bg-black transition-opacity duration-300",
          isOpen ? "opacity-40" : "opacity-0"
        )}
      />

      {/* Main Popup */}
      <div
        className={clsx(
          "absolute bottom-0 inset-x-0 rounded-t-xl shadow-lg bg-light",
          isOpen ? "translate-y-0" : "translate-y-full opacity-0",
          "duration-300 ease-in"
        )}
      >
        {/* Header */}
        <div className="h-16 px-4 border-b flex items-center justify-between">
          <h4 id="sort-popup-title" className="font-semibold text-base">
            Sort By
          </h4>
          <button
            onClick={closePopup}
            aria-label="Close sort popup"
            className="p-1"
          >
            <HiOutlineXMark size={23} />
          </button>
        </div>

        {/* Sort options list */}
        <ul className="px-4 py-3">
          {SORT_OPTIONS.map((sortOption) => (
            <li key={sortOption.value}>
              <button
                onClick={() => {
                  setSortByLabel(sortOption.label);
                  closePopup();
                }}
                className={clsx(
                  "w-full py-2 px-3 text-left text-sm rounded",
                  selectedSort.value === sortOption.value &&
                    "font-semibold bg-primary/15"
                )}
              >
                {sortOption.label}
              </button>
            </li>
          ))}
        </ul>
      </div>
    </div>
  );
};

export default SortPopUp;
