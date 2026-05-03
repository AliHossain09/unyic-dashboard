import useScreenSize from "../../../../hooks/useScreenSize";

const ProductFiltersSkeleton = () => {
  const { isDesktopScreen } = useScreenSize();

  return (
    <div>
      <p className="h-6 w-40 lg:my-6 rounded bg-gray-200 animate-pulse" />

      {isDesktopScreen && <div className="h-74.5 bg-gray-200 animate-pulse" />}
    </div>
  );
};

export default ProductFiltersSkeleton;
