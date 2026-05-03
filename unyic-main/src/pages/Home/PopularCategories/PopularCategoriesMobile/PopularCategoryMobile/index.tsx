import { Link } from "react-router";
import type { PopularCategory } from "../../../../../types";

interface PopularCategoryMobileProps {
  category: PopularCategory;
}

const PopularCategoryMobile = ({ category }: PopularCategoryMobileProps) => {
  const { images, link, title } = category || {};

  return (
    <div className="flex-none w-23 pe-3">
      <Link to={`${link}`} title={title}>
        <img
          src={images?.mobile}
          alt=""
          className="w-full aspect-square rounded-full object-cover"
        />
      </Link>

      <div className="h-8 mt-2 text-center">
        <p className="text-xs font-semibold line-clamp-2">{title}</p>
      </div>
    </div>
  );
};

export default PopularCategoryMobile;
