import clsx from "clsx";
import { type EmblaCarouselType } from "embla-carousel";
import { useCallback, useEffect, useState } from "react";

interface CarouselDotsProps {
  emblaApi: EmblaCarouselType | undefined;
}

const CarouselDots = ({ emblaApi }: CarouselDotsProps) => {
  const [selectedIndex, setSelectedIndex] = useState(0);
  const [scrollSnaps, setScrollSnaps] = useState<number[]>([]);

  const onInit = useCallback((emblaApi: EmblaCarouselType) => {
    setScrollSnaps(emblaApi.scrollSnapList());
  }, []);

  const onSelect = useCallback((emblaApi: EmblaCarouselType) => {
    setSelectedIndex(emblaApi.selectedScrollSnap());
  }, []);

  useEffect(() => {
    if (!emblaApi) return;

    // eslint-disable-next-line react-hooks/set-state-in-effect
    onInit(emblaApi);
    onSelect(emblaApi);
    emblaApi.on("reInit", onInit).on("reInit", onSelect).on("select", onSelect);
  }, [emblaApi, onInit, onSelect]);

  const onDotButtonClick = useCallback(
    (index: number) => {
      if (!emblaApi) return;
      emblaApi.scrollTo(index);
    },
    [emblaApi]
  );

  return (
    <div className="mt-3 sm:mt-4 flex justify-center items-center">
      {scrollSnaps.map((_, index) => (
        <button key={index} onClick={() => onDotButtonClick(index)} className="p-1.5">
          <span
            className={clsx(
              "block size-2.25 rotate-45 border-2 duration-300 transition-all ease-in-out",
              index === selectedIndex ? "border-primary" : "border-primary/40"
            )}
          />
        </button>
      ))}
    </div>
  );
};

export default CarouselDots;
