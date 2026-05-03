import useEmblaCarousel from "embla-carousel-react";
import CarouselNavigationButtons from "../components/CarouselNavigationButtons";
import type { Product } from "../../../types/product";
import ProductsCarouselSkeleton from "./ProductsCarouselSkeleton";
import clsx from "clsx";
import ProductCard from "../../cards/ProductCard";

interface ProductsCarouselProps {
  isLoading: boolean;
  products: Product[];
}

const ProductsCarousel = ({ isLoading, products }: ProductsCarouselProps) => {
  const [emblaRef, emblaApi] = useEmblaCarousel({
    active: true,
    align: "start",
    breakpoints: {
      "(max-width: 1022px)": { active: false },
    },
  });

  if (isLoading) {
    return <ProductsCarouselSkeleton />;
  }

  return (
    <div className="relative">
      <div
        ref={emblaRef}
        className="overflow-x-auto hide-scrollable lg:overflow-hidden"
      >
        <div className="flex -ms-3 sm:-ms-5">
          {products.map((product) => (
            <div
              key={product.id}
              className={clsx(
                "w-7/12 sm:w-[35%] lg:w-[25%] xl:w-[20%]",
                "flex-none ps-3 sm:ps-5 p-px"
              )}
            >
              <ProductCard product={product} />
            </div>
          ))}
        </div>
      </div>

      <div className="hidden lg:block">
        <CarouselNavigationButtons emblaApi={emblaApi} />
      </div>
    </div>
  );
};

export default ProductsCarousel;
