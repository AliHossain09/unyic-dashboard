import { Link } from "react-router";
import useModalById from "../../../../../hooks/useModalById";

const NavSidebarFooter = () => {
  const { openModalWithData } = useModalById("authModal");

  return (
    <ul className="p-4 space-y-4">
      <li>
        <button onClick={() => openModalWithData({ activeTab: "login" })}>
          <span>Login / Sign up</span>
        </button>
      </li>

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
