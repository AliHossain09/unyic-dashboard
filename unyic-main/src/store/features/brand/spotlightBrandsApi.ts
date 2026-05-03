import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { SpotlightBrand } from "../../../types";

export const spotlightBrandsApi = createApi({
  reducerPath: "spotlightBrandsApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getSpotlightBrands: builder.query<SpotlightBrand[], void>({
      query: () => "spotlight-brands",
    }),
  }),
});

export const { useGetSpotlightBrandsQuery } = spotlightBrandsApi;
