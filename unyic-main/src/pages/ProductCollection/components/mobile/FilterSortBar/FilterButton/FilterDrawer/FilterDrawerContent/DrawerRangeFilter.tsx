import RangeDisplay from "../../../../../shared/PriceFilter/RangeDisplay";
import RangeSlider from "../../../../../shared/PriceFilter/RangeSlider";

interface DrawerRangeFilterProps {
  range: [number, number];
  defaultRange: [number, number];
  unit: string;
  onRangeChange: (newRange: [number, number]) => void;
}

const DrawerRangeFilter = ({
  range,
  defaultRange,
  onRangeChange,
  unit,
}: DrawerRangeFilterProps) => {
  return (
    <div className="space-y-3">
      <RangeDisplay range={range} unit={unit} />

      <RangeSlider
        range={range}
        defaultRange={defaultRange}
        onRangeChange={onRangeChange}
      />
    </div>
  );
};

export default DrawerRangeFilter;
