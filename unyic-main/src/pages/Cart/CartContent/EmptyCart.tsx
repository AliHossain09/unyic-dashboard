import { TbShoppingBagSearch } from "react-icons/tb";
import Button from "../../../components/ui/Button";

const EmptyCart = () => {
  return (
    <div className="h-[calc(100dvh-var(--main-nav-h))] grid place-items-center">
      <div className="ui-container text-center">
        <TbShoppingBagSearch className="mx-auto text-6xl" />

        <h3 className="mt-4 font-semibold text-xl">
          Your shopping bag is empty
        </h3>

        <p className="mt-3 text-dark-light">
          Looks like you haven&apos;t added anything to your shopping bag yet.
        </p>

        <Button href="/" className="w-max px-6 mx-auto mt-6">
          Go Shopping
        </Button>
      </div>
    </div>
  );
};

export default EmptyCart;