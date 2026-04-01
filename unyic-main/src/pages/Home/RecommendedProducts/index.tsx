import ProductsCarousel from "../../../components/carousels/ProductsCarousel";
import { useGetRecommendedProductsQuery } from "../../../store/features/product/recommendedProductsApi";

const RecommendedProducts = () => {
  const { data: products = [], isLoading } = useGetRecommendedProductsQuery();

  return (
    <section className="mt-responsive py-14 bg-[#eeedec]">
      <h3 className="text-2xl lg:text-3xl text-center">Recommended For You</h3>

      <div className="mt-8 ui-container">
        <ProductsCarousel isLoading={isLoading} products={products} />
      </div>
    </section>
  );
};

export default RecommendedProducts;
