import { Link } from "react-router";
import CategoriesDropdown from "./CategoriesDropdown";
import type { MenuItem } from "../../../../../../types/menu";

interface NavMenuItemProps {
  item: MenuItem;
}

const NavMenuItem = ({ item }: NavMenuItemProps) => {
  const { name, slug, categories } = item;

  return (
    <li className="group px-4">
      <Link to={`/department/${slug}`} className="py-4 block relative">
        <span className="font-semibold uppercase text-dark/85">{name}</span>

        {/* Underline on hover */}
        <span className="hidden group-hover:block w-full h-[2px] bg-primary absolute -bottom-px z-20" />
      </Link>

      {/* Dropdown for categories (if available) */}
      {categories && categories.length > 0 && (
        <CategoriesDropdown categories={categories} />
      )}
    </li>
  );
};

export default NavMenuItem;
