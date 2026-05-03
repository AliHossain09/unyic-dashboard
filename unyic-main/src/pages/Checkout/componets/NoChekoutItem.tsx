import { TbShoppingCartCancel } from "react-icons/tb";
import Button from "../../../components/ui/Button";

const NoChekoutItem = () => {
  return (
    <div className="h-[calc(100dvh-var(--main-nav-h))] grid place-items-center">
      <div className="ui-container text-center">
        <TbShoppingCartCancel className="mx-auto text-6xl" />

        <h3 className="mt-4 font-semibold text-xl">Nothing to checkout</h3>

        <p className="max-w-lg mt-3 text-dark-light">
          You haven’t added any items yet. Start shopping and your items will
          appear here when you're ready to checkout.
        </p>

        <Button href="/" className="w-max px-6 mx-auto mt-6">
          Browse Products
        </Button>
      </div>
    </div>
  );
};

export default NoChekoutItem;
