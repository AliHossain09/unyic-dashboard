import { LuLogOut } from "react-icons/lu";
import useModalById from "../../../hooks/useModalById";

const SidebarFooter = () => {
  const { openModal } = useModalById("confirmLogoutModal");

  return (
    <footer className="pt-3 border-t">
      <button
        onClick={openModal}
        className="w-full p-3 rounded-md flex items-center gap-3 text-dark-light hover:bg-red-600/10 hover:text-red-600"
      >
        <LuLogOut size={16} />
        <span className="font-semibold text-sm">Logout</span>
      </button>
    </footer>
  );
};

export default SidebarFooter;
