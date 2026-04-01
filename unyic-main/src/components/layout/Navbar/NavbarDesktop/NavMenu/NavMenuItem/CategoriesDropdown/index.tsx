import type { Category } from "../../../../../../../types/menu";
import CategoryItem from "./CategoryItem";

interface CategoriesDropdownProps {
  categories: Category[];
}

const CategoriesDropdown = ({ categories }: CategoriesDropdownProps) => {
  return (
    <div className="w-screen absolute z-10 top-full left-0 bg-light shadow-lg hidden group-hover:block">
      <div className="px-8 pt-4 pb-8 flex flex-wrap gap-12">
        {categories.map((category, idx) => (
          <CategoryItem key={idx} category={category} />
        ))}
      </div>
    </div>
  );
};

export default CategoriesDropdown;
