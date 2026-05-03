import { Outlet } from "react-router";
import MyAccountSidebar from "../components/layout/MyAccountSidebar";
import useScreenSize from "../hooks/useScreenSize";
import clsx from "clsx";

const MyAccountLayout = () => {
  const { isDesktopScreen } = useScreenSize();

  return (
    <div className={clsx(isDesktopScreen && "grid grid-cols-[1fr_4fr]")}>
      {isDesktopScreen && <MyAccountSidebar />}

      <div
        className={clsx(
          isDesktopScreen ? "p-8 bg-gray-100/60" : "ui-container mt-2 mb-8",
        )}
      >
        <Outlet />
      </div>
    </div>
  );
};

export default MyAccountLayout;
