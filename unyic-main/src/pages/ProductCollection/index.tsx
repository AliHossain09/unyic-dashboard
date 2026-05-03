import { useLoaderData, useParams, useSearchParams } from "react-router";
import { useGetProductsFiltersQuery } from "../../store/features/product/productsApi";
import NoCollectionProductFound from "./components/NoCollectionProductFound";
import ProductsWithFiltersSkeleton from "../../components/ui/ProductsWithFilters/ProductsWithFiltersSkeleton";
import ProductsWithFilters from "../../components/ui/ProductsWithFilters";
import {
  buildProductsQueryString,
  hasActiveProductFilters,
} from "../../utlis/product";

const ProductCollection = () => {
  const { collectionType } = useLoaderData();
  const { slug } = useParams();
  const [searchParams] = useSearchParams();

  const queryString = buildProductsQueryString({
    searchParams,
    collectionType,
    slug,
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
    return <NoCollectionProductFound />;
  }

  return (
    <ProductsWithFilters
      queryString={queryString}
      filters={filters}
      isFiltersLoading={isFiltersLoading}
    />
  );
};

export default ProductCollection;
