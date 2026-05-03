import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { LatestCategory, PopularCategory } from "../../../types";

export const categoriesApi = createApi({
  reducerPath: "categoriesApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getPopularCatgories: builder.query<PopularCategory[], void>({
      query: () => "popular-categories",
    }),

    getLatestCatgories: builder.query<LatestCategory[], void>({
      query: () => "categories/latest",
    }),
  }),
});

export const { useGetPopularCatgoriesQuery, useGetLatestCatgoriesQuery } =
  categoriesApi;
