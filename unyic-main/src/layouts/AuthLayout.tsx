import { Outlet } from "react-router";
import Logo from "../components/ui/Logo";

const AuthLayout = () => {
  return (
    <>
      <nav className="h-16 w-full fixed z-40 top-0 bg-light ui-container shadow flex items-center">
        <Logo />
      </nav>

      <main className="h-[calc(100dvh-64px)] mt-16 overflow-y-auto">
        <Outlet />
      </main>
    </>
  );
};

export default AuthLayout;
