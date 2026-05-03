import { IoClose } from "react-icons/io5";
import useUser from "../../../../../hooks/useUser";

interface NavSidebarHeaderProps {
  closeSidebar: () => void;
}

const NavSidebarHeader = ({ closeSidebar }: NavSidebarHeaderProps) => {
  const { user } = useUser();

  return (
    <div className="h-12 px-4 border-b sticky z-10 top-0 bg-light flex items-center gap-3">
      {user && <p className="font-bold">Hi, {user.name}!</p>}

      <button onClick={closeSidebar} className="ms-auto">
        <IoClose size={24} />
      </button>
    </div>
  );
};

export default NavSidebarHeader;
