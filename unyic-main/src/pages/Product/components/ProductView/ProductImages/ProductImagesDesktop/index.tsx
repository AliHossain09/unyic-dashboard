import { useState } from "react";
import ImageZoomer from "./ImageZoomer";
import clsx from "clsx";
import type { ProductImage } from "../../../../../../types";

interface ProductImagesDesktopProps {
  images: ProductImage[];
}

const ProductImagesDesktop = ({ images }: ProductImagesDesktopProps) => {
  const [currentIndex, setCurrentIndex] = useState(0);

  const handleMouseOver = (index: number) => {
    setCurrentIndex(index);
  };

  const handleNext = () => {
    setCurrentIndex((prevIndex) => (prevIndex + 1) % images.length);
  };

  const handlePrev = () => {
    setCurrentIndex(
      (prevIndex) => (prevIndex - 1 + images.length) % images.length
    );
  };

  return (
    <div className="flex gap-6 items-start">
      <div className="space-y-2 overflow-hidden overflow-y-auto">
        {images.map((_, index) => {
          const isActive = index === currentIndex; // Determine if the dot is active
          return (
            <figure
              key={index}
              onMouseOver={() => handleMouseOver(index)}
              className="w-28 product-image-ratio"
            >
              <img
                src={images[index]?.url}
                alt={`Dot ${index}`}
                className={clsx(
                  "size-full border object-cover",
                  isActive
                    ? "border-primary-dark rounded"
                    : "border-transparent"
                )}
              />
            </figure>
          );
        })}
      </div>

      <div className="relative flex-1">
        <ImageZoomer
          imageSrc={images[currentIndex]?.url}
          imageAlt={`Product Image ${currentIndex + 1}`}
        />

        {/* Prev arrow */}
        <button
          onClick={handlePrev}
          className="px-4 py-3 bg-light/30 absolute left-0 z-10 top-1/2 -translate-y-1/2"
        >
          &#10094;
        </button>

        {/* Next arrow */}
        <button
          onClick={handleNext}
          className="px-4 py-3 bg-light/30 absolute right-0 z-10 top-1/2 -translate-y-1/2"
        >
          &#10095;
        </button>
      </div>
    </div>
  );
};

export default ProductImagesDesktop;
