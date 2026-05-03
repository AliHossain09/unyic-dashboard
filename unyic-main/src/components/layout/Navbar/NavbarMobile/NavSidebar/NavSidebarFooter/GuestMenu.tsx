import useModalById from "../../../../../../hooks/useModalById";

interface GuestMenuProps {
  closeSidebar: () => void;
}

const GuestMenu = ({ closeSidebar }: GuestMenuProps) => {
  const { openModalWithData } = useModalById("authModal");

  const handleClick = () => {
    closeSidebar();
    openModalWithData({ activeTab: "login" });
  };

  return (
    <li>
      <button onClick={handleClick}>
        <span>Login / Sign up</span>
      </button>
    </li>
  );
};

export default GuestMenu;
