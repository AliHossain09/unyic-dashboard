import { createApi } from "@reduxjs/toolkit/query/react";
import { createCustomBaseQuery } from "../../services/customBaseQuery";
import type { Id, Product } from "../../../types";

export const wishlistApi = createApi({
  reducerPath: "wishlistApi",
  baseQuery: createCustomBaseQuery(),
  tagTypes: ["Wishlist"],
  endpoints: (builder) => ({
    // Fetch wishlist products
    getWishlistProducts: builder.query<Product[], void>({
      query: () => "wishlist",
      providesTags: ["Wishlist"],
    }),

    // Add to wishlist
    addToWishlist: builder.mutation<void, Id>({
      query: (productId) => {
        return {
          url: "wishlist",
          method: "POST",
          body: {
            product_id: productId,
          },
        };
      },
      onQueryStarted: async (productId, { dispatch, queryFulfilled }) => {
        const patch = dispatch(
          wishlistApi.util.updateQueryData(
            "getWishlistProducts",
            undefined,
            (draft) => {
              draft.push({ id: productId } as Product);
            }
          )
        );

        try {
          await queryFulfilled;
        } catch {
          patch.undo(); // rollback if server fails
        }
      },
      invalidatesTags: ["Wishlist"],
    }),

    // Delete from wishlist
    removeFromWishlist: builder.mutation<{ success: boolean; id: Id }, Id>({
      query: (productId) => ({
        url: `wishlist/${productId}`,
        method: "DELETE",
      }),
      onQueryStarted: async (productId, { dispatch, queryFulfilled }) => {
        const patch = dispatch(
          wishlistApi.util.updateQueryData(
            "getWishlistProducts",
            undefined,
            (draft) => {
              return draft.filter((product) => product.id !== productId);
            }
          )
        );
        try {
          await queryFulfilled;
        } catch {
          patch.undo(); // rollback if server fails
        }
      },
      invalidatesTags: ["Wishlist"],
    }),
  }),
});

export const {
  useGetWishlistProductsQuery,
  useAddToWishlistMutation,
  useRemoveFromWishlistMutation,
} = wishlistApi;
