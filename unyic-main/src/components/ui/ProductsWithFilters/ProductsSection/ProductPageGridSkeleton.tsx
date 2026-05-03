import ProductPageCardSkeleton from "./ProductPageCard/ProductPageCardSkeleton";

const ProductPageGridSkeleton = () => {
  return (
    <div className="products-page-grid">
      {[...Array(2)].map((_, index) => (
        <ProductPageCardSkeleton key={index} />
      ))}

      <ProductPageCardSkeleton className="hidden md:block" />
      <ProductPageCardSkeleton className="hidden xl:block" />
    </div>
  );
};

export default ProductPageGridSkeleton;
