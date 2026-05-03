import { useGetMostViewedProductsQuery } from "../../../store/features/product/productsApi";
import ProductsCarouselSection from "../../../components/carousels/ProductsCarouselSection";

const MostViewedProducts = () => {
  const { data = [], isLoading, error } = useGetMostViewedProductsQuery();

  if (error) {
    console.error("Failed to fetch most viewd products");
    return null;
  }

  return (
    <ProductsCarouselSection
      sectionTitle="Most Viewed Products"
      products={data}
      isProductsLoading={isLoading}
    />
  );
};

export default MostViewedProducts;
