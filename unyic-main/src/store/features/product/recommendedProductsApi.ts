import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Product } from "../../../types";

export const recommendedProductsApi = createApi({
  reducerPath: "recommendedProductsApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getRecommendedProducts: builder.query<Product[], void>({
      query: () => "products",
    }),
  }),
});

export const { useGetRecommendedProductsQuery } = recommendedProductsApi;
