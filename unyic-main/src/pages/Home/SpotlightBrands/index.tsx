import { Link } from "react-router";
import { useGetSpotlightBrandsQuery } from "../../../store/features/brand/spotlightBrandsApi";
import { BiSolidLeftArrow, BiSolidRightArrow } from "react-icons/bi";
import clsx from "clsx";

const SpotlightBrands = () => {
  const { data: brands, error } = useGetSpotlightBrandsQuery();

  if (error) {
    console.warn("Error fetching spotlight brands: ", error);
  }

  if (!brands || brands.length === 0) {
    return null;
  }

  return (
    <section className="ui-container mt-responsive mb-12">
      <header className="mb-6 text-center">
        <h4 className="text-sm uppercase font-medium">Brands</h4>
        <h3 className="mt-1 text-2xl lg:text-3xl font-medium text-center flex items-center justify-center gap-2">
          Brand
          <span className="text-primary-dark flex items-center gap-1">
            <BiSolidLeftArrow size={27} className="mt-0.5" />
            <span>Spotlight</span>
            <BiSolidRightArrow size={27} className="mt-0.5" />
          </span>
        </h3>
      </header>

      <div className="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-12">
        {brands.slice(0, 2).map((brand, index) => {
          const { id, image, name, slug } = brand || {};

          return (
            <article key={id}>
              <figure
                className={clsx(
                  "aspect-4/3 bg-gray-200 overflow-hidden",
                  index === 0 && "rounded-ss-[65px]",
                  index === 1 && "rounded-ee-[65px]",
                )}
              >
                <img src={image} alt="" className="size-full object-cover" />
              </figure>

              <h4 className="mt-1 sm:mt-2 text-xl">{name}</h4>

              <Link
                to={`/brand/${slug}`}
                className="text-sm text-primary-dark underline underline-offset-2"
              >
                Shop Now
              </Link>
            </article>
          );
        })}
      </div>
    </section>
  );
};

export default SpotlightBrands;
