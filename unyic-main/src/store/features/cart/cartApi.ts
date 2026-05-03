import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { CartItem, Id } from "../../../types";
import type { ProductSize } from "../../../types/product";

export type AddToCartPayload = {
  product_id: Id;
  size: ProductSize;
};

export type UpdateCartItemPayload = {
  cartItemId: Id;
  size: ProductSize;
  quantity: number;
};

export const cartApi = createApi({
  reducerPath: "cartApi",
  baseQuery: createCustomBaseQuery(),
  tagTypes: ["Cart"],
  endpoints: (builder) => ({
    getCart: builder.query<CartItem[], void>({
      query: () => "cart",
      providesTags: ["Cart"],
    }),

    addToCart: builder.mutation<void, AddToCartPayload>({
      query: ({ product_id, size }) => ({
        url: "cart",
        method: "POST",
        body: { product_id, size },
      }),
      invalidatesTags: ["Cart"],
    }),

    updateCartItem: builder.mutation<void, UpdateCartItemPayload>({
      query: ({ cartItemId, size, quantity }) => ({
        url: `cart/${cartItemId}`,
        method: "PUT",
        body: { size, quantity },
      }),
      invalidatesTags: ["Cart"],
    }),

    removeCartItem: builder.mutation<void, Id>({
      query: (cartItemId) => ({
        url: `cart/${cartItemId}`,
        method: "DELETE",
      }),
      invalidatesTags: ["Cart"],
    }),
  }),
});

export const {
  useGetCartQuery,
  useAddToCartMutation,
  useUpdateCartItemMutation,
  useRemoveCartItemMutation,
} = cartApi;
