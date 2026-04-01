import { Outlet } from "react-router";
import { Toaster } from "react-hot-toast";
import Navbar from "../components/layout/Navbar";
import Footer from "../components/layout/Footer";

const MainLayout = () => {
  return (
    <>
      <Navbar />

      <main className="min-h-dvh pt-[var(--main-nav-h)]">
        <Outlet />
      </main>

      <Footer />

      <Toaster />
    </>
  );
};

export default MainLayout;
