import clsx from "clsx";
import type { Product } from "../../../types/product";
import ProductsCarousel from "../ProductsCarousel";

interface ProductsCarouselSectionProps {
  sectionTitle: string;
  products: Product[];
  isProductsLoading: boolean;
  className?: string;
}

const ProductsCarouselSection = ({
  sectionTitle,
  products,
  isProductsLoading,
  className,
}: ProductsCarouselSectionProps) => {
  return (
    <section
      className={clsx("ui-container mt-responsive mb-responsive", className)}
    >
      <h3 className="mb-6 font-bold text-xl">{sectionTitle}</h3>

      <div className="ps-3">
        <ProductsCarousel products={products} isLoading={isProductsLoading} />
      </div>
    </section>
  );
};

export default ProductsCarouselSection;
