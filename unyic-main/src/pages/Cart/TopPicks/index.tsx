import ProductsCarouselSection from "../../../components/carousels/ProductsCarouselSection";
import { useGetTopPicksProductsQuery } from "../../../store/features/product/productsApi";

const TopPicks = () => {
  const { data = [], isLoading, error } = useGetTopPicksProductsQuery();

  if (error) {
    console.error("Failed to fetch most viewd products");
    return null;
  }

  return (
    <ProductsCarouselSection
      sectionTitle="Top Picks For You"
      products={data}
      isProductsLoading={isLoading}
    />
  );
};

export default TopPicks;
