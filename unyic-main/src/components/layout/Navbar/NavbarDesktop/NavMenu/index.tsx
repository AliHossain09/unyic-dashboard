import NavMenuItem from "./NavMenuItem";
import useMenu from "../../../../../hooks/useMenu";

const NavMenu = () => {
  const { menu } = useMenu();

  return (
    <nav className="relative text-sm">
      <ul className="flex items-center justify-center px-4 border-y">
        {menu.map((item) => (
          <NavMenuItem key={item.id} item={item} />
        ))}
      </ul>
    </nav>
  );
};

export default NavMenu;
