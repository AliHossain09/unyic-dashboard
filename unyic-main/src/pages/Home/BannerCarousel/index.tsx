import useEmblaCarousel from "embla-carousel-react";
import CarouselNavigationButtons from "../../../components/carousels/components/CarouselNavigationButtons";
import Autoplay from "embla-carousel-autoplay";
import CarouselDots from "../../../components/carousels/components/CarouselDots";
import Banner from "./Banner";
import { useGetBannersQuery } from "../../../store/features/banner/bannerApi";
import BannerCarouselSkeleton from "./BannerCarouselSkeleton";

const BannerCarousel = () => {
  const { data: banners = [], isLoading } = useGetBannersQuery();

  const [emblaRef, emblaApi] = useEmblaCarousel({ loop: true }, [
    Autoplay({ delay: 4000, stopOnInteraction: false, stopOnMouseEnter: true }),
  ]);

  if (isLoading) {
    return <BannerCarouselSkeleton />;
  }

  if (banners.length === 0) {
    return <>No banners found</>;
  }

  return (
    <section>
      <div ref={emblaRef} className="overflow-hidden relative">
        <div className="flex">
          {banners.map((banner) => (
            <Banner key={banner.id} banner={banner} />
          ))}
        </div>

        {/* Navigation Buttons */}
        <CarouselNavigationButtons emblaApi={emblaApi} />
      </div>

      <CarouselDots emblaApi={emblaApi} />
    </section>
  );
};

export default BannerCarousel;
