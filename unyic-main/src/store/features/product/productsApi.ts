import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Filters } from "../../../types/productsFilter";
import type { Product } from "../../../types/product";

type ProductsResponse = {
  products: Product[];
  nextCursor: string | null;
  total: number;
  limit: number;
};

type ProductsQueryArg = {
  queryString: string;
  limit: number;
};

export const productsApi = createApi({
  reducerPath: "productsApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getProductsFilters: builder.query<Filters, string>({
      query: (queryString) => `frontend/products/filters?${queryString}`,
    }),

    getProducts: builder.infiniteQuery<
      ProductsResponse,
      ProductsQueryArg,
      string | null
    >({
      query: ({ pageParam, queryArg }) => {
        const cursor = pageParam ? `&cursor=${pageParam}` : "";
        return `frontend/products?${queryArg.queryString}&limit=${queryArg.limit}${cursor}`;
      },

      infiniteQueryOptions: {
        initialPageParam: null,
        getNextPageParam: (lastPage) => lastPage.nextCursor ?? undefined,
      },
    }),

    getMostViewedProducts: builder.query<Product[], void>({
      query: () => `frontend/products/most-viewed`,
    }),

    getTopPicksProducts: builder.query<Product[], void>({
      query: () => `frontend/products/top-picks`,
    }),

    getSimilarProducts: builder.query<
      Product[],
      { productSlug: string | undefined }
    >({
      query: ({ productSlug }) => `frontend/products/${productSlug}/similar`,
    }),
  }),
});

export const {
  useGetProductsFiltersQuery,
  useGetProductsInfiniteQuery,
  useGetMostViewedProductsQuery,
  useGetTopPicksProductsQuery,
  useGetSimilarProductsQuery,
} = productsApi;
