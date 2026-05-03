import "./styles/index.css";

import { StrictMode } from "react";
import { RouterProvider } from "react-router";
import ReactDOM from "react-dom/client";
import router from "./routes/routes";
import { store } from "./store/store";
import { Provider } from "react-redux";
import WishlistProvider from "./contexts/wishlist/WishlistProvider";
import CartProvider from "./contexts/cart/CartProvider";

const root = document.getElementById("root");

if (!root) {
  throw new Error("Root element not found");
}

ReactDOM.createRoot(root).render(
  <StrictMode>
    <Provider store={store}>
      <WishlistProvider>
        <CartProvider>
          <RouterProvider router={router} />
        </CartProvider>
      </WishlistProvider>
    </Provider>
  </StrictMode>
);
