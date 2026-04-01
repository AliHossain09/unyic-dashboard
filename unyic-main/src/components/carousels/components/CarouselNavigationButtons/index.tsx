import { type EmblaCarouselType } from "embla-carousel";
import NavigationButton from "./NavigationButton";
import { useCallback, useEffect, useState } from "react";

interface CarouselNavigationButtonsProps {
  emblaApi: EmblaCarouselType | undefined;
}

const CarouselNavigationButtons = ({
  emblaApi,
}: CarouselNavigationButtonsProps) => {
  const [prevBtnDisabled, setPrevBtnDisabled] = useState(true);
  const [nextBtnDisabled, setNextBtnDisabled] = useState(true);

  const onSelect = useCallback(() => {
    if (!emblaApi) return;
    setPrevBtnDisabled(!emblaApi.canScrollPrev());
    setNextBtnDisabled(!emblaApi.canScrollNext());
  }, [emblaApi]);

  useEffect(() => {
    if (!emblaApi) return;

    onSelect();
    emblaApi.on("select", onSelect).on("init", onSelect).on("reInit", onSelect);

    return () => {
      emblaApi
        .off("select", onSelect)
        .off("init", onSelect)
        .off("reInit", onSelect);
    };
  }, [emblaApi, onSelect]);

  const onPrevButtonClick = useCallback(() => {
    if (!emblaApi) return;
    emblaApi.scrollPrev();
  }, [emblaApi]);

  const onNextButtonClick = useCallback(() => {
    if (!emblaApi) return;
    emblaApi.scrollNext();
  }, [emblaApi]);

  return (
    <>
      <NavigationButton
        position="prev"
        onClick={onPrevButtonClick}
        disabled={prevBtnDisabled}
      />

      <NavigationButton
        position="next"
        onClick={onNextButtonClick}
        disabled={nextBtnDisabled}
      />
    </>
  );
};

export default CarouselNavigationButtons;
