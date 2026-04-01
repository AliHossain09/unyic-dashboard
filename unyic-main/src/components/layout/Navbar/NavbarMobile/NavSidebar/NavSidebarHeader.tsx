import { IoClose } from "react-icons/io5";

interface NavSidebarHeaderProps {
  closeSidebar: () => void;
}

const NavSidebarHeader = ({ closeSidebar }: NavSidebarHeaderProps) => {
  return (
    <div className="h-12 px-4 border-b sticky z-10 top-0 bg-light">
      <button className="absolute top-1/2 -translate-y-1/2 right-4 text-2xl" onClick={closeSidebar}>
        <IoClose />
      </button>
    </div>
  );
};

export default NavSidebarHeader;
