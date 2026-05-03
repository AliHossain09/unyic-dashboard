import { useState } from "react";
import TopNavbar from "./TopNavbar";
import NavSidebar from "./NavSidebar";

const NavbarMobile = () => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);

  return (
    <div className="h-full relative">
      <TopNavbar openSidebar={() => setIsSidebarOpen(true)} />

      <NavSidebar
        isSidebarOpen={isSidebarOpen}
        closeSidebar={() => setIsSidebarOpen(false)}
      />
    </div>
  );
};

export default NavbarMobile;
