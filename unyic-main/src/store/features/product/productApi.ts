import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Product } from "../../../types/product";

export const productApi = createApi({
  reducerPath: "productApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getProductBySlug: builder.query<Product, string | undefined>({
      query: (slug) => `products/${slug}`,
    }),
  }),
});

export const { useGetProductBySlugQuery } = productApi;
