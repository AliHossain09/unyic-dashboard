import ProductShowcaseSection from "../../../components/ui/ProductShowcaseSection";
import similarProductsData from "../../../data/similarProductsData";

const PeopleAlsoViewed = () => {
  return (
    <ProductShowcaseSection
      title="People Also Viewed"
      products={similarProductsData}
    />
  );
};

export default PeopleAlsoViewed;
