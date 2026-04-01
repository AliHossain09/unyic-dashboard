import { Outlet, Navigate, useLocation } from "react-router";
import useUser from "../hooks/useUser";
import LoadingPage from "../pages/LoadingPage";

const RequireAuth = () => {
  const { user, isUserLoading } = useUser();
  const location = useLocation();

  if (isUserLoading) {
    return <LoadingPage />;
  }

  // When not loading and no user -> redirect to login
  if (!isUserLoading && !user) {
    return <Navigate to="/login" state={{ from: location }} replace />;
  }

  return <Outlet />;
};

export default RequireAuth;
