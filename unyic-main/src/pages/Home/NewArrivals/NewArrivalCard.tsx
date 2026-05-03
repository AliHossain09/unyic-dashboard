import { Link } from "react-router";
import type { LatestCategory } from "../../../types";

interface NewArrivalCardProps {
  item: LatestCategory;
}

const NewArrivalCard = ({ item }: NewArrivalCardProps) => {
  const { name, slug, image } = item || {};

  return (
    <div>
      <Link to={`/category/${slug}`} className="block">
        <figure className="aspect-10/13 bg-gray-200">
          <img src={image} alt="" className="size-full object-cover" />
        </figure>

        <h5 className="py-2 lg:py-3 lg:mt-2 text-xs lg:text-sm text-center font-bold uppercase">{name}</h5>
      </Link>
    </div>
  );
};

export default NewArrivalCard;
