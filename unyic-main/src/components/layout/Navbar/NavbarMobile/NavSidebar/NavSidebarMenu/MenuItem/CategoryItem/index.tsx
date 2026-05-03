import { IoChevronForward } from "react-icons/io5";
import clsx from "clsx";
import { useState } from "react";
import { Link } from "react-router";
import type { Category } from "../../../../../../../../types/menu";
import SubCategoryItem from "./SubCategoryItem";

interface CategoryItemProps {
  categoryItem: Category;
}

const CategoryItem = ({ categoryItem }: CategoryItemProps) => {
  const [isOpen, setIsOpen] = useState(false);

  const { name, slug, sub_categories } = categoryItem || {};

  const a = sub_categories && sub_categories.length > 0;

  return (
    <>
      <div className="w-full py-1 flex items-center justify-between">
        <Link to={`/category/${slug}`}>{name}</Link>

        {a && (
          <button onClick={() => setIsOpen((prev) => !prev)}>
            <IoChevronForward
              className={clsx(
                "shrink-0 transition-transform duration-300",
                isOpen ? "rotate-90" : "rotate-0",
              )}
            />
          </button>
        )}
      </div>

      {a && (
        <ul
          className={clsx(
            "pl-1 transition-all duration-300 overflow-hidden text-sm",
            isOpen ? "max-h-96" : "max-h-0",
          )}
        >
          {sub_categories.map((subCategory) => (
            <SubCategoryItem key={subCategory.id} subCategory={subCategory} />
          ))}
        </ul>
      )}
    </>
  );
};

export default CategoryItem;
