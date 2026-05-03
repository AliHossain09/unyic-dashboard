import { useState } from "react";
import { IoChevronForward } from "react-icons/io5";
import clsx from "clsx";
import { Link } from "react-router";
import Button from "../../../../../ui/Button";
import useModalById from "../../../../../../hooks/useModalById";
import { accountMenuItems } from "../../../../../../config/accountMenu";

interface UserMenuProps {
  closeSidebar: () => void;
}

const UserMenu = ({ closeSidebar }: UserMenuProps) => {
  const [isOpen, setIsOpen] = useState(false);
  const { openModal } = useModalById("confirmLogoutModal");

  const handleLogoutButtonClick = () => {
    closeSidebar();
    openModal();
  };

  return (
    <li>
      <button
        onClick={() => setIsOpen((prev) => !prev)}
        className="py-2 flex items-center gap-2"
      >
        My Account
        <IoChevronForward
          className={clsx(
            "shrink-0 text-xl transition-transform duration-300",
            isOpen ? "rotate-90" : "rotate-0",
          )}
        />
      </button>

      {isOpen && (
        <ul className="ps-4 text-sm">
          {accountMenuItems.map((item, index) => {
            const { href, label } = item || {};

            return (
              <li key={index}>
                <Link to={href} className="block py-2">
                  <span>{label}</span>
                </Link>
              </li>
            );
          })}

          <li className="w-38 py-2">
            <Button onClick={handleLogoutButtonClick}>Logout</Button>
          </li>
        </ul>
      )}
    </li>
  );
};

export default UserMenu;
