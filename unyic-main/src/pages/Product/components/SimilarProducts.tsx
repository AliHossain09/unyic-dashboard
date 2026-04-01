import ProductShowcaseSection from "../../../components/ui/ProductShowcaseSection";
import similarProductsData from "../../../data/similarProductsData";

const SimilarProducts = () => {
  return (
    <ProductShowcaseSection
      title="Similar Products"
      products={similarProductsData}
    />
  );
};

export default SimilarProducts;
