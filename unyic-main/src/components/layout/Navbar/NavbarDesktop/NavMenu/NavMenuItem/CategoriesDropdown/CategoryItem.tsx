import { Link } from "react-router";
import type { Category } from "../../../../../../../types/menu";

interface CategoryItemProps {
  category: Category;
}

const CategoryItem = ({ category }: CategoryItemProps) => {
  const { name, slug, sub_categories } = category || {};

  return (
    <div>
      <Link to={`/category/${slug}`} className="mb-3 font-semibold uppercase">
        {name}
      </Link>

      <ul className="mt-2 space-y-1">
        {sub_categories.map((subcat) => (
          <li key={subcat.id}>
            <Link to={`/sub-category/${subcat.slug}`} className="hover:font-bold">
              {subcat.name}
            </Link>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default CategoryItem;
