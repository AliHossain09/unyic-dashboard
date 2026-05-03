import CarouselDotsSkeleton from "../../../components/carousels/components/CarouselDots/CarouselDotsSkeleton";
import BannerSkeleton from "./Banner/BannerSkeleton";

const BannerCarouselSkeleton = () => {
  return (
    <section>
      <BannerSkeleton/>
      <CarouselDotsSkeleton />
    </section>
  );
};

export default BannerCarouselSkeleton;