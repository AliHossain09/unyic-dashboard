interface RangeBoxProps {
  value: number;
  unit: string;
}

const RangeBox = ({ value, unit }: RangeBoxProps) => {
  return (
    <div className="size-full px-2 flex items-center gap-1 bg-dark-light/15 border border-dark-light/50">
      {unit}

      <input
        type="text"
        value={value}
        readOnly
        className="w-full outline-none overflow-x-auto whitespace-nowrap"
      />
    </div>
  );
};

export default RangeBox;
