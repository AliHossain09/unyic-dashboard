import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { User } from "../../../types";
import { setUserLoading, setUser, setUserUnfetched } from "./userSlice";

type UpdateUserPayload = Pick<User, "name" | "phone">;

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
              phone: data.phone,
            }),
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

    updateUser: builder.mutation<User, UpdateUserPayload>({
      query: (body) => ({
        url: "user/details",
        method: "PATCH",
        body,
      }),

      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          const { data } = await queryFulfilled;

          dispatch(
            setUser({
              id: data.id,
              name: data.name,
              email: data.email,
              phone: data.phone,
            }),
          );
        } catch (error) {
          console.log("Error updating user data:", error);
        }
      },
    }),
  }),
});

export const { useGetUserQuery, useUpdateUserMutation } = userApi;
