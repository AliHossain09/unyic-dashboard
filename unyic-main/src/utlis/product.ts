import { PRODUCT_SIZES } from "../constants/productSizes";
import type { ProductImage, ProductSize } from "../types";

export const getDefaultImageUrl = (images: ProductImage[]) => {
  const image = images.find((img) => img.isDefault) || images[0];
  return image?.url;
};

export function isValidProductSize(size: unknown): size is ProductSize {
  return (
    typeof size === "string" && PRODUCT_SIZES.includes(size as ProductSize)
  );
}
