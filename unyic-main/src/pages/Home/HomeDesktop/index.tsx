import Brands from "../Shared/Brands";
import FeaturedCollections from "../Shared/FeaturedCollections";
import FinestCollection from "../Shared/FinestCollection";
import NewArrivalsDesktop from "./NewArrivalsDesktop";
import PopularCategoriesDesktop from "./PopularCategoriesDesktop";
import CollectionHighlights from "./CollectionHighlights";

const HomeDesktop = () => {
  return (
    <>
      <PopularCategoriesDesktop />
      <NewArrivalsDesktop />
      <CollectionHighlights />
      <FeaturedCollections />
      <FinestCollection />
      <Brands />
    </>
  );
};

export default HomeDesktop;
