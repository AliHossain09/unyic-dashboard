import { LuSearchX } from "react-icons/lu";
import Button from "../../../components/ui/Button";

interface NoSearchResultFoundProps {
  searchQuery: string;
}

const NoSearchResultFound = ({ searchQuery }: NoSearchResultFoundProps) => {
  return (
    <div className="h-[calc(100dvh-var(--main-nav-h))] grid place-items-center">
      <div className="ui-container text-center">
        <LuSearchX className="mx-auto text-6xl" />

        <h3 className="mt-4 font-semibold text-xl">
          No results found for '{searchQuery}'
        </h3>

        <p className="max-w-lg mt-3 text-dark-light">
          Sorry, we couldn't find any products matching your search. Try using
          different keywords or browse our collections.
        </p>

        <Button href="/" className="w-max px-6 mx-auto mt-6">
          Browse Products
        </Button>
      </div>
    </div>
  );
};

export default NoSearchResultFound;
