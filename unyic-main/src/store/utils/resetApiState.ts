import { cartApi } from "../features/cart/cartApi";
import { wishlistApi } from "../features/wishlist/wishlistApi";
import type { AppDispatch } from "../store";

export const resetUserScopedApiState = (dispatch: AppDispatch) => {
  dispatch(cartApi.util.resetApiState());
  dispatch(wishlistApi.util.resetApiState());
};
