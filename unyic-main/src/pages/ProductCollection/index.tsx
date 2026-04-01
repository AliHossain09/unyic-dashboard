import useScreenSize from "../../hooks/useScreenSize";
import { useLoaderData, useParams, useSearchParams } from "react-router";
import ProductPageCard from "./components/ProductPageCard";
import clsx from "clsx";
import FilterSortHeader from "./components/desktop/FilterSortHeader";
import FilterSidebar from "./components/desktop/FilterSidebar";
import FilterSortBar from "./components/mobile/FilterSortBar";
import { useCallback, useEffect, useState } from "react";
import {
  useLazyGetProductsFiltersQuery,
  useLazyGetPaginatedProductsQuery,
} from "../../store/features/product/productsApi";
import ProductCollectionSkeleton from "./components/ProductCollectionSkeleton";
import type { Product } from "../../types";

const ProductCollection = () => {
  const { collectionType } = useLoaderData() as { collectionType?: string };
  const { slug } = useParams();

  const [getFilters, { data: filters, isLoading: isFiltersLoading }] =
    useLazyGetProductsFiltersQuery();

  const [getPaginatedProducts, { isLoading: isProductsLoading }] =
    useLazyGetPaginatedProductsQuery();

  const [searchParams] = useSearchParams();
  const [products, setProducts] = useState<Product[]>([]);
  const [totalProducts, setTotalProducts] = useState<number | null>(null);
  const [nextCursor, setNextCursor] = useState<string | null>(null);
  const [hasMore, setHasMore] = useState(false);
  const [isLoadingMore, setIsLoadingMore] = useState(false);

  const buildApiParams = useCallback(
    (cursor?: string | null) => {
      const apiParams = new URLSearchParams();
      const arrayKeys = ["brand", "color", "size"];

      for (const [key, value] of searchParams.entries()) {
        apiParams.append(arrayKeys.includes(key) ? `${key}[]` : key, value);
      }

      apiParams.set("pagination", "cursor");
      if (!apiParams.has("limit")) {
        apiParams.set("limit", "20");
      }

      if (collectionType) {
        apiParams.set("key", collectionType);
      }

      if (slug) {
        apiParams.set("keySlug", slug);
      }

      if (cursor) {
        apiParams.set("cursor", cursor);
      }

      return apiParams.toString();
    },
    [searchParams, collectionType, slug]
  );

  useEffect(() => {
    let isCancelled = false;
    const queryString = buildApiParams();

    getFilters(queryString);

    const fetchFirstPage = async () => {
      try {
        const res = await getPaginatedProducts(queryString).unwrap();
        if (isCancelled) return;

        setProducts(res.products ?? []);
        setTotalProducts(typeof res.total === "number" ? res.total : null);
        setNextCursor(res.nextCursor ?? null);
        setHasMore(Boolean(res.nextCursor));
      } catch {
        if (isCancelled) return;
        setProducts([]);
        setTotalProducts(null);
        setNextCursor(null);
        setHasMore(false);
      }
    };

    fetchFirstPage();

    return () => {
      isCancelled = true;
    };
  }, [buildApiParams, getFilters, getPaginatedProducts]);

  const fetchMoreProducts = useCallback(async () => {
    if (isLoadingMore || !hasMore || !nextCursor) return;
    setIsLoadingMore(true);

    try {
      const queryString = buildApiParams(nextCursor);
      const res = await getPaginatedProducts(queryString).unwrap();

      setProducts((prev) => [...prev, ...(res.products ?? [])]);
      setTotalProducts((prev) =>
        typeof res.total === "number" ? res.total : prev
      );
      setNextCursor(res.nextCursor ?? null);
      setHasMore(Boolean(res.nextCursor));
    } finally {
      setIsLoadingMore(false);
    }
  }, [
    buildApiParams,
    getPaginatedProducts,
    hasMore,
    isLoadingMore,
    nextCursor,
  ]);

  useEffect(() => {
    const handleScroll = () => {
      const nearBottom =
        window.innerHeight + window.scrollY >= document.body.offsetHeight - 250;

      if (nearBottom) {
        void fetchMoreProducts();
      }
    };

    window.addEventListener("scroll", handleScroll, { passive: true });

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, [fetchMoreProducts]);

  const { isDesktopScreen, isMobileScreen } = useScreenSize();

  const isLoading = isFiltersLoading || (isProductsLoading && !products.length);

  if (isLoading) {
    return <ProductCollectionSkeleton />;
  }

  if (!filters) {
    return (
      <div className="ui-container mt-2 lg:mt-6 mb-12">No filters found</div>
    );
  }

  if (products.length === 0) {
    return (
      <div className="ui-container mt-2 lg:mt-6 mb-12">No product found</div>
    );
  }

  console.log(products);

  return (
    <div className="ui-container mt-2 lg:mt-6 mb-12">
      {/* Display total number of products */}
      <p className="mb-4 text-dark-light text-sm sm:text-base">
        Total {totalProducts ?? 0} products
      </p>

      {/* Desktop: Filter and sort header */}
      {isDesktopScreen && <FilterSortHeader />}

      <div
        className={clsx(isDesktopScreen && "grid grid-cols-[1fr_3fr] gap-8")}
      >
        {/* Desktop: Sidebar filters */}
        {isDesktopScreen && <FilterSidebar filters={filters} />}

        {/* Product grid */}
        <div className="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-x-2 sm:gap-x-4 gap-y-8">
          {products.map((product) => (
            <ProductPageCard key={product.id} product={product} />
          ))}
        </div>
      </div>

      {/* Mobile: Bottom filter & sort bar */}
      {isMobileScreen && <FilterSortBar filters={filters} />}

      {isLoadingMore && (
        <p className="text-center text-sm text-gray-500 mt-6">
          Loading more products...
        </p>
      )}
    </div>
  );
};

export default ProductCollection;
