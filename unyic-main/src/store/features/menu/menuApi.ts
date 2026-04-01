import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { MenuItem } from "../../../types/menu";
import { setMenu, setMenuLoading } from "./menuSlice";

export const menuApi = createApi({
  reducerPath: "menuApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getMenu: builder.query<MenuItem[], void>({
      query: () => "menu",
      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          dispatch(setMenuLoading(true));

          const { data } = await queryFulfilled;

          if (data) {
            dispatch(setMenu(data));
          }
        } catch (error) {
          console.log("Error fetching menu data:", error);
        } finally {
          dispatch(setMenuLoading(false));
        }
      },
    }),
  }),
});

export const { useGetMenuQuery } = menuApi;
