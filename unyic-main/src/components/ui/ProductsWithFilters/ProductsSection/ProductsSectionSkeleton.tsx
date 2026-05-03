import useScreenSize from "../../../../hooks/useScreenSize";
import ProductPageGridSkeleton from "./ProductPageGridSkeleton";
import ShortByButtonSkeleton from "./SortButtonDesktop/SortButtonDesktopSkeleton";

const ProductsSectionSkeleton = () => {
  const { isDesktopScreen } = useScreenSize();

  return (
    <div>
      {isDesktopScreen && <ShortByButtonSkeleton />}

      <ProductPageGridSkeleton />
    </div>
  );
};

export default ProductsSectionSkeleton;
