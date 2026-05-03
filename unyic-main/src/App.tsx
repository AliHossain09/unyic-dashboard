import { Outlet, useLocation } from "react-router";
import AuthModal from "./components/modals/AuthModal";
import ForgotPasswordModal from "./components/modals/ForgotPasswordModal";
import { useEffect } from "react";
import ProductSizeSelectorModal from "./components/modals/ProductSizeSelectorModal";
import { useGetUserQuery } from "./store/features/user/userApi";
import { useGetMenuQuery } from "./store/features/menu/menuApi";
import LoadingPage from "./pages/LoadingPage";
import AddAddressModal from "./components/modals/AddAddressModal";
import UpdateAddressModal from "./components/modals/UpdateAddressModal";
import ConfirmDeleteAddressModal from "./components/modals/ConfirmDeleteAddressModal";
import ConfirmLogoutModal from "./components/modals/ConfirmLogoutModal";

function App() {
  const { pathname } = useLocation();

  // Fetch data
  const { isLoading: isUserLoading } = useGetUserQuery();
  const { isLoading: isMenuLoading } = useGetMenuQuery();

  // Scroll to top on route change
  useEffect(() => {
    window.scrollTo({ top: 0, behavior: "instant" });
  }, [pathname]);

  const isAppLoading = isUserLoading || isMenuLoading;

  if (isAppLoading) {
    return <LoadingPage />;
  }

  return (
    <div className="font-lato text-dark bg-light">
      <Outlet />

      <AuthModal />
      <ForgotPasswordModal />
      <ProductSizeSelectorModal />
      <AddAddressModal />
      <UpdateAddressModal />
      <ConfirmDeleteAddressModal />
      <ConfirmLogoutModal />
    </div>
  );
}

export default App;
