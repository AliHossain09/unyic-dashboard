import Button from "../../../../../../../components/ui/Button";
import useClearFilters from "../../../../../../../hooks/useClearFilters";

interface FilterDrawerFooterProps {
  closeDrawer: () => void;
}

const FilterDrawerFooter = ({ closeDrawer }: FilterDrawerFooterProps) => {
  const clearFilters = useClearFilters();

  const handleClearFilters = () => {
    clearFilters();
    closeDrawer();
  };

  return (
    <div className="h-17 py-3 px-4 border-y bg-light flex gap-4 text-base">
      <Button variant="primary-outline" onClick={handleClearFilters}>
        Clear All Filters
      </Button>

      <Button variant="primary" onClick={closeDrawer}>
        View Results
      </Button>
    </div>
  );
};

export default FilterDrawerFooter;
