import { forwardRef } from "react";
import type { HTMLAttributes } from "react";
import { VirtuosoGrid } from "react-virtuoso";
import useScreenSize from "../../../../hooks/useScreenSize";
import { useGetProductsInfiniteQuery } from "../../../../store/features/product/productsApi";
import ProductPageCard from "./ProductPageCard";
import ProductsSectionSkeleton from "./ProductsSectionSkeleton";
import SortButtonDesktop from "./SortButtonDesktop";
import clsx from "clsx";
import ProductPageGridSkeleton from "./ProductPageGridSkeleton";

interface ProductsSectionProps {
  queryString: string;
}

const ProductsSection = ({ queryString }: ProductsSectionProps) => {
  const {
    data,
    isLoading,
    isFetching,
    fetchNextPage,
    hasNextPage,
    isFetchingNextPage,
  } = useGetProductsInfiniteQuery({ queryString, limit: 12 });

  const { isDesktopScreen } = useScreenSize();

  if (isLoading || (isFetching && !isFetchingNextPage)) {
    return <ProductsSectionSkeleton />;
  }

  const products = data?.pages.flatMap((page) => page.products) ?? [];

  if (products.length === 0) {
    return (
      <div className="ui-container mt-2 lg:mt-6 mb-12">
        No product found. Try clearing all filters.
      </div>
    );
  }

  return (
    <div>
      {isDesktopScreen && <SortButtonDesktop />}

      <VirtuosoGrid
        key={queryString} // remount on filter change
        data={products}
        useWindowScroll
        increaseViewportBy={{ top: 1200, bottom: 1200 }}
        endReached={() => {
          if (hasNextPage && !isFetchingNextPage) {
            fetchNextPage();
          }
        }}
        components={{
          List: forwardRef<HTMLDivElement, HTMLAttributes<HTMLDivElement>>(
            (props, ref) => (
              <div
                {...props}
                ref={ref}
                className={clsx("products-page-grid", props.className)}
              />
            ),
          ),
          Item: (props) => <div {...props} />,
        }}
        itemContent={(_, product) => (
          <ProductPageCard key={product.id} product={product} />
        )}
      />

      {isFetchingNextPage && <ProductPageGridSkeleton />}
    </div>
  );
};

export default ProductsSection;
