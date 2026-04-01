import { HiOutlineXMark } from "react-icons/hi2";

interface FilterDrawerHeaderProps {
  closeDrawer: () => void;
}

const FilterDrawerHeader = ({ closeDrawer }: FilterDrawerHeaderProps) => {
  return (
    <div className="h-16 px-4 border-b flex items-center justify-between">
      <h4 className="font-semibold text-base">Filter</h4>
      <button
        onClick={closeDrawer}
        aria-label="Close filter drawer"
        className="p-1"
      >
        <HiOutlineXMark size={23} />
      </button>
    </div>
  );
};

export default FilterDrawerHeader;
