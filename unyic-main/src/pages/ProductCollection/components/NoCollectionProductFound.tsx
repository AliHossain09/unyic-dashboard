import { LuPackageSearch } from "react-icons/lu";
import Button from "../../../components/ui/Button";

const NoCollectionProductFound = () => {
  return (
    <div className="h-[calc(100dvh-var(--main-nav-h))] grid place-items-center">
      <div className="ui-container text-center">
        <LuPackageSearch className="mx-auto text-6xl" />

        <h3 className="mt-4 font-semibold text-xl">
          No products found in this collection
        </h3>

        <p className="max-w-lg mt-3 text-dark-light">
          This collection does not have any products right now. Browse all
          products to discover more items you may like.
        </p>

        <Button href="/" className="w-max px-6 mx-auto mt-6">
          Browse Products
        </Button>
      </div>
    </div>
  );
};

export default NoCollectionProductFound;
