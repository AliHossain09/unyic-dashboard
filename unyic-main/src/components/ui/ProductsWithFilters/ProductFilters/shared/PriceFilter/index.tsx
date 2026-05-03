import { useMemo, useState } from "react";
import RangeDisplay from "./RangeDisplay";
import RangeSlider from "./RangeSlider";
import { useSearchParams } from "react-router";
import { sanitizeRange } from "../../../../../../utlis/range";
import type { PriceFilterType } from "../../../../../../types/productsFilter";

interface PriceFilterProps {
  priceFilter: PriceFilterType;
}

const PriceFilter = ({ priceFilter }: PriceFilterProps) => {
  const [searchParams, setSearchParams] = useSearchParams();

  const defaultRange = useMemo(
    () => [priceFilter.min ?? 0, priceFilter.max ?? 0] as [number, number],
    [priceFilter.min, priceFilter.max],
  );

  const committedRange = useMemo(
    () => sanitizeRange(searchParams.get("price"), defaultRange),
    [defaultRange, searchParams],
  );

  const [currentRange, setCurrentRange] =
    useState<[number, number]>(committedRange);

  const handleClear = () => {
    setCurrentRange(defaultRange);

    setSearchParams((prev) => {
      prev.delete("price");
      return prev;
    });
  };

  const handleApply = () => {
    const [min, max] = currentRange;
    const [defaultMin, defaultMax] = defaultRange;

    setSearchParams((prev) => {
      if (min === defaultMin && max === defaultMax) {
        prev.delete("price");
        return prev;
      }

      prev.set("price", `${min}-${max}`);
      return prev;
    });
  };

  return (
    <div className="space-y-4">
      <div className="flex justify-between items-center gap-3">
        <p>Choose a price range</p>

        <button onClick={handleClear} className="underline underline-offset-3">
          Clear
        </button>
      </div>

      <div className="h-9 grid grid-cols-[1fr_auto] items-center gap-2 text-sm">
        <RangeDisplay range={currentRange} unit={"₹"} />

        <button
          onClick={handleApply}
          className="h-full px-2 flex items-center rounded bg-primary-dark text-light uppercase"
        >
          Apply
        </button>
      </div>

      <RangeSlider
        range={currentRange}
        defaultRange={defaultRange}
        onRangeChange={setCurrentRange}
      />
    </div>
  );
};

export default PriceFilter;
