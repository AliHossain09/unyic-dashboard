import { useState } from "react";
import type { ProductSize, ProductSizeItem } from "../types/product";

interface useProductSizeSelectorProps {
  defaultSize?: ProductSize;
  sizes: ProductSizeItem[];
}

const useProductSizeSelector = ({
  defaultSize,
  sizes,
}: useProductSizeSelectorProps) => {
  const initialSize =
    defaultSize ?? (sizes.length === 1 ? sizes[0]?.size : null);

  const [selectedSize, setSelectedSize] = useState<ProductSize | null>(
    initialSize 
  );

  return {
    selectedSize,
    setSelectedSize,
  };
};

export default useProductSizeSelector;
