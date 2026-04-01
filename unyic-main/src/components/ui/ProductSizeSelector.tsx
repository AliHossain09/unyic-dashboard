import clsx from "clsx";
import type { ProductSize, ProductSizeItem } from "../../types";

interface ProductSizeSelectorProps {
  sizes: ProductSizeItem[];
  selectedSize: ProductSize | null;
  setSelectedSize: (size: ProductSize) => void;
}

const ProductSizeSelector = ({
  sizes,
  selectedSize,
  setSelectedSize,
}: ProductSizeSelectorProps) => {
  return (
    <div className="flex flex-wrap">
      {sizes.map((item, index) => {
        const { size, quantity } = item || {};

        return (
          <button
            key={index}
            onClick={() => setSelectedSize(size)}
            className={clsx(
              "min-w-12 mb-6 me-3 px-2 py-1 rounded border relative group/size-option",
              size === selectedSize
                ? "bg-primary-dark text-light"
                : "hover:bg-primary-dark hover:text-light"
            )}
          >
            <span className="text-sm">{size}</span>

            {quantity && quantity < 10 && (
              <span
                className={clsx(
                  "w-full pt-1 absolute top-full left-0",
                  "text-center text-xs text-primary-dark font-semibold",
                  size !== selectedSize &&
                    "hidden group-hover/size-option:inline"
                )}
              >
                {quantity} Left
              </span>
            )}
          </button>
        );
      })}
    </div>
  );
};

export default ProductSizeSelector;
