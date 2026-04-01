import { useSearchParams } from "react-router";

const useClearFilters = () => {
  const [, setSearchParams] = useSearchParams();

  return () => {
    setSearchParams((currentParams) => {
      const newParams = new URLSearchParams();

      const sort = currentParams.get("sort");
      if (sort) newParams.set("sort", sort);

      return newParams;
    });
  };
};

export default useClearFilters;
