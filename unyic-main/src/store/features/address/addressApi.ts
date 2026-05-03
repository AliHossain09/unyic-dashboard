import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Address, Id } from "../../../types";
import type { AddressFormData } from "../../../components/forms/AddressForm";

export const addressApi = createApi({
  reducerPath: "addressApi",
  baseQuery: createCustomBaseQuery(),
  tagTypes: ["AddressList"],
  endpoints: (builder) => ({
    // GET
    getAddresses: builder.query<Address[], void>({
      query: () => ({
        url: "addresses",
        method: "GET",
      }),
      providesTags: ["AddressList"],
    }),

    // CREATE
    createAddress: builder.mutation<void, AddressFormData>({
      query: (body) => ({
        url: "addresses",
        method: "POST",
        body,
      }),
      invalidatesTags: ["AddressList"],
    }),

    // UPDATE
    updateAddress: builder.mutation<void, { id: Id; data: AddressFormData }>({
      query: ({ id, data }) => ({
        url: `addresses/${id}`,
        method: "PATCH",
        body: data,
      }),
      invalidatesTags: ["AddressList"],
    }),

    // DELETE
    deleteAddress: builder.mutation<void, Id>({
      query: (id) => ({
        url: `addresses/${id}`,
        method: "DELETE",
      }),
      invalidatesTags: ["AddressList"],
    }),

    // SET SELECTED ADDRESS
    setSelectedAddress: builder.mutation<void, Id>({
      query: (addressId) => ({
        url: `addresses/selected-address`,
        method: "PATCH",
        body: { addressId },
      }),
      invalidatesTags: ["AddressList"],
    }),
  }),
});

export const {
  useGetAddressesQuery,
  useCreateAddressMutation,
  useUpdateAddressMutation,
  useDeleteAddressMutation,
  useSetSelectedAddressMutation,
} = addressApi;
