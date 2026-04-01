import useScreenSize from "../../../hooks/useScreenSize";
import NavbarDesktop from "./NavbarDesktop";
import NavbarMobile from "./NavbarMobile";

const Navbar = () => {
  const { isDesktopScreen } = useScreenSize();

  return (
    <header className="h-[var(--main-nav-h)] w-full fixed z-40 top-0 bg-light">
      {isDesktopScreen ? <NavbarDesktop /> : <NavbarMobile />}
    </header>
  );
};

export default Navbar;
