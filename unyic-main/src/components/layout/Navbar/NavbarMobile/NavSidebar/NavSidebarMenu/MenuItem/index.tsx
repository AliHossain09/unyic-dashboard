import { Link } from "react-router";
import { IoChevronForward } from "react-icons/io5";
import clsx from "clsx";
import { useState } from "react";
import type { MenuItem as MenuItemType } from "../../../../../../../types/menu";
import CategoryItem from "./CategoryItem";

interface MenuItemProps {
  item: MenuItemType;
}

const MenuItem = ({ item }: MenuItemProps) => {
  const [isOpen, setIsOpen] = useState(false);
  const { name, slug, categories } = item || {};

  const hasCategories = categories && categories.length > 0;

  return (
    <>
      <div className="w-full py-2 flex items-center justify-between">
        <Link
          to={`/department/${slug}`}
          className="font-semibold active:underline"
        >
          {name}
        </Link>

        {hasCategories && (
          <button onClick={() => setIsOpen((prev) => !prev)}>
            <IoChevronForward
              className={clsx(
                "shrink-0 text-xl transition-transform duration-300",
                isOpen ? "rotate-90" : "rotate-0",
              )}
            />
          </button>
        )}
      </div>

      {hasCategories && (
        <ul
          className={clsx(
            "pl-2 pe-1 transition-all duration-300 overflow-hidden",
            isOpen ? "max-h-96" : "max-h-0",
          )}
        >
          {categories.map((categoryItem) => (
            <li key={categoryItem.id}>
              <CategoryItem categoryItem={categoryItem} />
            </li>
          ))}
        </ul>
      )}
    </>
  );
};

export default MenuItem;
