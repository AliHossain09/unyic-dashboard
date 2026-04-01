import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { PopularCategory } from "../../../types";

export const popularCatgoriesApi = createApi({
  reducerPath: "popularCatgoriesApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getPopularCatgories: builder.query<PopularCategory[], void>({
      query: () => "popular-categories",
    }),
  }),
});

export const { useGetPopularCatgoriesQuery } = popularCatgoriesApi;
