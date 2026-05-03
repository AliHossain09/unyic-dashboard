import RangeBox from "./RangeBox";

interface RangeDisplayProps {
  range: [number, number];
  unit: string;
}

const RangeDisplay = ({
  range: [minRange, maxRange],
  unit,
}: RangeDisplayProps) => {
  return (
    <div className="h-9 grid grid-cols-[1fr_auto_1fr] items-center gap-2 text-sm">
      <RangeBox unit={unit} value={minRange} />
      <span>-</span>
      <RangeBox unit={unit} value={maxRange} />
    </div>
  );
};

export default RangeDisplay;
