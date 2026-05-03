import { Link } from "react-router";
import type { FeaturedCollection } from "../../../types";

interface FeaturedCollectionCardProps {
  collection: FeaturedCollection;
}

const FeaturedCollectionCard = ({
  collection,
}: FeaturedCollectionCardProps) => {
  const { name, slug, brand, short_description, image } = collection || {};

  return (
    <div className="space-y-2">
      <Link to={`/collection/${slug}`} className="block aspect-13/17 bg-gray-200">
        <img src={image} alt="" className="size-full object-cover" />
      </Link>

      <div className="text-xs md:text-sm">
        <h4 className="text-base md:text-xl">{name}</h4>
        <p className="mt-0.5 uppercase">{brand}</p>

        <p className="mb-2 mt-1 text-dark-light">{short_description}</p>

        <Link
          to={`/collection/${slug}`}
          className="text-primary-dark underline underline-offset-2"
        >
          Shop Now
        </Link>
      </div>
    </div>
  );
};

export default FeaturedCollectionCard;
