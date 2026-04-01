import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Filters } from "../../../types/productsFilter";
import type { Product } from "../../../types";

export type PaginatedProductsResponse = {
  products: Product[];
  nextCursor: string | null;
  total: number;
  limit: number;
};

export const productsApi = createApi({
  reducerPath: "productsApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getProductsFilters: builder.query<Filters, string>({
      query: (queryString) => `frontend/products/filters?${queryString}`,
    }),
    getPaginatedProducts: builder.query<PaginatedProductsResponse, string>({
      query: (queryString) => {
        const params = new URLSearchParams(queryString);

        if (!params.has("pagination")) {
          params.set("pagination", "cursor");
        }

        if (!params.has("limit")) {
          params.set("limit", "20");
        }

        return `frontend/products?${params.toString()}`;
      },
    }),
  }),
});

export const { useLazyGetProductsFiltersQuery, useLazyGetPaginatedProductsQuery } =
  productsApi;
