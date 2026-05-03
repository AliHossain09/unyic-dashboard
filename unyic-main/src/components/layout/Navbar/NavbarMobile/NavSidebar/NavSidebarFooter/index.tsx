import { Link } from "react-router";
import useUser from "../../../../../../hooks/useUser";
import UserMenu from "./UserMenu";
import GuestMenu from "./GuestMenu";

interface NavSidebarFooterProps {
  closeSidebar: () => void;
}

const NavSidebarFooter = ({ closeSidebar }: NavSidebarFooterProps) => {
  const { user } = useUser();

  return (
    <ul className="p-4 space-y-4">
      {user ? (
        <UserMenu closeSidebar={closeSidebar} />
      ) : (
        <GuestMenu closeSidebar={closeSidebar} />
      )}

      <li>
        <Link to={"store-locator"}>
          <span>Locate Stores</span>
        </Link>
      </li>

      <li>
        <Link to={"/customer-support"}>
          <span>Customer Support</span>
        </Link>
      </li>
    </ul>
  );
};

export default NavSidebarFooter;
