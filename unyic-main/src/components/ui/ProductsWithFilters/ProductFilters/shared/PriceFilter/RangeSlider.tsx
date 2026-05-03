import clsx from "clsx";
import React from "react";

interface RangeSliderProps {
  range: [number, number];
  defaultRange: [number, number];
  onRangeChange: (newRange: [number, number]) => void;
}

const RangeSlider = ({
  range: [min, max],
  defaultRange: [defaultMin, defaultMax],
  onRangeChange,
}: RangeSliderProps) => {
  const handleMinChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const newMin = Math.min(Number(e.target.value), max);
    onRangeChange([newMin, max]);
  };

  const handleMaxChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const newMax = Math.max(Number(e.target.value), min);
    onRangeChange([min, newMax]);
  };

  // Compute progress bar
  const getProgress = () => {
    const range = defaultMax - defaultMin;

    if (range === 0) {
      return { progressLeft: 0, progressWidth: 100 };
    }

    return {
      progressLeft: ((min - defaultMin) / range) * 100,
      progressWidth: ((max - min) / range) * 100,
    };
  };

  const { progressLeft, progressWidth } = getProgress();

  return (
    <div className="h-5 me-1 relative">
      {/* Track */}
      <div className="h-1 w-full rounded-full bg-gray-200 absolute top-1/2 -translate-y-1/2" />

      {/* Progress */}
      <div
        className="h-1 rounded-full bg-primary absolute top-1/2 -translate-y-1/2"
        style={{
          left: `${progressLeft}%`,
          width: `${progressWidth}%`,
        }}
      />

      {/* Min Slider */}
      <input
        type="range"
        min={defaultMin}
        max={defaultMax}
        value={min}
        onChange={handleMinChange}
        className={clsx("rangeSlider", defaultMax - min <= 1 && "z-10")} // Ensure min thumb stays selectable when both thumbs meet at the end
      />

      {/* Max Slider */}
      <input
        type="range"
        min={defaultMin}
        max={defaultMax}
        value={max}
        onChange={handleMaxChange}
        className={clsx(
          "rangeSlider",
          defaultMin === defaultMax && "scale-x-[-1]", // Show max thumb in opposite direction in case of zero range
        )}
      />
    </div>
  );
};

export default RangeSlider;
