import { configureStore } from "@reduxjs/toolkit";
import modalSlice from "./features/modal/modalSlice";
import { authApi } from "./features/auth/authApi";
import { menuApi } from "./features/menu/menuApi";
import menuSlice from "./features/menu/menuSlice";
import { bannerApi } from "./features/banner/bannerApi";
import { popularCatgoriesApi } from "./features/category/popularCatgoriesApi";
import { wishlistApi } from "./features/wishlist/wishlistApi";
import userSlice from "./features/user/userSlice";
import { userApi } from "./features/user/userApi";
import { recommendedProductsApi } from "./features/product/recommendedProductsApi";
import { cartApi } from "./features/cart/cartApi";
import { productApi } from "./features/product/productApi";
import { productsApi } from "./features/product/productsApi";

export const store = configureStore({
  reducer: {
    modalsState: modalSlice.reducer,
    menu: menuSlice.reducer,
    user: userSlice.reducer,

    [authApi.reducerPath]: authApi.reducer,
    [userApi.reducerPath]: userApi.reducer,
    [menuApi.reducerPath]: menuApi.reducer,
    [bannerApi.reducerPath]: bannerApi.reducer,
    [popularCatgoriesApi.reducerPath]: popularCatgoriesApi.reducer,
    [cartApi.reducerPath]: cartApi.reducer,
    [wishlistApi.reducerPath]: wishlistApi.reducer,
    [recommendedProductsApi.reducerPath]: recommendedProductsApi.reducer,
    [productApi.reducerPath]: productApi.reducer,
    [productsApi.reducerPath]: productsApi.reducer,
  },

  middleware: (getDefaultMiddleware) =>
    getDefaultMiddleware().concat(
      authApi.middleware,
      userApi.middleware,
      menuApi.middleware,
      bannerApi.middleware,
      popularCatgoriesApi.middleware,
      cartApi.middleware,
      wishlistApi.middleware,
      recommendedProductsApi.middleware,
      productApi.middleware,
      productsApi.middleware,
    ),
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
