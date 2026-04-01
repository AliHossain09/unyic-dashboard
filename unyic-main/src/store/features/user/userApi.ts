import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { User } from "../../../types";
import { setUserLoading, setUser, setUserUnfetched } from "./userSlice";

export const userApi = createApi({
  reducerPath: "userApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    getUser: builder.query<User, void>({
      query: () => "user/details",

      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          dispatch(setUserLoading(true));

          const { data } = await queryFulfilled;
          dispatch(
            setUser({
              id: data.id,
              name: data.name,
              email: data.email,
            })
          );
        } catch (error) {
          dispatch(setUser(null));
          console.log("Error fetching user data:", error);
        } finally {
          dispatch(setUserLoading(false));
          dispatch(setUserUnfetched(false));
        }
      },
    }),
  }),
});

export const { useGetUserQuery } = userApi;
