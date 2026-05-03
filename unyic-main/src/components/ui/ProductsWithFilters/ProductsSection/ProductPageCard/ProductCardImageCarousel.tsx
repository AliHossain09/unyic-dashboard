import useEmblaCarousel from "embla-carousel-react";
import { useCallback, useRef } from "react";
import Autoplay from "embla-carousel-autoplay";
import type { ProductImage } from "../../../../../types/product";

interface ProductCardImageCarouselProps {
  images: ProductImage[];
}

const ProductCardImageCarousel = ({
  images,
}: ProductCardImageCarouselProps) => {
  const autoplay = useRef(
    Autoplay({
      delay: 1600,
      playOnInit: false,
    }),
  );

  const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true }, [
    autoplay.current,
  ]);

  // Start autoplay only when mouse enters
  const handleMouseEnter = useCallback(() => {
    if (emblaApi) autoplay.current.play();
  }, [emblaApi]);

  // Stop autoplay only when mouse leaves
  const handleMouseLeave = useCallback(() => {
    if (emblaApi) {
      autoplay.current.stop();
      emblaApi.scrollTo(0); // Reset to first image
    }
  }, [emblaApi]);

  return (
    <div
      ref={emblaRef}
      className="w-full overflow-hidden"
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
    >
      <div className="flex w-full">
        {images.map((image, index) => (
          <img
            key={index}
            className="shrink-0 w-full product-image-ratio object-cover"
            src={image?.url}
            alt=""
          />
        ))}
      </div>
    </div>
  );
};

export default ProductCardImageCarousel;
