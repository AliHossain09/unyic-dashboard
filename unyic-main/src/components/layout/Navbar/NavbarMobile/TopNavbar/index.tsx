import { IoMenu } from "react-icons/io5";
import Logo from "../../../../ui/Logo";
import SearchBar from "./SearchBar";
import WishlistLink from "../../shared/WishlistLink";
import CartLink from "../../shared/CartLink";

interface TopNavbarProps {
  openSidebar: () => void;
}

const TopNavbar = ({ openSidebar }: TopNavbarProps) => {
  return (
    <nav className="h-full flex items-center justify-between">
      <div className="flex items-center gap-4 ps-2">
        <button className="text-3xl" onClick={openSidebar}>
          <IoMenu />
        </button>

        <div className="w-[120px] mt-1">
          <Logo />
        </div>
      </div>

      <div className="flex items-center gap-4 pe-4 text-xl">
        <SearchBar />
        <WishlistLink />
        <CartLink />
      </div>
    </nav>
  );
};

export default TopNavbar;