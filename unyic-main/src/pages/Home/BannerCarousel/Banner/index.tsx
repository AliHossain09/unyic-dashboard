import { Link } from "react-router";
import type { Banner as BannerType } from "../../../../types";

interface BannerProps {
  banner: BannerType;
}

const Banner = ({ banner }: BannerProps) => {
  const { id, link, title, images } = banner || {};

  return (
    <div key={id} className="flex-none w-full">
      <Link to={link} className="block w-full" title={title}>
        <picture>
          <source media="(max-width: 640px)" srcSet={images?.mobile} />
          <img
            src={images?.desktop}
            alt={title}
            className="w-full aspect-9/10 sm:aspect-60/19 object-cover"
          />
        </picture>
      </Link>
    </div>
  );
};

export default Banner;
