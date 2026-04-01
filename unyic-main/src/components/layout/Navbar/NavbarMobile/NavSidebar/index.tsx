import clsx from "clsx";
import { useEffect } from "react";
import { useLocation } from "react-router";
import NavSidebarFooter from "./NavSidebarFooter";
import NavSidebarHeader from "./NavSidebarHeader";
import NavSidebarMenu from "./NavSidebarMenu";

interface NavSidebarProps {
  isSidebarOpen: boolean;
  closeSidebar: () => void;
}

const NavSidebar = ({ isSidebarOpen, closeSidebar }: NavSidebarProps) => {
  const location = useLocation();

  // Close the sidebar on route change
  useEffect(() => {
    if (isSidebarOpen) {
      closeSidebar();
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [location]);

  // Disable scrolling when sidebar is open
  useEffect(() => {
    if (isSidebarOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = "";
    }

    // Cleanup on component unmount or when closing
    return () => {
      document.body.style.overflow = "";
    };
  }, [isSidebarOpen]);

  return (
    <div>
      {/* Overlay */}
      {isSidebarOpen && (
        <div
          className="fixed z-50 inset-0 bg-dark-light/70"
          onClick={closeSidebar}
        />
      )}

      <div
        className={clsx(
          "w-64 h-full shadow-lg bg-light overflow-y-auto",
          "fixed z-50 top-0 left-0 transition-transform transform",
          isSidebarOpen ? "translate-x-0" : "-translate-x-full"
        )}
      >
        <NavSidebarHeader closeSidebar={closeSidebar} />
        <NavSidebarMenu />
        <NavSidebarFooter />
      </div>
    </div>
  );
};

export default NavSidebar;
