import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import { setAuthToken } from "../../../utlis/auth";
import { setUser } from "../user/userSlice";

interface NewUser {
  name: string;
  email: string;
  password: string;
}

interface LoginCredentials {
  email: string;
  password: string;
}

export const authApi = createApi({
  reducerPath: "authApi",
  baseQuery: createCustomBaseQuery(),
  endpoints: (builder) => ({
    register: builder.mutation({
      query: (newUser: NewUser) => ({
        url: "/register",
        method: "POST",
        body: newUser,
      }),
      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          const { data } = await queryFulfilled;
          const { token, user } = data;

          if (token) {
            setAuthToken(token);
          }

          dispatch(
            setUser({
              id: user.id,
              name: user.name,
              email: user.email,
            })
          );
        } catch (error) {
          console.error("Error registering user:", error);
        }
      },
    }),

    login: builder.mutation({
      query: (credentials: LoginCredentials) => ({
        url: "/login",
        method: "POST",
        body: credentials,
      }),
      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          const { data } = await queryFulfilled;
          const { token, user } = data;

          if (token) {
            setAuthToken(token);
          }

          dispatch(
            setUser({
              id: user.id,
              name: user.name,
              email: user.email,
            })
          );
        } catch (error) {
          console.error("Error logging in user:", error);
        }
      },
    }),
  }),
});

export const { useRegisterMutation, useLoginMutation } = authApi;
