import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { FeaturedCollection } from "../../../types";

export const featuredCollectionsApi = createApi({
  reducerPath: "featuredCollectionsApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getFeaturedCollections: builder.query<FeaturedCollection[], void>({
      query: () => "collections/featured",
    }),
  }),
});

export const { useGetFeaturedCollectionsQuery } = featuredCollectionsApi;
