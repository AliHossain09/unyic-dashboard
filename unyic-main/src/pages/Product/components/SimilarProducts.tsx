import ProductsCarouselSection from "../../../components/carousels/ProductsCarouselSection";
import { useGetSimilarProductsQuery } from "../../../store/features/product/productsApi";

interface SimilarProductsProps {
  productSlug: string | undefined;
}

const SimilarProducts = ({ productSlug }: SimilarProductsProps) => {
  const {
    data = [],
    isLoading,
    error,
  } = useGetSimilarProductsQuery({ productSlug });

  if (error) {
    console.error("Failed to fetch similar products");
    return null;
  }

  return (
    <ProductsCarouselSection
      sectionTitle="Similar Products"
      products={data}
      isProductsLoading={isLoading}
    />
  );
};

export default SimilarProducts;
