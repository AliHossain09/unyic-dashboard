import { Link } from "react-router";
import type { User } from "../../../../../../types";
import { IoLogOutOutline } from "react-icons/io5";
import useModalById from "../../../../../../hooks/useModalById";

interface ProfileDropdownProps {
  user: User;
}

const ProfileDropdown = ({ user }: ProfileDropdownProps) => {
  const { openModal } = useModalById("confirmLogoutModal");

  return (
    <ul className="text-sm space-y-2">
      <li>
        <div className="w-full px-3 py-2 rounded text-xs bg-primary-light/50">
          <p title={user.name} className="font-bold truncate">
            {user.name}
          </p>
          <p title={user.email} className="truncate">
            {user.email}
          </p>
        </div>
      </li>

      <li>
        <Link
          to={"/my-account/info"}
          className="block px-2 py-1 hover:underline underline-offset-2"
        >
          My Account
        </Link>
      </li>

      <li>
        <Link
          to={"/my-account/orders"}
          className="block px-2 py-1 hover:underline underline-offset-2"
        >
          My Orders
        </Link>
      </li>

      <li>
        <button
          onClick={openModal}
          className="px-2 py-1 hover:underline underline-offset-2 flex items-center gap-1"
        >
          Logout
          <span className="shrink-0">
            <IoLogOutOutline size={20} />
          </span>
        </button>
      </li>
    </ul>
  );
};

export default ProfileDropdown;
