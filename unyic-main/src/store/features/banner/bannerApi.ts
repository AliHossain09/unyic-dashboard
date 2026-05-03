import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Banner } from "../../../types";

export const bannerApi = createApi({
  reducerPath: "bannerApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getBanners: builder.query<Banner[], void>({
      query: () => "banners",
    }),
  }),
});

export const { useGetBannersQuery } = bannerApi;
