import { configureStore } from "@reduxjs/toolkit";
import modalSlice from "./features/modal/modalSlice";
import { authApi } from "./features/auth/authApi";
import { menuApi } from "./features/menu/menuApi";
import menuSlice from "./features/menu/menuSlice";
import { bannerApi } from "./features/banner/bannerApi";
import { categoriesApi } from "./features/category/categoriesApi";
import { wishlistApi } from "./features/wishlist/wishlistApi";
import userSlice from "./features/user/userSlice";
import { userApi } from "./features/user/userApi";
import { recommendedProductsApi } from "./features/product/recommendedProductsApi";
import { cartApi } from "./features/cart/cartApi";
import { productApi } from "./features/product/productApi";
import { productsApi } from "./features/product/productsApi";
import { featuredCollectionsApi } from "./features/collection/featuredCollectionsApi";
import { spotlightBrandsApi } from "./features/brand/spotlightBrandsApi";
import { addressApi } from "./features/address/addressApi";

export const store = configureStore({
  reducer: {
    modalsState: modalSlice.reducer,
    menu: menuSlice.reducer,
    user: userSlice.reducer,

    [authApi.reducerPath]: authApi.reducer,
    [userApi.reducerPath]: userApi.reducer,
    [addressApi.reducerPath]: addressApi.reducer,
    [menuApi.reducerPath]: menuApi.reducer,
    [bannerApi.reducerPath]: bannerApi.reducer,
    [categoriesApi.reducerPath]: categoriesApi.reducer,
    [featuredCollectionsApi.reducerPath]: featuredCollectionsApi.reducer,
    [spotlightBrandsApi.reducerPath]: spotlightBrandsApi.reducer,
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
      addressApi.middleware,
      menuApi.middleware,
      bannerApi.middleware,
      categoriesApi.middleware,
      featuredCollectionsApi.middleware,
      spotlightBrandsApi.middleware,
      cartApi.middleware,
      wishlistApi.middleware,
      recommendedProductsApi.middleware,
      productApi.middleware,
      productsApi.middleware,
    ),
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;
