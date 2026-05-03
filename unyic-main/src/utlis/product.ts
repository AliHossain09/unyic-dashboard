import { FILTER_KEYS } from "../constants/filterKeys";
import { PRODUCT_SIZES } from "../constants/productSizes";
import type { ProductImage, ProductSize } from "../types/product";

export const getDefaultImageUrl = (images: ProductImage[]) => {
  const image = images.find((img) => img.isDefault) || images[0];
  return image?.url;
};

export function isValidProductSize(size: unknown): size is ProductSize {
  return (
    typeof size === "string" && PRODUCT_SIZES.includes(size as ProductSize)
  );
}

export const hasActiveProductFilters = (searchParams: URLSearchParams) => {
  return FILTER_KEYS.some((key) => searchParams.has(key));
};

type BuildProductsQueryStringArgs =
  | {
      searchParams: URLSearchParams;
      collectionType?: string | null;
      slug?: string | null;
    }
  | {
      searchParams: URLSearchParams;
      searchQuery: string;
    };

export const buildProductsQueryString = (
  args: BuildProductsQueryStringArgs,
) => {
  const apiParams = new URLSearchParams();
  const arrayKeys = ["brand", "color", "size"];

  for (const [key, value] of args.searchParams.entries()) {
    apiParams.append(arrayKeys.includes(key) ? `${key}[]` : key, value);
  }

  if ("searchQuery" in args) {
    apiParams.append("search_query", args.searchQuery);
  } else {
    const { collectionType, slug } = args;

    if (collectionType) apiParams.append("key", collectionType);
    if (slug) apiParams.append("keySlug", slug);
  }

  return apiParams.toString();
};
