import { TbSearch } from "react-icons/tb";

const ProductNotFound = () => {
  return (
    <div className="min-h-[calc(100dvh-var(--main-nav-h))] grid place-items-center">
      <div className="ui-container text-center">
        <TbSearch className="mx-auto text-4xl" />

        <h3 className="mt-4 font-semibold text-xl">Product Not Found</h3>
        <p className="mt-3 text-dark-light">
          The product you&apos;re looking for doesn&apos;t exist or may have
          been removed.
        </p>
      </div>
    </div>
  );
};

export default ProductNotFound;
