import useScreenSize from "../../hooks/useScreenSize";
import BannerCarousel from "./BannerCarousel";
import PopularCategoriesDesktop from "./PopularCategories/PopularCategoriesDesktop";
import PopularCategoriesMobile from "./PopularCategories/PopularCategoriesMobile";
import RecommendedProducts from "./RecommendedProducts";

const Home = () => {
  const { isDesktopScreen, isMobileScreen } = useScreenSize();

  return (
    <>
      {isMobileScreen && <PopularCategoriesMobile />}
      <BannerCarousel />

      {isDesktopScreen && <PopularCategoriesDesktop />}
      <RecommendedProducts />
    </>
  );
};

export default Home;
