import clsx from "clsx";
import type { Filters } from "../../../../../../../types/productsFilter";
import FilterDrawerHeader from "./FilterDrawerHeader";
import FilterDrawerFooter from "./FilterDrawerFooter";
import FilterDrawerContent from "./FilterDrawerContent";

interface FilterDrawerProps {
  isOpen: boolean;
  closeDrawer: () => void;
  filters: Filters;
}

const FilterDrawer = ({ isOpen, closeDrawer, filters }: FilterDrawerProps) => {
  return (
    <div
      className={clsx(
        "fixed z-50 inset-0 bg-light transition-transform duration-700",
        isOpen ? "translate-x-0" : "-translate-x-full",
      )}
    >
      {/* Drawer Header */}
      <FilterDrawerHeader closeDrawer={closeDrawer} />

      <FilterDrawerContent filters={filters} />

      {/* Footer with actions */}
      <FilterDrawerFooter closeDrawer={closeDrawer} />
    </div>
  );
};

export default FilterDrawer;
