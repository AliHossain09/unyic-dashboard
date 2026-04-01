import { Link } from "react-router";
import type { CollectionItem } from ".";

interface CollectionsCardProps {
  item: CollectionItem;
}

const CollectionsCard = ({ item }: CollectionsCardProps) => {
  const { title, imgSrc, brand, description } = item || {};

  return (
    <article className="space-y-2">
      <figure className="mb-3">
        <Link to={`/`} title={title} aria-label={`View collection ${title}`}>
          <img
            src={imgSrc}
            alt={title}
            className="w-full h-auto object-cover"
            loading="lazy"
          />
        </Link>
      </figure>
      <figcaption className="space-y-1 text-xs lg:text-base">
        <p className="text-sm lg:text-xl font-medium">{title}</p>
        <h2 className="uppercase font-semibold">{brand}</h2>
        <p className="text-dark">{description}</p>
      </figcaption>
      <Link
        to={`/`}
        title="Shop Now"
        className="text-primary underline font-semibold text-sm lg:text-base block w-max"
        aria-label={`Shop ${title}`}
      >
        Shop Now
      </Link>
    </article>
  );
};

export default CollectionsCard;
