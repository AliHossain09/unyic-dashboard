import useEmblaCarousel from "embla-carousel-react";
import NewArrivalCard from "./NewArrivalCard";
import CarouselNavigationButtons from "../../../components/carousels/components/CarouselNavigationButtons";
import clsx from "clsx";
import { useGetLatestCatgoriesQuery } from "../../../store/features/category/categoriesApi";

const NewArrivals = () => {
  const [emblaRef, emblaApi] = useEmblaCarousel({
    active: true,
    align: "start",
    breakpoints: {
      "(max-width: 1022px)": { active: false },
    },
  });

  const { data, error } = useGetLatestCatgoriesQuery();

  if (error) {
    console.warn("Error fetching new arrivals: ", error);
  }

  if (!data || data.length === 0) {
    return null;
  }

  return (
    <section className="mt-responsive ui-container lg:grid grid-cols-[1fr_3fr] lg:gap-5 lg:items-center">
      <header className="mb-8 text-center lg:text-left">
        <h3 className="text-3xl lg:text-4xl font-medium">New Arrivals</h3>
        <p className="mt-1 text-sm lg:text-base">Discover Your Crafts</p>
      </header>

      <div className="relative">
        <div
          ref={emblaRef}
          className="overflow-x-auto hide-scrollable lg:overflow-hidden"
        >
          <div className="flex -ms-3 sm:-ms-5">
            {data.map((item) => (
              <div
                key={item.id}
                className={clsx(
                  "w-7/12 sm:w-[35%] lg:w-[33%]",
                  "flex-none ps-3 sm:ps-5 p-px",
                )}
              >
                <NewArrivalCard item={item} />
              </div>
            ))}
          </div>
        </div>

        <div className="hidden lg:block">
          <CarouselNavigationButtons emblaApi={emblaApi} />
        </div>
      </div>
    </section>
  );
};

export default NewArrivals;
