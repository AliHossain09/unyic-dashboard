import useScreenSize from "../../../../../hooks/useScreenSize";
import type { ProductImage } from "../../../../../types";
import ProductImagesDesktop from "./ProductImagesDesktop";
import ProductImagesMobile from "./ProductImagesMobile";

interface ProductImagesProps {
  images: ProductImage[];
}

const ProductImages = ({ images }: ProductImagesProps) => {
  const { isDesktopScreen } = useScreenSize();

  if (isDesktopScreen) {
    return <ProductImagesDesktop images={images} />;
  }

  return <ProductImagesMobile images={images} />;
};

export default ProductImages;
