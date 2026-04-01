import useEmblaCarousel from "embla-carousel-react";
import type { ProductImage } from "../../../../../types";
import CarouselNavigationButtons from "../../../../../components/carousels/components/CarouselNavigationButtons";
import CarouselDots from "../../../../../components/carousels/components/CarouselDots";

interface ProductImagesMobileProps {
  images: ProductImage[];
}

const ProductImagesMobile = ({ images }: ProductImagesMobileProps) => {
  const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true });

  return (
    <div className="relative">
      <div ref={emblaRef} className="overflow-hidden relative">
        <div className="flex">
          {images.map((image, index) => (
            <div key={index} className="flex-none w-full">
              <img
                src={image?.url}
                alt={"Product Image"}
                className="max-w-sm w-full mx-auto product-image-ratio object-cover"
              />
            </div>
          ))}
        </div>

        {/* Navigation Buttons */}
        <CarouselNavigationButtons emblaApi={emblaApi} />
      </div>

      <CarouselDots emblaApi={emblaApi} />
    </div>
  );
};

export default ProductImagesMobile;
