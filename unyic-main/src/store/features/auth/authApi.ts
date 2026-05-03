import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import { removeAuthToken, setAuthToken } from "../../../utlis/auth";
import { clearUser, setUser } from "../user/userSlice";
import { resetUserScopedApiState } from "../../utils/resetApiState";

interface NewUser {
  name: string;
  email: string;
  password: string;
}

interface LoginCredentials {
  email: string;
  password: string;
}

interface ChangePasswordPayload {
  currentPassword: string;
  newPassword: string;
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
              phone: user.phone,
            }),
          );

          resetUserScopedApiState(dispatch);
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
              phone: user.phone,
            }),
          );

          resetUserScopedApiState(dispatch);
        } catch (error) {
          console.error("Error logging in user:", error);
        }
      },
    }),

    logout: builder.mutation<void, void>({
      query: () => ({
        url: "/logout",
        method: "POST",
      }),

      onQueryStarted: async (_, { dispatch, queryFulfilled }) => {
        try {
          await queryFulfilled;

          // Clear token from storage or headers
          removeAuthToken();

          // Clear user from Redux
          dispatch(clearUser());

          resetUserScopedApiState(dispatch);
        } catch (error) {
          console.error("Error logging out:", error);
        }
      },
    }),

    changePassword: builder.mutation<void, ChangePasswordPayload>({
      query: (body) => ({
        url: "user/change-password",
        method: "POST",
        body,
      }),
    }),
  }),
});

export const {
  useRegisterMutation,
  useLoginMutation,
  useLogoutMutation,
  useChangePasswordMutation,
} = authApi;
