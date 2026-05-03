import { useSearchParams } from "react-router";
import FilterOption from "./FilterOption";
import type { FilterOptionType } from "../../../../../../types/productsFilter";

interface GroupFilterProps {
  paramKey: string;
  options: FilterOptionType[];
}

const GroupFilter = ({ paramKey, options }: GroupFilterProps) => {
  const [searchParams, setSearchParams] = useSearchParams();

  const isApplied = (value: string) =>
    searchParams.getAll(paramKey).includes(value);

  const toggleFilter = (value: string) => {
    setSearchParams((params) => {
      const current = params.getAll(paramKey);

      const updated = current.includes(value)
        ? current.filter((v) => v !== value)
        : [...current, value];

      params.delete(paramKey);
      updated.forEach((v) => params.append(paramKey, v));

      return params;
    });
  };

  return (
    <ul className="space-y-3">
      {options.map((opt) => (
        <FilterOption
          key={opt.label}
          option={opt}
          isApplied={isApplied(opt.label)}
          onClick={() => toggleFilter(opt.label)}
        />
      ))}
    </ul>
  );
};

export default GroupFilter;
