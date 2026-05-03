import {
  fetchBaseQuery,
  type BaseQueryFn,
  type FetchArgs,
} from "@reduxjs/toolkit/query/react";
import type { ApiErrorResponse } from "../../types/api";
import { API_BASE_URL } from "../../config/apiConfig";
import { getAuthToken } from "../../utlis/auth";

export const createCustomBaseQuery = (
  baseUrl: string = API_BASE_URL
): BaseQueryFn<string | FetchArgs, unknown, ApiErrorResponse> => {
  const baseQuery = fetchBaseQuery({
    baseUrl,
    credentials: "include",
    prepareHeaders: (headers) => {
      const token = getAuthToken();
      if (token) {
        headers.set("Authorization", `Bearer ${token}`);
      }

      return headers;
    },
  });

  return async (args, api, extraOptions) => {
    const result = await baseQuery(args, api, extraOptions);

    if (result.error) {
      const error = result.error;

      switch (error.status) {
        case "FETCH_ERROR":
          return {
            error: {
              success: false,
              status: 0,
              message: "Network error",
              errors: ["Network error. Please try again."],
            },
          };

        case "TIMEOUT_ERROR":
          return {
            error: {
              success: false,
              status: 408,
              message: "Timeout error",
              errors: ["Request timeout. Please try again."],
            },
          };

        case "PARSING_ERROR":
          return {
            error: {
              success: false,
              status: 500,
              message: "Parsing error",
              errors: ["Invalid response from server."],
            },
          };

        default: {
          const errorData = error.data as ApiErrorResponse;
          return {
            error: {
              success: false,
              status: error.status as number,
              message: errorData?.message || `HTTP Error ${error.status}`,
              errors: errorData?.errors || [
                errorData?.message || "Request failed",
              ],
            },
          };
        }
      }
    }

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const response = result.data as any;
    const data = response.data ?? response;

    return { data };
  };
};
