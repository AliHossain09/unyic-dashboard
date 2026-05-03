import { useSearchParams } from "react-router";
import { SORT_OPTIONS } from "../constants/sortOptions";

export const useSort = () => {
  const [searchParams, setSearchParams] = useSearchParams();

  // Get selected sort from URL or default
  const selectedSort =
    SORT_OPTIONS.find((opt) => opt.value === searchParams.get("sort")) ||
    SORT_OPTIONS[0];

  // Update URL when user selects a sort
  const setSortByLabel = (label: string) => {
    const option = SORT_OPTIONS.find((opt) => opt.label === label);
    if (!option) return;

    setSearchParams((params) => {
      params.set("sort", option.value);
      return params;
    });
  };

  return { selectedSort, setSortByLabel };
};
