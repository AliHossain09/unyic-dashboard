import Logo from "../../../../ui/Logo";
import CartLink from "../../shared/CartLink";
import WishlistLink from "../../shared/WishlistLink";
import ProfileLink from "./ProfileLink";
import SearchBar from "./SearchBar";
import ServiceLinks from "./ServiceLinks";


const TopBar = () => {
  return (
    <div className="grid grid-cols-3 items-center justify-between ps-2 pe-5 py-5">
      <ServiceLinks />

      <div className="w-max mx-auto">
        <Logo />
      </div>

      <div className="flex items-center gap-6 justify-end">
        <SearchBar />

        <div className="flex items-center gap-6 text-xl">
          <ProfileLink />
          <WishlistLink />
          <CartLink />
        </div>
      </div>
    </div>
  );
};

export default TopBar;
