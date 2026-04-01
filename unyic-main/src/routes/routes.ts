import { createBrowserRouter } from "react-router";
import App from "../App";
import Home from "../pages/Home";
import MainLayout from "../layouts/MainLayout";
import Wishlist from "../pages/Wishlist";
import StoreLocator from "../pages/StoreLocator";
import CustomerSupport from "../pages/CustomerSupport";
import RequireAuth from "./RequireAuth";
import Login from "../pages/Login";
import AuthLayout from "../layouts/AuthLayout";
import Cart from "../pages/Cart";
import Checkout from "../pages/Checkout";
import Product from "../pages/Product";
import ProductCollection from "../pages/ProductCollection";
// import Blog from "../pages/Blog";

const router = createBrowserRouter([
  {
    path: "/",
    Component: App,
    children: [
      {
        path: "/",
        Component: MainLayout,
        children: [
          // Home page
          { index: true, Component: Home },

          // Store locator page
          { path: "store-locator", Component: StoreLocator },

          // Customer support page
          {
            path: "customer-support",
            Component: CustomerSupport,
          },

          // Product collection routes with loader to pass type info
          {
            path: "sub-category/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "sub-category" }),
          },
          {
            path: "category/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "category" }),
          },
          {
            path: "department/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "department" }),
          },
          {
            path: "collection/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "collection" }),
          },

          // Single product page
          {
            path: "product/:productSlug",
            Component: Product,
          },

          // Protected routes (require authentication)
          {
            Component: RequireAuth,
            children: [
              { path: "wishlist", Component: Wishlist },
              {
                path: "cart",
                Component: Cart,
              },
              {
                path: "checkout",
                Component: Checkout,
              },
            ],
          },

          // {
          //   path: "blog",
          //   Component: Blog,
          // },
        ],
      },

      {
        Component: AuthLayout,
        children: [
          {
            path: "login",
            Component: Login,
          },
        ],
      },
    ],
  },
]);

export default router;
