import useMenu from "../../../../../../hooks/useMenu";
import MenuItem from "./MenuItem";

const NavSidebarMenu = () => {
  const { menu } = useMenu();

  return (
    <ul className="px-4 py-2 border-b">
      {menu.map((item, index) => (
        <li key={index}>
          <MenuItem item={item} />
        </li>
      ))}
    </ul>
  );
};

export default NavSidebarMenu;
