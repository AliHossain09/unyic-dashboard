import { Link } from "react-router";
import type { SubCategory } from "../../../../../../../../types/menu";

interface SubCategoryItemProps {
  subCategory: SubCategory;
}

const SubCategoryItem = ({ subCategory }: SubCategoryItemProps) => {
  const { name, slug } = subCategory || {};

  return (
    <li>
      <Link to={`/sub-category/${slug}`} className="block py-1">
        {name}
      </Link>
    </li>
  );
};

export default SubCategoryItem;
