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
import NotFoundPage from "../pages/NotFoundPage";
import MyAccountLayout from "../layouts/MyAccountLayout";
import Addresses from "../pages/my-account/Addresses";
import ProfileDetails from "../pages/my-account/ProfileDetails";
import ChangePassword from "../pages/my-account/ChangePassword";
import Search from "../pages/Search";
// import Blog from "../pages/Blog";

const router = createBrowserRouter([
  {
    path: "/",
    Component: App,
    errorElement: <NotFoundPage />,
    children: [
      {
        path: "/",
        Component: MainLayout,
        children: [
          {
            index: true,
            Component: Home,
          },
          {
            path: "wishlist",
            Component: Wishlist,
          },
          {
            path: "cart",
            Component: Cart,
          },
          {
            path: "product/:productSlug",
            Component: Product,
          },
          {
            path: "search",
            Component: Search,
          },

          // Product collection routes with loader to pass type info
          {
            path: "collection/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "collection" }),
          },
          {
            path: "department/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "department" }),
          },
          {
            path: "category/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "category" }),
          },
          {
            path: "sub-category/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "sub-category" }),
          },
          {
            path: "brand/:slug",
            Component: ProductCollection,
            loader: () => ({ collectionType: "brand" }),
          },

          // Protected routes (require authentication)
          {
            Component: RequireAuth,
            children: [
              {
                path: "checkout",
                Component: Checkout,
              },

              {
                Component: MyAccountLayout,
                children: [
                  {
                    path: "/my-account/info",
                    Component: ProfileDetails,
                  },
                  {
                    path: "/my-account/orders",
                    Component: null,
                  },
                  {
                    path: "/my-account/addresses",
                    Component: Addresses,
                  },
                  {
                    path: "/my-account/change-password",
                    Component: ChangePassword,
                  },
                ],
              },
            ],
          },

          {
            path: "store-locator",
            Component: StoreLocator,
          },
          {
            path: "customer-support",
            Component: CustomerSupport,
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
