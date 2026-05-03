import { useState } from "react";
import SortPopUp from "./SortPopUp";
import { PiSortAscending } from "react-icons/pi";
import { useSort } from "../../../../../../hooks/useSort";
import { useSearchParams } from "react-router";

const SortButton = () => {
  const [isSortPopupOpen, setIsSortPopupOpen] = useState(false);
  const { selectedSort, setSortByLabel } = useSort();
  const [searchParams] = useSearchParams();

  return (
    <>
      <button
        onClick={() => setIsSortPopupOpen(true)}
        className="size-full flex items-center justify-center gap-2"
      >
        {searchParams.has("sort") && (
          <div className="size-1.5 rounded-full bg-primary" />
        )}

        <PiSortAscending size={30} />

        <span className="grid text-left">
          <span className="uppercase">Sort By</span>
          <span className="-mt-0.5 text-[10px] text-dark-light">
            {selectedSort.label}
          </span>
        </span>
      </button>

      <SortPopUp
        isOpen={isSortPopupOpen}
        closePopup={() => setIsSortPopupOpen(false)}
        selectedSort={selectedSort}
        setSortByLabel={setSortByLabel}
      />
    </>
  );
};

export default SortButton;
