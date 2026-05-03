import { lazy, Suspense } from "react";
import useScreenSize from "../../hooks/useScreenSize";
import BannerCarousel from "./BannerCarousel";
import PopularCategoriesDesktop from "./PopularCategories/PopularCategoriesDesktop";
import PopularCategoriesMobile from "./PopularCategories/PopularCategoriesMobile";

const NewArrivals = lazy(() => import("./NewArrivals"));
const FeaturedCollection = lazy(() => import("./FeaturedCollection"));
const RecommendedProducts = lazy(() => import("./RecommendedProducts"));
const SpotlightBrands = lazy(() => import("./SpotlightBrands"));

const Home = () => {
  const { isDesktopScreen, isMobileScreen } = useScreenSize();

  return (
    <>
      {isMobileScreen && <PopularCategoriesMobile />}
      <BannerCarousel />
      {isDesktopScreen && <PopularCategoriesDesktop />}

      <Suspense fallback={<></>}>
        <NewArrivals />
      </Suspense>

      <Suspense fallback={<></>}>
        <FeaturedCollection />
      </Suspense>

      <Suspense fallback={<></>}>
        <RecommendedProducts />
      </Suspense>
      
      <Suspense fallback={<></>}>
        <SpotlightBrands />
      </Suspense>
    </>
  );
};

export default Home;
