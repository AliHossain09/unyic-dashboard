import ProductView from "./components/ProductView";

import { useParams } from "react-router";
import { useGetProductBySlugQuery } from "../../store/features/product/productApi";
import ProductViewSkeleton from "./components/ProductView/ProductViewSkeleton";
import ProductNotFound from "./components/ProductView/ProductNotFound";

const Product = () => {
  const { productSlug } = useParams();
  const { data: product, isLoading } = useGetProductBySlugQuery(productSlug);

  if (isLoading) {
    return <ProductViewSkeleton />;
  }

  if (!product) {
    return <ProductNotFound />;
  }

  return (
    <>
      <ProductView product={product} />

      {/* <SimilarProducts />
      <PeopleAlsoViewed /> */}
    </>
  );
};

export default Product;
