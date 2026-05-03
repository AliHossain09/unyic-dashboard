import { useSearchParams } from "react-router";
import {
  buildProductsQueryString,
  hasActiveProductFilters,
} from "../../utlis/product";
import { useGetProductsFiltersQuery } from "../../store/features/product/productsApi";
import ProductsWithFiltersSkeleton from "../../components/ui/ProductsWithFilters/ProductsWithFiltersSkeleton";
import ProductsWithFilters from "../../components/ui/ProductsWithFilters";
import NoSearchResultFound from "./components/NoSearchResultFound";

const Search = () => {
  const [searchParams] = useSearchParams();
  const searchQuery = searchParams.get("search_query") || "";

  const queryString = buildProductsQueryString({
    searchParams,
    searchQuery,
  });

  const {
    data: filters,
    isLoading,
    isFetching,
    isUninitialized,
    isError,
  } = useGetProductsFiltersQuery(queryString);

  const isFiltersLoading = isUninitialized || isLoading || isFetching;
  if (isFiltersLoading) {
    return <ProductsWithFiltersSkeleton />;
  }

  if (isError) {
    throw new Response("Not Found", { status: 404 });
  }

  if (
    filters?.totalProductsCount === 0 &&
    !hasActiveProductFilters(searchParams)
  ) {
    return <NoSearchResultFound searchQuery={searchQuery} />;
  }

  return (
    <ProductsWithFilters
      queryString={queryString}
      filters={filters}
      isFiltersLoading={isFiltersLoading}
    />
  );
};

export default Search;
